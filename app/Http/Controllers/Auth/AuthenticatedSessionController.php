<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // Redireciona com base na role do usuário
        if ($user->role === 'secretaria') {
            return redirect()->intended('/dashboard');
        } elseif ($user->role === 'patient') {
            // Busque o psicólogo associado ao usuário
            $patient = $user->patients;

            if ($patient) {
                return redirect()->route('patient.index2', ['patients_id' => $patient->id]);
            } else {
                // Caso o psicólogo não seja encontrado, redirecione para uma página padrão
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        } elseif ($user->role === 'psicologo') {
            // Busque o psicólogo associado ao usuário
            $psicologo = $user->psicologo;

            if ($psicologo) {
                return redirect()->route('psychologist.index2', ['psicologo_id' => $psicologo->id]);
            } else {
                // Caso o psicólogo não seja encontrado, redirecione para uma página padrão
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        // Redirecionamento padrão se a role não estiver definida
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(RouteServiceProvider::INICIO);
    }
}
