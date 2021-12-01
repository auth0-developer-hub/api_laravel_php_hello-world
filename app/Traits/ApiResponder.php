<?php

namespace App\Traits;

trait ApiResponder {

    protected function apiSuccess($message, $code = 200) {
        return response()->json(['text' => $message], $code);
    }

    protected function apiError($message, $code) {
        return response()->json(['message' => $message], $code);
    }

}
