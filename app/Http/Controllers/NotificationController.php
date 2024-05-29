<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psicologo;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function notifyPsicologo(Request $request)
    {
        // Criar uma nova notificação para o psicólogo
        $notification = Notification::create([
            'psicologo_id' => $request->psicologo_id,
            'message' => 'Seu paciente chegou',
        ]);

        return response()->json(['message' => 'Notificação enviada com sucesso.']);
    }

    public function getNotifications($psicologo_id)
    {        
        // Buscar as notificações não lidas para o psicólogo
        $notifications = Notification::where('psicologo_id', $psicologo_id)
                                    ->where('read', false)
                                    ->get();

        return response()->json($notifications);
    }

    public function markAsRead($notification_id)
    {
        // Marcar a notificação como lida
        $notification = Notification::find($notification_id);
        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notificação marcada como lida.']);
    }
}
