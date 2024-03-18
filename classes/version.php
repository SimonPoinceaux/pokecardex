<?php

class Version{
    // Variables
    private $_id;
    private $_lib;

    // Constructeurs
    public function __construct($id,$lib)
    {
        $this->_id = $id;
        $this->_lib = $lib;
    }

    // Getters
    public function __get($propriete) {
        switch ($propriete) {
            case "id" : return $this->_id;
            case "lib" : return $this->_lib;
        }
    }

    // Setters
    public function __set($propriete, $value) {
        switch ($propriete) {
            case "id" : $this->_id = $value; break;
            case "lib" : $this->_lib = $value; break;
        }
    }

}