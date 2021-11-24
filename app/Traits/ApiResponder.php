<?php

namespace App\Traits;

trait ApiResponder {

    protected function apiSuccess($message, $code = 200) {
        return $this->response($message, $code);
    }

    protected function apiError($message, $code) {
        return $this->response($message, $code);
    }

    private function response($message, $code) {
        return response()->json(['message' => $message], $code);
    }

}
