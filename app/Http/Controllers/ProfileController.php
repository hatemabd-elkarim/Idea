<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailChanged;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }


    public function update(Request $request)
    {

        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['string', 'required', 'max:255'],
            'email' => ['string', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);

        $originalEmail = $user->email;

        Auth::user()->update($validated);

        if ($originalEmail !== $request->email) {
            Notification::route('mail', $originalEmail)
                ->notify(new EmailChanged($user, $originalEmail));
        }
        return redirect()->route('profile.edit')->with('success', 'profile updated successfully');
    }
}
