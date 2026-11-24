<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HealthCheckController extends Controller
{
    /**
     * Daftar pilihan formulir.
     */
    private function formOptions(): array
    {
        return [
            'units' => [
                'ULP Gambut',
                'ULP Ahmad Yani',
                'ULP Lambung Mangkurat',
                'ULP Banjarbaru',
                'ULP Marabahan',
                'ULP Pelaihari',
                'ULP Martapura',
            ],

            'ages' => [
                'Remaja (14-18 Tahun)',
                'Dewasa (19-40 Tahun)',
                'Dewasa (41-60 Tahun)',
                'Lansia (>60 Tahun)',
            ],

            'companies' => [
                'PLN NUSA DAYA',
                'TUBP',
                'GRAHA ARTA',
                'Other',
            ],

            'petugasNames' => [
                'MUHAMMAD PAISAL ALPARISI',
                'SAMSIR NUR ALAM',
                'ALPI YANOOR',
                'RAHMADI',
                'TRIYONO',
                'MUHAMMAD NOFIE',
                'FAUZI',
                'IMAN SAPUTRA',
                'FAHRIANNOR',
                'MASRI',
                'NANANG ISWAHYUDI',
                'MAKSUM',
                'AGUS SUGIYONO',
                'HANDOYO SAPUTRO',
                'IWAN HARTONO',
                'SUBHAN RAMADHAN PRATAMA',
                'AHMAD RIFANI',
                'HENDRA',
                'MUHAMAD RENALDI',
                'AKHMAD KAMAL FAHRIYANUR',
                'AHMAD ANSOR',
                'SLAMET SETIAWAN',
                'MUHAMMAD KHALILUR RAHMAN',
                'SUKMA KELANA PUTRA',
                'ARJUN PRASETYO W',
                'MUHAMMAD AGUS RIDANI',
                'ABDUL MAJID',
                "MUHAMMAD RAPI'I AKBAR",
                'ASTIMAWANTO',
                'DWI PUSPITA SARI',
            ],
        ];
    }

    /**
     * Menampilkan formulir pemeriksaan kesehatan.
     */
    public function create(): View
    {
        $options = $this->formOptions();

        return view('pekerja.health-check.create', $options);
    }

    /**
     * Menyimpan hasil pemeriksaan kesehatan.
     */
    public function store(Request $request): RedirectResponse
    {
        $options = $this->formOptions();

        $validated = $request->validate([
            'nama_petugas' => [
                'required',
                'string',
                Rule::in($options['petugasNames']),
            ],

            'unit' => [
                'required',
                Rule::in($options['units']),
            ],

            'tanggal_periksa' => [
                'required',
                'date',
            ],

            'usia' => [
                'required',
                Rule::in($options['ages']),
            ],

            'perusahaan' => [
                'required',
                Rule::in($options['companies']),
            ],

            'sistolik' => [
                'required',
                'integer',
                'min:1',
                'max:300',
            ],

            'diastolik' => [
                'required',
                'integer',
                'min:1',
                'max:200',
            ],

            'hasil_oximeter' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ], [
            'nama_petugas.required' => 'Nama petugas wajib dipilih.',
            'nama_petugas.in' => 'Nama petugas tidak valid.',
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka.',
            'unit.in' => 'Pilihan unit tidak valid.',
            'usia.in' => 'Kategori usia tidak valid.',
            'perusahaan.in' => 'Pilihan perusahaan tidak valid.',
            'hasil_oximeter.max' => 'Nilai oximeter maksimal 100%.',
        ]);

        // Rentang tekanan darah berdasarkan kategori usia.
        $ranges = [
            'Remaja (14-18 Tahun)' => [
                'sistolik' => [90, 120],
                'diastolik' => [50, 80],
            ],

            'Dewasa (19-40 Tahun)' => [
                'sistolik' => [95, 125],
                'diastolik' => [60, 80],
            ],

            'Dewasa (41-60 Tahun)' => [
                'sistolik' => [110, 145],
                'diastolik' => [70, 90],
            ],

            'Lansia (>60 Tahun)' => [
                'sistolik' => [95, 145],
                'diastolik' => [70, 90],
            ],
        ];

        $range = $ranges[$validated['usia']];

        $statusSistolik = $this->classifyBloodPressure(
            (int) $validated['sistolik'],
            $range['sistolik'][0],
            $range['sistolik'][1]
        );

        $statusDiastolik = $this->classifyBloodPressure(
            (int) $validated['diastolik'],
            $range['diastolik'][0],
            $range['diastolik'][1]
        );

        $statusTensi = (
            $statusSistolik === 'Normal' &&
            $statusDiastolik === 'Normal'
        ) ? 'Normal' : 'Tidak Normal';

        $statusOximeter = (int) $validated['hasil_oximeter'] >= 94
            ? 'Normal'
            : 'Tidak Normal';

        $kesimpulan = (
            $statusTensi === 'Normal' &&
            $statusOximeter === 'Normal'
        )
            ? 'SIAP BEKERJA'
            : 'TIDAK DISARANKAN BEKERJA';

        HealthCheck::create([
            'user_id' => Auth::id(),

            'nama_petugas' => $validated['nama_petugas'],
            'unit' => $validated['unit'],
            'tanggal_periksa' => $validated['tanggal_periksa'],
            'usia' => $validated['usia'],
            'perusahaan' => $validated['perusahaan'],

            'sistolik' => $validated['sistolik'],
            'diastolik' => $validated['diastolik'],

            'status_sistolik' => $statusSistolik,
            'status_diastolik' => $statusDiastolik,
            'status_tensi' => $statusTensi,

            'hasil_oximeter' => $validated['hasil_oximeter'],
            'status_oximeter' => $statusOximeter,

            'kesimpulan' => $kesimpulan,
        ]);

        return redirect()
            ->route('pekerja.health-check.create')
            ->with('success', 'Pemeriksaan kesehatan berhasil disimpan.');
    }

    /**
     * Menampilkan riwayat pemeriksaan milik akun yang login.
     */
    public function history(Request $request): View
    {
        $userId = Auth::id();

        $namaPetugas = $request->query('nama_petugas');

        $healthChecks = HealthCheck::where('user_id', $userId)
            ->when($namaPetugas, function ($query) use ($namaPetugas) {
                $query->where('nama_petugas', $namaPetugas);
            })
            ->orderByDesc('tanggal_periksa')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('pekerja.health-check.history', compact(
            'healthChecks',
            'namaPetugas'
        ));
    }

    /**
     * Menampilkan detail pemeriksaan milik akun yang login.
     */
    public function detail(HealthCheck $healthCheck): View
    {
        // Memastikan pemeriksaan merupakan milik akun yang login.
        abort_unless(
            (int) $healthCheck->user_id === (int) Auth::id(),
            403
        );

        return view('pekerja.health-check.detail', compact(
            'healthCheck'
        ));
    }

    /**
     * Mengklasifikasikan tekanan darah.
     */
    private function classifyBloodPressure(
        int $value,
        int $minimum,
        int $maximum
    ): string {
        if ($value < $minimum) {
            return 'Rendah';
        }

        if ($value > $maximum) {
            return 'Tinggi';
        }

        return 'Normal';
    }
}