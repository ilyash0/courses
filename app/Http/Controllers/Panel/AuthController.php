<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(AuthRequest $request): RedirectResponse
    {
        if (auth()->attempt($request->validated() + ['is_admin' => true])) {
            return redirect()->intended(route('courses.index'));
        }

        return back()->withErrors([
            'status' => 'Неверные учетные данные.',
        ])->withInput($request->validated());
    }

    /**
     * Log the user out of the application.
     */
    public function logout(): RedirectResponse
    {
        auth()->logout();
        return redirect(route('login'));
    }
}
