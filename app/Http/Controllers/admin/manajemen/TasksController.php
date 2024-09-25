<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function index()
    {
        $tasks = Task::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        // Validasi dan simpan tugas
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_reminder' => 'nullable|date',
            'deadline' => 'nullable|date',
        ]);

        $task = Task::create($request->all());

        // Kirim notifikasi WhatsApp jika time_reminder diatur
        if ($task->time_reminder) {
            // Mengirim pesan notifikasi
            $this->whatsAppService->sendMessage(
                '+6285156030568', // Nomor tujuan
                "Pengingat: Tugas \"{$task->title}\" akan jatuh tempo pada {$task->deadline}. Harap segera dikerjakan!"
            );
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_reminder' => 'nullable|date',
            'deadline' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
