<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        return Patient::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'cep' => 'required|string|size:8',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'phone' => 'required|string|max:15',
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
            'role' => 'patient',
        ]);

        Patient::create([
            'full_name' => $request->full_name,
            'cep' => $request->cep,
            'endereco' => $request->endereco,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'phone' => $request->phone,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Paciente cadastrado com sucesso'
        ]);
    }

    public function show($id)
    {
        return Patient::with('appointments')->findOrFail($id);
    }

    public function showPatient($id)
    {
        return Patient::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'cep' => 'required|string|size:8',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users', // Adicione a regra 'unique' com a exceção do ID atual
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro na validação dos dados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::findOrFail($id); // Encontre o usuário pelo ID
        $user->update([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        $patient = Patient::findOrFail($id); // Encontre o paciente pelo ID
        $patient->update([
            'full_name' => $request->full_name,
            'cep' => $request->cep,
            'endereco' => $request->endereco,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'phone' => $request->phone,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Paciente atualizado com sucesso',
            'patient' => $patient
        ]);
    }
}
