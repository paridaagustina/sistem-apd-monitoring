<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::with('user')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.workers.index', compact('workers'));
    }

    public function create()
    {
        $users = User::where('role', 'pekerja_lapangan')
            ->whereDoesntHave('worker')
            ->orderBy('name')
            ->get();

        return view('admin.workers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'pekerja_lapangan'),
                'unique:workers,user_id',
            ],
            'worker_code' => [
                'required',
                'string',
                'max:30',
                'alpha_dash',
                'unique:workers,worker_code',
            ],
            'name' => ['required', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ], [
            'user_id.required' => 'Pilih akun pekerja.',
            'user_id.unique' => 'Akun tersebut sudah terhubung dengan pekerja lain.',
            'worker_code.required' => 'Nomor identitas pekerja wajib diisi.',
            'worker_code.unique' => 'Nomor identitas pekerja sudah digunakan.',
            'name.required' => 'Nama pekerja wajib diisi.',
        ]);

        $validated['is_active'] = true;

        Worker::create($validated);

        return redirect()
            ->route('admin.workers.index')
            ->with('success', 'Data pekerja berhasil ditambahkan.');
    }

    public function edit(Worker $worker)
    {
        $users = User::where('role', 'pekerja_lapangan')
            ->where(function ($query) use ($worker) {
                $query->whereDoesntHave('worker')
                    ->orWhere('id', $worker->user_id);
            })
            ->orderBy('name')
            ->get();

        return view(
            'admin.workers.edit',
            compact('worker', 'users')
        );
    }

    public function update(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'pekerja_lapangan'),
                Rule::unique('workers', 'user_id')
                    ->ignore($worker->id),
            ],
            'worker_code' => [
                'required',
                'string',
                'max:30',
                'alpha_dash',
                Rule::unique('workers', 'worker_code')
                    ->ignore($worker->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $worker->update($validated);

        return redirect()
            ->route('admin.workers.index')
            ->with('success', 'Data pekerja berhasil diperbarui.');
    }

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
}
