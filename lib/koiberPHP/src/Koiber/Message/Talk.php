<?php

class Talk {
    const AUTHOR_COMPANY = "company";
    const AUTHOR_USER = "user";
    
    private $id;
    /**
     *
     * @var DateTime
     */
    private $createdAt;
    /**
     *
     * @var User
     */
    private $user;
    /**
     *
     * @var Channel
     */
    private $channel;
    /**
     *
     * @var Branch
     */
    private $branch;
    private $author;
    private $title;
    private $closed = null;
    private $msgs = array();
    
    public function Talk() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUser() {
        return $this->user;
    }

    public function getChannel() {
        return $this->channel;
    }

    public function getBranch() {
        return $this->branch;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getClosed() {
        return $this->closed;
    }

    public function getMsgs() {
        return $this->msgs;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setChannel(Channel $channel) {
        $this->channel = $channel;
        return $this;
    }

    public function setBranch(Branch $branch) {
        $this->branch = $branch;
        return $this;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setClosed($closed) {
        $this->closed = $closed;
        return $this;
    }

    public function setMsgs(array $msg) {
        $this->msgs = $msg;
        return $this;
    }
    
    public function addMsg(Message $msg) {
        array_push($this->msgs, $msg);
        return $this;
    }
    
    public function fromArray(Array &$data) {
        $this->id = $data['id'];
        $this->setCreatedAt(new DateTime($data['created_at']));
        $this->author = $data['author'];
        if(isset($data['title'] )) {
            $this->title = $data['title'];
        }
        
        $this->setUser(new User($data['user']));
        $this->setChannel(new Channel($data['channel']));
        
        if($data['msg']) {
            foreach ($data['msg'] as $msg) {
                $m = new Message();
                $m->fromArray($msg);
                $this->addMsg($m);
            }
        }
    }
    
}