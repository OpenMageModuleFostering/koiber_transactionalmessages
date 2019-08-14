<?php

class Message {
    private $id;
    /**
     *
     * @var DateTime
     */
    private $createdAt;
    private $author;
    
    private $type;
    private $content;
    private $parent;
    
    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getType() {
        return $this->type;
    }

    public function getContent() {
        return $this->content;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }
    
    public function fromArray(array &$data) {
        $this->id = $data['id'];
        $this->author = $data['author'];
        $this->setCreatedAt(new DateTime($data['created_at']));
        $this->setType($data['type']);
        
        if($this->type == Type::TEXT) {
            $this->setContent($data['content']);
        } else {
            $form = new Form();
            if(isset($data['content']['title'])) {
                $form->setTitle($data['content']['title']);
            }
            $fields = $data['content'];
            
            if($this->type == Type::FORM) {
                $fields = $data['content']['elements'];
            }
            
            if($fields) {
                foreach ($fields as $field) {
                    switch ($field['element']) {
                        case "p": 
                            $form->addElement(new Paragraph($field['id'], $field['content']));
                            break;
                        case "textarea" :
                            $ta = new Textarea($field['id'], $field['label']);
                            if($field['required']) $ta->setRequired (false);
                            $form->addElement($ta);
                            break;

                        case "input": 

                            break;
                    }
                }
            }
            
            $this->setContent($form);
        }
    }
}
