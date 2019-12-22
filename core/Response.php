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
            case 'json':                
                $this->sendJson($data);
                break;
            case 'xml':                
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
    private function sendXml($data)
    {
        //echo xmlrpc_encode($data);//There is an excetenstion, installing required: sudo apt-get install php7.2-xmlrpc
        $this->xml_encode($data);
    }
    
    //From stack over flow
    public function xml_encode($mixed, $domElement=null, $DOMDocument=null)
    {
        if (is_null($DOMDocument)) {
            $DOMDocument =new \DOMDocument;
            $DOMDocument->formatOutput = true;
            xml_encode($mixed, $DOMDocument, $DOMDocument);
            echo $DOMDocument->saveXML();
        }
        else {
            // To cope with embedded objects 
            if (is_object($mixed)) {
              $mixed = get_object_vars($mixed);
            }
            if (is_array($mixed)) {
                foreach ($mixed as $index => $mixedElement) {
                    if (is_int($index)) {
                        if ($index === 0) {
                            $node = $domElement;
                        }
                        else {
                            $node = $DOMDocument->createElement($domElement->tagName);
                            $domElement->parentNode->appendChild($node);
                        }
                    }
                    else {
                        $plural = $DOMDocument->createElement($index);
                        $domElement->appendChild($plural);
                        $node = $plural;
                        if (!(rtrim($index, 's') === $index)) {
                            $singular = $DOMDocument->createElement(rtrim($index, 's'));
                            $plural->appendChild($singular);
                            $node = $singular;
                        }
                    }

                    xml_encode($mixedElement, $node, $DOMDocument);
                }
            }
            else {
                $mixed = is_bool($mixed) ? ($mixed ? 'true' : 'false') : $mixed;
                $domElement->appendChild($DOMDocument->createTextNode($mixed));
            }
        }
    }
}
