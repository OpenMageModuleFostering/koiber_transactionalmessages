<?php

interface IElement {
    public function setRequired($required);
    public function isRequired();
    public function getResponse();
}