<?php
namespace App\Services;

use Laravel\Lumen\Http\Request;

interface JWTServiceInterface
{
    public function extractBearerTokenFromRequest(Request $request): string;
    public function decodeBearerToken(string $token): array;
}
