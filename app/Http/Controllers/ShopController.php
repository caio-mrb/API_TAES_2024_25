<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopNotificationResource;
use Illuminate\Http\Request;
use App\Models\ShopNotification;

class ShopController extends Controller
{
    public function addNotification(Request $request)
    {
        // Valida os dados recebidos
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'braincoins' => 'required|integer|min:0',
        ]);

        // Cria uma nova notificação/descrição
        ShopNotification::create([
            'username' => $validated['username'],
            'braincoins' => $validated['braincoins'],
        ]);

        return response()->json(['message' => 'BrainCoins added successfully'], 201);
    }

    public function getNotifications($username)
    {
        $notifications = ShopNotification::where('username', $username)
            ->where('is_picked', false)
            ->get();

        ShopNotification::where('username', $username)
            ->where('is_picked', false)
            ->update(['is_picked' => true]);

        return ShopNotificationResource::collection($notifications);
    }
}
