<?php

abstract class Element {
    private $id;
    private $label;
    private $element;
    private $required = false;
    
    private $elements = array('p', 'input', 'textarea');
    
    public function __construct($id, $label, $element) {
        $this->id = $id;
        $this->label = $label;
        
        if(in_array($element, $this->elements)) {
            $this->element = $element;
        }else {
            throw new Exception('O elemento não é válido');
        }
    }

    
    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getElement() {
        return $this->element;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function setElement($element) {
        $this->element = $element;
        return $this;
    }
    
    public function setRequired(Boolean $required) {
        if(!is_bool($required))
            throw new Exception('boolean is expected');
        $this->required = $required;
        return $this;
    }
    
    abstract function getResponse();
}
