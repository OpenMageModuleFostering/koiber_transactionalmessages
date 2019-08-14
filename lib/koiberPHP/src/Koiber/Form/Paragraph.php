<?php

class Paragraph extends Element {
    
    /*
     * 
     */
    public function __construct($id, $content) {
        parent::__construct($id, $content, "p");
    }    
    
    public function getResponse() {
        
    }

}
