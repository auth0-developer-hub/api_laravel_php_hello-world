<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\JsonResponse;

class MessagesController extends Controller
{
    public function showPublicMessage(MessageService $messageService): JsonResponse
    {
        return response()->json($messageService->getPublicMessage()->toArray());
    }

    public function showAdminMessage(MessageService $messageService): JsonResponse
    {
        return response()->json($messageService->getAdminMessage()->toArray());
    }

    public function showProtectedMessage(MessageService $messageService): JsonResponse
    {
        return response()->json($messageService->getProtectedMessage()->toArray());
    }
}
