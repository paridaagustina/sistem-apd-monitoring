<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApdItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApdItemController extends Controller
{
    /**
     * Menampilkan daftar master APD.
     */
    public function index()
    {
        $items = ApdItem::query()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.apd-items.index', compact('items'));
    }

    /**
     * Menampilkan formulir tambah APD.
     */
    public function create()
    {
        return view('admin.apd-items.create');
    }

    /**
     * Menyimpan APD baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:apd_items,code',
            ],
            'is_required' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ], [
            'name.required' => 'Nama APD wajib diisi.',
            'name.max' => 'Nama APD maksimal 100 karakter.',
            'code.required' => 'Kode APD wajib diisi.',
            'code.alpha_dash' => 'Kode hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'code.unique' => 'Kode APD sudah digunakan.',
            'is_required.required' => 'Pilih apakah APD wajib digunakan.',
            'is_active.required' => 'Pilih status APD.',
        ]);

        ApdItem::create($validated);

        return redirect()
            ->route('admin.apd-items.index')
            ->with('success', 'Jenis APD berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit APD.
     */
    public function edit(ApdItem $apdItem)
    {
        return view('admin.apd-items.edit', compact('apdItem'));
    }

    /**
     * Memperbarui data APD.
     */
    public function update(Request $request, ApdItem $apdItem)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('apd_items', 'code')->ignore($apdItem->id),
            ],
            'is_required' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ], [
            'name.required' => 'Nama APD wajib diisi.',
            'code.required' => 'Kode APD wajib diisi.',
            'code.unique' => 'Kode APD sudah digunakan.',
            'code.alpha_dash' => 'Kode hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
        ]);

        $apdItem->update($validated);

        return redirect()
            ->route('admin.apd-items.index')
            ->with('success', 'Data APD berhasil diperbarui.');
    }

    /**
     * Mengaktifkan atau menonaktifkan APD.
     * Data tidak dihapus dari database.
     */
    public function toggleStatus(ApdItem $apdItem)
    {
        $apdItem->update([
            'is_active' => ! $apdItem->is_active,
        ]);

        $pesan = $apdItem->is_active
            ? 'Jenis APD berhasil diaktifkan.'
            : 'Jenis APD berhasil dinonaktifkan.';

        return redirect()
            ->route('admin.apd-items.index')
            ->with('success', $pesan);
    }
}
