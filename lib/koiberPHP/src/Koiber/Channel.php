<?php

class Channel {
    private $id;
    private $name;
    private $info;
    private $conf;
    
    /**
     *
     * @var Form
     */
    private $form;
    
    /**
     *
     * @var Branch
     */
    private $branch;
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getConf() {
        return $this->conf;
    }

    public function getForm() {
        return $this->form;
    }

    public function getBranch() {
        return $this->branch;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setInfo($info) {
        $this->info = $info;
        return $this;
    }

    public function setConf($conf) {
        $this->conf = $conf;
        return $this;
    }

    public function setForm(Form $form) {
        $this->form = $form;
        return $this;
    }

    public function setBranch(Branch $branch) {
        $this->branch = $branch;
        return $this;
    }
    
}
