<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

use Illuminate\Support\Facades\Auth;


class SessionController extends Controller
{
    //
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);

        if (!Auth::attempt($validated)) {
            return back()
                ->withErrors([
                    'password' => 'The provided email and password do not match any'
                ])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'logged in successfully');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
