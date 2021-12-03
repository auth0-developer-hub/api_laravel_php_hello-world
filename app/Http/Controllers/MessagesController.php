<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;

class MessagesController extends Controller
{
    public function showPublicMessage(MessageService $messageService)
    {
        return $messageService->getPublicMessage()->toArray();
    }

    public function showAdminMessage(MessageService $messageService)
    {
        return $messageService->getAdminMessage()->toArray();
    }

    public function showProtectedMessage(MessageService $messageService)
    {
        return $messageService->getProtectedMessage()->toArray();
    }
}
