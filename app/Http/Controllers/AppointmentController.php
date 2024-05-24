<?php

// AppointmentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        // Carregar todos os pacientes e psicólogos disponíveis
        $patients = \App\Models\Patient::all();
        $psicologo = \App\Models\Psicologo::all();
    
        // Passar os dados para a view de criação de consulta
        return view('appointments.create', compact('patients', 'psicologo'));
    }
    
    public function store(Request $request)
{
    // Valide os dados recebidos do formulário
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'psicologo_id' => 'required|exists:psicologo,id',
        'date' => 'required|date',
        'time' => 'required|date_format:H:i',
    ]);

    try {
        // Crie uma nova consulta com os dados validados
        $appointment = Appointment::create([
            'patient_id' => $validatedData['patient_id'],
            'psicologo_id' => $validatedData['psicologo_id'],
            'date_time' => $validatedData['date'] . ' ' . $validatedData['time'],
        ]);

        // Retorna uma resposta JSON indicando o sucesso e o ID do paciente
        return response()->json([
            'success' => true,
            'patient_id' => $validatedData['patient_id']
        ]);
    } catch (\Exception $e) {
        // Retorna uma resposta JSON indicando o erro
        return response()->json([
            'success' => false,
            'message' => 'Erro ao agendar a consulta: ' . $e->getMessage()
        ], 500);
    }
}

    // Métodos edit, update, destroy permanecem os mesmos...
}
