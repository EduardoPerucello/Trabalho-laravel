<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentHistoricoController extends Controller
{
    public function historico()
    {
        // Obtém o paciente autenticado
        $patient = Auth::user()->patient;

        // Obtém todas as consultas passadas associadas ao paciente
        $historico = Appointment::where('patients_id', $patient->id)
            ->where('date', '<=', Carbon::now()->toDateString())
            ->where('time', '<', Carbon::now()->subMinutes(10)->toTimeString())
            ->with('psicologo') // Carrega o relacionamento com psicologo
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Retorna as consultas como uma resposta JSON
        return response()->json($historico);
    }
}
