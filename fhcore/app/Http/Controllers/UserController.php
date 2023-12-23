<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends AppBaseController
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Gera uma string randomica
            $token = openssl_random_pseudo_bytes(16);

            // Converte o dado para sua repreentação hexadecimal
            $token = bin2hex($token);

            $user = User::where('email', $request->email)
                        ->first();

            return $this->sendResponse([
                'email' => $user->email,
                'token' => $token,
                'api_token' => $user->createToken('api_token_' . str_replace($user->name, " ", "_"))->plainTextToken,
                'name' => $user->name,
                'user_id' => $user->id,
            ], 'autenticado com sucesso');
        }

        return $this->sendError('Falha na autenticação, verique as credênciais', 400);
    }

    public function register(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->sendSuccess('Usuário cadastrado com sucesso!');

    }

    public function logoutWeb(Request $request) {
        Auth::guard('web')->logout();
    }

    public function index(Request $request){

        $users = User::all();

        return $this->sendResponse($users->toArray(), 'Usuários localizados com sucesso');
    }

    public function show($id){

        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('Usuário não encontrado');
        }

        return $this->sendResponse($user->toArray(), 'Usuário localizado com sucesso');
    }

    public function update($id, Request $request){

        $input = $request->all();

        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('Usuário não encontrado');
        }

        $user->fill($input);
        $user->save();

        return $this->sendResponse($user->toArray(), 'Usuário atualizado com sucesso');
    }

    public function destroy($id){

        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('Usuário não encontrado');
        }

        // $user->delete();
        $user->ativo = 0; // Soft Delete
        $user->save();

        return $this->sendSuccess('Usuário excluído com sucesso');
    }

}
