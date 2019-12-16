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
     * @param string $message
     * @param string $pathToView
     */
    public static function getErrorPage(int $code, string $message = '', string $pathToView = '')
    {
        http_response_code($code);
        $pathToViev = empty($pathToView)? 'views/http_error.php' : $pathToView;
        require $pathToViev;
        exit;
    }
    
}
