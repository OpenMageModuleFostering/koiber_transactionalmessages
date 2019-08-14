<?php

class Form {
    private $elements = array();
    private $title;

    public function addElement(Element $element) {
        array_push($this->elements, $element);
        return $this;
    }
    
    public function getElements() {
        return $this->elements;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

}
