<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PsicologoController extends Controller
{
    public function index()
    {
        return Psicologo::all();
    }

    public function index2($psicologo_id)
    {
        // Busque os dados do psicólogo do banco de dados
        $psicologo = Psicologo::find($psicologo_id);

        // Verifique se o psicólogo foi encontrado
        if (!$psicologo) {
            abort(404, 'Psicólogo não encontrado');
        }

        // Renderize a vista Inertia e passe os dados do psicólogo para a mesma
        return Inertia::render('Psychologist', [
            'psicologo' => $psicologo
        ]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro na validação dos dados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'psicologo',
        ]);

        Psicologo::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Psicologo cadastrado com sucesso'
        ]);
    }
}
