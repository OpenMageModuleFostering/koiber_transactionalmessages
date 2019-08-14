<?php

class Response {
    private $response;
    private $erroRequest;
    private $status_code;
    
    public function __construct($response, $status_code, $erro = null) {
        $this->response = $response;
        $this->status_code = $status_code;
        $this->erroRequest = $erro;
    }
    
    public function setResponse($response) {
        $this->response = $response;
    }
    
    public function isOk() {
        if($this->status_code < 300 && $this->status_code >= 200) {
            return true;
        }
        return false;
    }
    
    public function getResponseCode() {
        return $this->status_code;
    }
    
    public function getError() {
        return $this->erroRequest;
    }
    
    /**
     * returns the request content
     */
    public function getBody($json = FALSE) {
        if($json === FALSE) {
            return $this->response;
        }
        return json_decode($this->response, true);
    }
    
    public function getTalk() {
        $d = json_decode($this->response, true);
        $talk = new Talk();
        $talk->fromArray($d);
        return $talk;
    }
}
