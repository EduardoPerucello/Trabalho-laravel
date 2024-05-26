<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Psicologo;

class NotificationController extends Controller
{
    public function notifyPsicologo(Request $request)
    {
        $notification = Notification::create([
            'psicologo_id' => $request->psicologo_id,
            'message' => 'Seu paciente chegou',
        ]);

        return response()->json(['message' => 'Notificação enviada com sucesso.']);
    }

    public function getNotifications($psicologo_id)
    {
        $notifications = Notification::where('psicologo_id', $psicologo_id)
                                    ->where('read', false)
                                    ->get();

        return response()->json($notifications);
    }

    public function markAsRead($notification_id)
    {
        $notification = Notification::find($notification_id);
        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notificação marcada como lida.']);
    }
}

