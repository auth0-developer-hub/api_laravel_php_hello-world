<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getPublicMessage()
    {
        return response()->json(["message" => "The API doesn't require an access token to share this message."], 200);
    }

    public function getProtectedMessage()
    {
        return response()->json(["message" => "The API successfully validated your access token."], 200);
    }

    public function getAdminMessage()
    {
        return response()->json(["message" => "The API successfully recognized you as an admin."], 200);
    }
}
