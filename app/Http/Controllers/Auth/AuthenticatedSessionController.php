<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Redirigir según el rol del usuario autenticado
        $user = Auth::user();
        switch ($user->tipo) {
            case 'admin':
                return redirect(route('admin.dashboard'));
            case 'nutricionista':
                return redirect(route('nutricionista.dashboard'));
            case 'entrenador':
                return redirect(route('entrenador.dashboard'));
            case 'recepcionista':
                return redirect(route('recepcionista.dashboard'));
            default:
                return redirect(route('dashboard'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
