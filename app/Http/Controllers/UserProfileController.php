<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'identity_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'identity_number')->ignore($user->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:25',
            ],
            'gender' => [
                'required',
                Rule::in(['L', 'P']),
            ],
            'address' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $user->update($data);

        return redirect()
            ->route('user.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}