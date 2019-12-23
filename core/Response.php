<?php

namespace core;

/**
 * Description of Response
 *
 * @author artyomnar
 */
class Response
{
    public $code;
    public $format;

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

    /**
     * Send content type header
     * @param string $format
     */
    public function setHeaders(string $format)
    {
        header("Content-Type:$format");
    }

    /**
     * 
     * @param type $data
     * @param string $format
     */    
    public function send($data, string $format)
    {
        $this->format = $format;
        switch ($this->format) {
            case 'text/html':
                $this->sendTextHtml($data);
                break;
            case 'application/json':                
                $this->sendJson($data);
                break;
            case 'application/xml':                
                $this->sendXml($data);
                break;
            default :
                self::getErrorPage(422, 'Invalid response format provided in headers');
                break;
        }
    }
    
    /**
     * @param mixed $data
     */
    private function sendTextHtml($data)
    {
        echo $data;
    }
    
    /**
     * @param mixed $data
     */
    private function sendJson($data)
    {
        echo json_encode($data);
    }
    
    /**
     * @param mixed $data
     */
    private function sendXml($data): void
    {
        //echo xmlrpc_encode($data);//There is an excetenstion, installing required: sudo apt-get install php7.2-xmlrpc
        
        $head = "<?xml version='1.0' encoding='UTF-8'?>";
        $body = '';
        $this->getXmlBody($data, $body);
        echo $head . $body;
    }
    
    /**
     * Parses provided array data and writes xml body into provided string
     * 
     * @param array $data
     * @param string $body
     * @param string $innerKey
     * @return string
     */
    private function getXmlBody(array $data, string &$body, string $innerKey = ''): void
    {
        if ($innerKey) {
            $body .= "<$innerKey>";
        }
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $this->getXmlBody($val, $body, $key);
            } else {
                $body .= "<$key>$val</$key>";                
            }
        }
        if ($innerKey) {
            $body .= "</$innerKey>";
        }
    }           
}
