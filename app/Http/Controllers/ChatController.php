<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000'
            ]);

            $chatMessage = ChatMessage::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $validatedData['receiver_id'],
                'message' => $validatedData['message'],
                'is_read' => false
            ]);

            return response()->json([
                'message' => 'Message sent successfully',
                'chat_message' => $chatMessage
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send message: ' . $e->getMessage()], 422);
        }
    }

    public function getConversation($otherUserId)
    {
        try {
            $currentUserId = Auth::id();

            $messages = ChatMessage::where(function($query) use ($currentUserId, $otherUserId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $otherUserId);
            })->orWhere(function($query) use ($currentUserId, $otherUserId) {
                $query->where('sender_id', $otherUserId)
                      ->where('receiver_id', $currentUserId);
            })->orderBy('created_at', 'asc')
              ->get();

            return response()->json($messages);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve conversation: ' . $e->getMessage()], 422);
        }
    }

    public function markAsRead($otherUserId)
    {
        try {
            $currentUserId = Auth::id();

            ChatMessage::where('sender_id', $otherUserId)
                ->where('receiver_id', $currentUserId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json(['message' => 'Messages marked as read']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to mark messages as read: ' . $e->getMessage()], 422);
        }
    }
}
