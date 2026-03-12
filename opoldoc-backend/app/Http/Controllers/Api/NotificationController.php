<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(
            AppNotification::with('user')
                ->orderByDesc('notification_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,user_id'],
            'type' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string'],
            'status' => ['nullable', 'string', 'max:20'],
        ]);

        $notification = AppNotification::create([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'message' => $validated['message'],
            'status' => $validated['status'] ?? 'Unread',
        ]);

        return response()->json($notification->load('user'), 201);
    }

    public function show(AppNotification $notification)
    {
        return response()->json($notification->load('user'));
    }

    public function update(Request $request, AppNotification $notification)
    {
        $validated = $request->validate([
            'type' => ['sometimes', 'string', 'max:50'],
            'message' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string', 'max:20'],
            'read_at' => ['sometimes', 'nullable', 'date'],
        ]);

        $notification->update($validated);

        return response()->json($notification->load('user'));
    }

    public function destroy(AppNotification $notification)
    {
        $notification->delete();

        return response()->json(['deleted' => true]);
    }

    public function markRead(AppNotification $notification)
    {
        $notification->status = 'Read';
        $notification->read_at = now();
        $notification->save();

        return response()->json($notification->load('user'));
    }
}
