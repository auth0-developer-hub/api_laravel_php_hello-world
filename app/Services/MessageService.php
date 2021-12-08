<?php
namespace App\Services;

use App\Models\Message;

class MessageService implements MessageServiceInterface
{
    public function getPublicMessage(): Message
    {
        return new Message("The API doesn't require an access token to share this message.");
    }

    public function getProtectedMessage(): Message
    {
        return new Message("The API successfully validated your access token.");
    }

    public function getAdminMessage(): Message
    {
        return new Message("The API successfully recognized you as an admin.");
    }
}
