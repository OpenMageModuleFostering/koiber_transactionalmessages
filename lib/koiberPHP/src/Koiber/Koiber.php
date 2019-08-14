<?php

class Koiber {

    private $token;
    const API_URL   = "http://api.koiber.com/v1/";
    const GET       = "GET";
    const POST      = "POST";
    const PUT       = "PUT";
    const DELETE    = "DELETE";

    public function __construct($token) {
        $this->token = $token;
    }

    public function getToken() {
        return $this->token;
    }
    
    private function get($url, $method, $data = NULL) {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => self::API_URL . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . base64_encode($this->token . ":x"),
                "content-type: application/json"
            ),
        );
        if(!empty($data) || $data != NULL) {
            $options[CURLOPT_POSTFIELDS] = $data;
        }
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        return new Response($response, $status['http_code'], $err);
    }

    /* ------------------------- TALKS -------------------- */

    public function getTalks($page = 1, $perPage = 1) {
        return $this->get("talks?page=$page&per_page=$perPage", Koiber::GET);
    }

    public function getTalk($id) {
        return $this->get("talks/$id", Koiber::GET);
    }
	
	public function getMsg($id) {
        return $this->get("talks/messages/$id", Koiber::GET);
    }


    public function createTalk($dados) {
        return $this->get("talks", Koiber::POST, $dados);
    }
    
    public function addMsgTalk($talkID, $dados) {
        return $this->get("talks/$talkID/messages", Koiber::POST, $dados);
    }
    
    public function closeTalk($talkID) {
        return $this->get("talks/$talkID/close", Koiber::PUT);
    }
    
    public function isCloseTalk($talkID) {
        return $this->get("talks/$talkID/is_closed", Koiber::GET);
    }
    
    
    /* ------------------------- USERS -------------------- */
    
    public function getUsers($page = 1, $perPage = 1) {
        return $this->get("users?page=$page&per_page=$perPage", Koiber::GET);
    }
    
    public function getUser($id) {
        return $this->get("users/$id", Koiber::GET);
    }
    
    public function userIsAuthorized($dado, $getDados = false) {
        return $this->get("users/exists/$dado?data=$getDados", Koiber::GET);
    }
    
    
    /* ------------------------- DEPARTMENTS -------------------- */

    public function getDepartments() {
        return $this->get("departments", Koiber::GET);
    }
    
    public function getDepartment($id) {
        return $this->get("departments/$id", Koiber::GET);
    }
    
    public function createDepartment($name) {
        $dados = json_encode(array("name" => $name));
        return $this->get("departments", Koiber::POST, $dados);
    }
    
    public function updateDepartment($id, $name) {
        $dados = json_encode(array("name" => $name));
        return $this->get("departments/$id", Koiber::PUT, $dados);
    }
    
    public function deleteDepartment($id) {
        return $this->get("departments/$id", Koiber::DELETE);
    }
    
    /* ------------------------- CHANNELS -------------------- */
    
    public function getCannels() {
        return $this->get("channels", Koiber::GET);
    }
    
    public function getCannel($id) {
        return $this->get("channels/$id", Koiber::GET);
    }

    public function createCannel($dados) {
        return $this->get("channels", Koiber::POST, $dados);
    }
    
    public function updateCannel($id, $dados) {
        return $this->get("channels/$id", Koiber::PUT, $dados);
    }
    
    public function deleteCannel($id) {
        return $this->get("channels/$id", Koiber::DELETE);
    }
}
