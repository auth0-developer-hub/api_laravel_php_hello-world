<?php
namespace App\Services;

use App\Models\Message;

interface MessageServiceInterface
{
    public function getPublicMessage(): Message;

    public function getProtectedMessage(): Message;

    public function getAdminMessage(): Message;
}
