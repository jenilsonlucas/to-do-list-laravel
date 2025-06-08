<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\File;

class UserController extends Controller
{


    public function edit()
    {
        $user = Auth::user();
        $categories = $user->categories;
        return view("settings.profile", compact('user', 'categories'));
    }


    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
            'photo' => [
                FILE::image()
                    ->dimensions(
                        Rule::dimensions()
                            ->maxWidth(512)
                            ->maxHeight(512)
                    )
            ]
        ]);

        $validator->sometimes('email', ['require','string', 'email', 'max:255', 'unique:users'], function(Fluent $input){
            return $input->email != Auth::user()->email;
        });

        $validateData = $validator->validate();

        $user->update($validateData);

        return redirect()->route('user.edit')->with('message_flash', 'Usuario actualizado com sucesso');
    }
}
