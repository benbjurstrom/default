<?php

namespace App\Http\Controllers\Api\V1\Auth\Password;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Validation\ValidationException;

class ChangeController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'password_old'      => 'required|string|min:3',
            'password_new'      => 'required|string|min:3|confirmed',
        ]);

        $user = auth()->user();
        throw_unless(Hash::check($data['password_old'], $user->password), ValidationException::withMessages([
            'password'    => ['The given credentials are incorrect']
        ]));

        $user->password = bcrypt($data['password_new']);
        $user->save();

        return response()
            ->json(null, 200);
    }
}
