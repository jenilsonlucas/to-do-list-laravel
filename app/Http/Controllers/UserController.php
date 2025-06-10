<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                'nullable',
                FILE::image()
                    ->dimensions(
                        Rule::dimensions()
                            ->maxWidth(2120)
                            ->maxHeight(2512)
                    )
            ]
        ]);

        $validator->sometimes('email', ['require', 'string', 'email', 'max:255', 'unique:users'], function (Fluent $input) {
            return $input->email != Auth::user()->email;
        });

        $validateData = $validator->validate();

        if ($request->has("photo")) {
            $name = str_replace("storage/", "", $user->image);
            Storage::disk('public')->delete($name);
            $file = $request->file("photo");
            $extension = $file->getClientOriginalExtension();
            $name = $user->name.time().".".$extension;
            $file->storeAs('images/', $name, 'public');
            $user->image =  "storage/images/".$name;
        }
        
        $user->update($validateData);
        return redirect()->route('user.edit')->with('message_flash', 'Usuario actualizado com sucesso');
    }
}
