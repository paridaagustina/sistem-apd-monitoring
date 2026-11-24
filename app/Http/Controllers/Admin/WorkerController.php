<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkerController extends Controller
{
    /**
     * Menampilkan seluruh daftar pekerja dan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $workers = Worker::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('position', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('name')
            ->get();

        return view('admin.workers.index', compact(
            'workers',
            'search'
        ));
    }

    /**
     * Menampilkan form tambah pekerja.
     */
    public function create()
    {
        return view('admin.workers.create');
    }

    /**
     * Menyimpan data pekerja baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'position' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
            'position.required' => 'Jabatan wajib diisi.',
        ]);

        // Membuat kode pekerja otomatis.
        do {
            $workerCode = 'WK-' . Str::upper(Str::random(8));
        } while (Worker::where('worker_code', $workerCode)->exists());

        // Menyimpan foto jika admin mengunggah foto.
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('workers', 'public');
        }

        // Mengisi kolom database yang tidak ditampilkan di form.
        $validated['worker_code'] = $workerCode;
        $validated['user_id'] = null;
        $validated['department'] = null;
        $validated['notes'] = null;
        $validated['is_active'] = true;

        Worker::create($validated);

        return redirect()
            ->route('admin.workers.index')
            ->with('success', 'Data pekerja berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pekerja.
     */
    public function edit(Worker $worker)
    {
        return view('admin.workers.edit', compact('worker'));
    }

    /**
     * Memperbarui data pekerja.
     */
    public function update(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'position' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
            'position.required' => 'Jabatan wajib diisi.',
        ]);

        // Mengganti foto jika ada foto baru.
        if ($request->hasFile('photo')) {
            $fotoLama = $worker->photo;

            $fotoBaru = $request->file('photo')
                ->store('workers', 'public');

            $validated['photo'] = $fotoBaru;

            // Menghapus foto lama setelah foto baru berhasil disimpan.
            if ($fotoLama) {
                Storage::disk('public')->delete($fotoLama);
            }
        }

        $worker->update($validated);

        return redirect()
            ->route('admin.workers.index')
            ->with('success', 'Data pekerja berhasil diperbarui.');
    }

    /**
     * Mengaktifkan atau menonaktifkan pekerja.
     */
    public function toggleStatus(Worker $worker)
    {
        $worker->update([
            'is_active' => ! $worker->is_active,
        ]);

        return redirect()
            ->route('admin.workers.index')
            ->with(
                'success',
                $worker->is_active
                    ? 'Pekerja berhasil diaktifkan.'
                    : 'Pekerja berhasil dinonaktifkan.'
            );
    }

    /**
     * Menghapus data pekerja.
     */
    public function destroy(Worker $worker)
    {
        // Memeriksa apakah pekerja masih memiliki riwayat inspeksi APD.
        if ($worker->inspections()->exists()) {
            return redirect()
                ->route('admin.workers.index')
                ->with(
                    'error',
                    'Data pekerja tidak dapat dihapus karena masih memiliki riwayat inspeksi APD.'
                );
        }

        // Menghapus foto pekerja dari penyimpanan.
        if ($worker->photo) {
            Storage::disk('public')->delete($worker->photo);
        }

        // Menghapus data pekerja dari database.
        $worker->delete();

        return redirect()
            ->route('admin.workers.index')
            ->with('success', 'Data pekerja berhasil dihapus.');
    }
}