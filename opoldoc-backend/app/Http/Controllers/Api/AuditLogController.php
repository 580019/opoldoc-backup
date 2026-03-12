<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        return response()->json(
            AuditLog::with('user')
                ->orderByDesc('log_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,user_id'],
            'action_type' => ['required', 'string', 'max:50'],
            'table_name' => ['nullable', 'string', 'max:50'],
            'record_id' => ['nullable', 'integer'],
            'action_details' => ['nullable', 'string'],
            'action_date' => ['nullable', 'date'],
        ]);

        $log = AuditLog::create($validated);

        return response()->json($log->load('user'), 201);
    }

    public function show(AuditLog $log)
    {
        return response()->json($log->load('user'));
    }

    public function update(Request $request, AuditLog $log)
    {
        $validated = $request->validate([
            'action_type' => ['sometimes', 'string', 'max:50'],
            'table_name' => ['sometimes', 'nullable', 'string', 'max:50'],
            'record_id' => ['sometimes', 'nullable', 'integer'],
            'action_details' => ['sometimes', 'nullable', 'string'],
            'action_date' => ['sometimes', 'nullable', 'date'],
        ]);

        $log->update($validated);

        return response()->json($log->load('user'));
    }

    public function destroy(AuditLog $log)
    {
        $log->delete();

        return response()->json(['deleted' => true]);
    }
}
