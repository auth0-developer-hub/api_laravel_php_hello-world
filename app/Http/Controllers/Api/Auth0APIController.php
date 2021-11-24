<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class Auth0APIController extends BaseAPIController
{
    public function getPublicMessage()
    {
        return $this->apiSuccess("The API doesn't require an access token to share this message.");
    }

    public function getProtectedMessage()
    {
        return $this->apiSuccess("The API successfully validated your access token.");
    }

    public function getAdminMessage()
    {
        return $this->apiSuccess("The API successfully recognized you as an admin.");
    }
}
