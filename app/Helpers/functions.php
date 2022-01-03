<?php

if ( ! function_exists('apiSuccess')) {
    function apiSuccess($data, $message = '', $code = 200) {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

if ( ! function_exists('apiError')) {
    function apiError($errorCode, $errorMessage = '') {
        return response()->json([
            'status' => $errorCode,
            'message' => $errorMessage,
        ], $errorCode);
    }
}
