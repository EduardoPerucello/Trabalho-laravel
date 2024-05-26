<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Psicologo;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        // Obtém o paciente autenticado
        $patient = auth()->user()->patient;
    
        // Obtém todas as consultas associadas ao paciente
        $consultations = Appointment::where('patients_id', $patient->id)->get();
    
        // Itera sobre cada consulta e adiciona o nome do psicólogo associado
        $consultations->transform(function ($consultation) {
            $psicologo = Psicologo::find($consultation->psicologo_id);
            if ($psicologo) {
                $consultation->psicologo_name = $psicologo->full_name;
            } else {
                // Log para verificar se o psicólogo não foi encontrado
                \Log::info("Psicólogo não encontrado para a consulta ID: $consultation->id");
                $consultation->psicologo_name = 'Psicólogo não encontrado';
            }
            return $consultation;
        });
    
        return response()->json($consultations);
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patients_id' => 'required|exists:users,id',
            'psicologo_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na validação dos dados.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $appointment = Appointment::create([
                'patients_id' => $request->patients_id,
                'psicologo_id' => $request->psicologo_id,
                'date' => $request->date,
                'time' => $request->time,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Consulta agendada com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao agendar a consulta: ' . $e->getMessage()
            ], 500);
        }
    }

    // Métodos index, create, edit, update, destroy permanecem os mesmos...
}
