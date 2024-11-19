<?php

namespace App\Http\Controllers\Master\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MasterLoginRequest;
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
        return view('master.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(MasterLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('master.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('master')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('master.login');
    }
}
