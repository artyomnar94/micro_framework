<?php

namespace core;

/**
 * Description of Response
 *
 * @author artyomnar
 */
class Response {
    public $code;

    /**
     * Renders error view
     * @param int $code
     */
    public static function getErrorCode(int $code, string $message = '')
    {
        http_response_code($code);
        require 'views/http_error.php';
        exit;
    }
    
}
