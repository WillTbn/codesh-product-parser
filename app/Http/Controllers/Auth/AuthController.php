<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\Auth\SanctumAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Authetication Sanctum Api
     * @param AuthRequest
     * @return JsonResponse
     */
    public function auth(AuthRequest $request)
    {
        $sactumService = new SanctumAuthService(...$request->only([
            'email',
            'password'
        ]));
        $sactumService->execute();

        return new JsonResponse(['message' => 'Usuário logado com sucesso!', 'data' => $sactumService->getData()], 200);
    }
}
