<?php

namespace App\Http\Controllers;

use App\Helpers\Responses;
use App\Http\Requests\Authentication\LoginUserRequest;
use App\Http\Requests\Authentication\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        try {
            $registerUser = User::create($validated);

            return Responses::SUCCESS('Usuário cadastrado com sucesso!', null, 201);
        }
        catch (\Exception $e) {
            Log::error('Ocorreu um erro ao cadastrar um usuário na base de dados: ' . $e->getMessage());

            return Responses::ERROR('Não foi possível cadastrar o usuário!', null, -1100, 400);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $getUser = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $getUser->password)) {
            return Responses::ERROR('E-mail ou senha incorretos!', null, -1100, 400);
        }

        $createToken = $getUser->createToken('auth_token')->plainTextToken;

        return Responses::SUCCESS('Usuário autenticado com sucesso!', $createToken, 200);
    }
}
