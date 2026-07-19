<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    //
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['string', 'required', 'max:255'],
            'email' => ['string', 'required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);

        $user = User::create($validated);

        Auth::login($user);

        return redirect('/')->with('success', 'registred successfully');
    }
}
