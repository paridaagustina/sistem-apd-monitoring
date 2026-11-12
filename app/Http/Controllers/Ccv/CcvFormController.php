<?php

namespace App\Http\Controllers\Ccv;

use App\Http\Controllers\Controller;
use App\Models\CcvObservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CcvFormController extends Controller
{
    /**
     * Pertanyaan RC1.
     */
    private function questionsRC1(): array
    {
        return [
            [
                'key' => 'rc1_apd',
                'text' => 'Menggunakan APD (Sarung Tangan, Sepatu Safety, Helm) pada saat pekerjaan.',
                'evidence' => 'rc1_apd',
            ],
            [
                'key' => 'rc1_pembebasan_tegangan',
                'text' => 'Melakukan pembebasan tegangan dari semua sumber tegangan.',
                'evidence' => null,
            ],
            [
                'key' => 'rc1_cek_tegangan',
                'text' => 'Memastikan jaringan (lokasi pekerjaan) tidak bertegangan dengan alat ukur / detector tegangan.',
                'evidence' => 'rc1_cek_tegangan',
            ],
            [
                'key' => 'rc1_grounding',
                'text' => 'Mengukur dan memasang Grounding pada jaringan (lokasi pekerjaan).',
                'evidence' => 'rc1_grounding',
            ],
        ];
    }

    /**
     * Pertanyaan RC3.
     */
    private function questionRC3(): array
    {
        return [
            'key' => 'rc3_aktivitas_risiko_lain',
            'text' => 'Apakah masih ada aktivitas observasi risiko lainnya pada pekerjaan ini selain bekerja pada jaringan bertegangan?',
            'options' => [
                'ada_tidak_bertegangan' => 'Ada, bekerja pada jaringan tidak bertegangan.',
                'ada_ketinggian' => 'Ada, bekerja pada ketinggian.',
                'tidak_ada' => 'Tidak ada.',
            ],
        ];
    }

    /**
     * Menampilkan formulir CCV.
     */
    public function create()
    {
        $questions = $this->questionsRC1();
        $rc3Question = $this->questionRC3();

        return view('pekerja.ccv.create', compact(
            'questions',
            'rc3Question'
        ));
    }

    /**
     * Menyimpan formulir CCV.
     */
    public function store(Request $request)
    {
        $selectedRC = $request->input('selected_rc');

        $request->validate([
            'selected_rc' => [
                'required',
                Rule::in(['RC1', 'RC2', 'RC3']),
            ],
        ], [
            'selected_rc.required' => 'Pilih salah satu Risk Containment.',
            'selected_rc.in' => 'Pilihan Risk Containment tidak valid.',
        ]);

        // RC2 belum dapat dikirim karena pertanyaan detailnya
        // belum tersedia.
        if ($selectedRC === 'RC2') {
            return back()
                ->withInput()
                ->withErrors([
                    'selected_rc' => 'Formulir RC2 belum dapat dikirim karena detail pertanyaannya belum tersedia.',
                ]);
        }

        $rules = [
            'observer_name' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],

            'work_location' => ['required', 'string', 'max:255'],
            'work_order_number' => ['nullable', 'string', 'max:255'],
            'executing_unit' => ['required', 'string', 'max:255'],
            'customer_service_unit' => ['nullable', 'string', 'max:255'],

            'supervisor_present' => [
                'required',
                Rule::in(['ya', 'tidak']),
            ],
        ];

        $questions = $this->questionsRC1();
        $rc3Question = $this->questionRC3();

        if ($selectedRC === 'RC1') {
            foreach ($questions as $question) {
                $rules['answers.' . $question['key']] = [
                    'required',
                    Rule::in(['ya', 'tidak']),
                ];
            }

            $rules['evidence.rc1_apd'] = [
                'required', 'image', 'max:10240',
            ];

            $rules['evidence.rc1_cek_tegangan'] = [
                'required', 'image', 'max:10240',
            ];

            $rules['evidence.rc1_grounding'] = [
                'required', 'image', 'max:10240',
            ];

            $rules['evidence.rc1_pelaksanaan'] = [
                'required', 'image', 'max:10240',
            ];
        }

        if ($selectedRC === 'RC3') {
            $rules['rc3_answer'] = [
                'required',
                Rule::in(array_keys($rc3Question['options'])),
            ];
        }

        $validated = $request->validate($rules, [
            'required' => ':attribute wajib diisi.',
            'image' => 'Bukti harus berupa file gambar.',
            'max' => 'Ukuran gambar maksimal 10 MB.',
            'answers.*.in' => 'Pilih YA atau TIDAK.',
            'rc3_answer.in' => 'Pilihan jawaban RC3 tidak valid.',
        ]);

        $storedFiles = [];

        try {
            DB::beginTransaction();

            $observation = CcvObservation::create([
                'user_id' => $request->user()->id,
                'observer_name' => $validated['observer_name'],
                'company' => $validated['company'],
                'position' => $validated['position'],
                'department' => $validated['department'] ?? null,

                'unit_induk' => 'UID KALSELTENG',
                'work_location' => $validated['work_location'],
                'work_order_number' => $validated['work_order_number'] ?? null,
                'executing_unit' => $validated['executing_unit'],
                'customer_service_unit' => $validated['customer_service_unit'] ?? null,

                'supervisor_present' => $validated['supervisor_present'] === 'ya',
                'risk_code' => $selectedRC,
                'other_risk' => null,
                'submitted_at' => now(),
            ]);

            // Simpan jawaban RC1.
            if ($selectedRC === 'RC1') {
                foreach ($questions as $question) {
                    $answer = $observation->answers()->create([
                        'risk_code' => 'RC1',
                        'question_key' => $question['key'],
                        'question_text' => $question['text'],
                        'answer' => $validated['answers'][$question['key']],
                    ]);

                    if ($question['evidence']) {
                        $file = $request->file(
                            'evidence.' . $question['evidence']
                        );

                        $this->saveEvidence(
                            $answer,
                            $file,
                            $storedFiles
                        );
                    }

                    // Foto pelaksanaan disimpan sebagai bukti
                    // tambahan pada pertanyaan grounding.
                    if ($question['key'] === 'rc1_grounding') {
                        $file = $request->file(
                            'evidence.rc1_pelaksanaan'
                        );

                        $this->saveEvidence(
                            $answer,
                            $file,
                            $storedFiles
                        );
                    }
                }
            }

            // Simpan satu jawaban RC3.
            if ($selectedRC === 'RC3') {
                $observation->answers()->create([
                    'risk_code' => 'RC3',
                    'question_key' => $rc3Question['key'],
                    'question_text' => $rc3Question['text'],
                    'answer' => $validated['rc3_answer'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('pekerja.ccv.create')
                ->with(
                    'success',
                    "Laporan CCV {$selectedRC} berhasil dikirim."
                );

        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($storedFiles)) {
                Storage::disk('public')->delete($storedFiles);
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Laporan CCV gagal disimpan. Silakan coba lagi.'
                );
        }
    }

    /**
     * Menyimpan bukti foto.
     */
    private function saveEvidence(
        $answer,
        $file,
        array &$storedFiles
    ): void {
        $path = $file->store('ccv-evidence', 'public');

        $storedFiles[] = $path;

        $answer->evidences()->create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }
}