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
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Paciente não encontrado.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'sometimes|required|string|max:255',
            'cep' => 'sometimes|required|string|size:8',
            'endereco' => 'sometimes|required|string|max:255',
            'bairro' => 'sometimes|required|string|max:255',
            'cidade' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|size:2',
            'phone' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $patient->user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro na validação dos dados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $patient->update($request->only([
            'full_name',
            'cep',
            'endereco',
            'bairro',
            'cidade',
            'estado',
            'phone'
        ]));

        if ($request->has('email') || $request->has('password')) {
            $user = $patient->user;
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        return response()->json([
            'message' => 'Paciente atualizado com sucesso',
            'patient' => $patient
        ]);
    }
}
