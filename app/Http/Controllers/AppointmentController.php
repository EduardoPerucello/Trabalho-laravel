<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Método para exibir os agendamentos do usuário logado
    public function index()
    {
        $user = auth()->user(); // Obtém o usuário autenticado
        $appointments = $user->appointments()->orderBy('date', 'asc')->get(); // Obtém os agendamentos do usuário e os ordena por data
        return response()->json(['appointments' => $appointments]); // Retorna os agendamentos como uma resposta JSON
    }

    // Método para exibir o formulário de criação de agendamento
    public function create()
    {
        return view('appointments.create'); // Retorna a view 'appointments.create' para criar um novo agendamento
    }

    // Método para armazenar um novo agendamento
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            // outras validações, se necessário
        ]); // Valida os dados recebidos do formulário

        $user = auth()->user(); // Obtém o usuário autenticado
        $user->appointments()->create($validatedData); // Cria um novo agendamento associado ao usuário autenticado

        return redirect()->route('appointments.index')->with('success', 'Consulta agendada com sucesso!'); // Redireciona para a página de agendamentos e exibe uma mensagem de sucesso
    }
}
