<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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

        // Case User is banned
        if($request->user()->status == 'inactive'){
            Auth::guard('web')->logout();
            $request->session()->regenerateToken();

			toastr()->error('User has been banned, please contact to support!','Account Banned!');
            return redirect('/');
        }


        if($request->user()->role==='admin' || $request->user()->role=='staff'){
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }
        if($request->user()->role==='vendor'){
            return redirect()->intended(RouteServiceProvider::VENDOR);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
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
