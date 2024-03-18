<?php

class Serie{
    // Variables
    private $_id;
    private $_lib;
    private $_version;
    private $_dateSortie;
    private $_nbCartes;
    private $_nbSecretes;
    private $_loca;

    // Constructeurs
    public function __construct($id,$lib,Version $version,$dateSortie,$nbCartes,$nbSecretes,$loca)
    {
        $this->_id = $id;
        $this->_lib = $lib;
        $this->_version = $version;
        $this->_dateSortie = $dateSortie;
        $this->_nbCartes = $nbCartes;
        $this->_nbSecretes = $nbSecretes;
        $this->_loca = $loca;
    }

    // Getters
    public function __get($propriete) {
        switch ($propriete) {
            case "id" : return $this->_id;
            case "lib" : return $this->_lib;
            case "version" : return $this->_version;
            case "dateSortie" : return $this->_dateSortie;
            case "nbCartes" : return $this->_nbCartes;
            case "nbSecretes" : return $this->_nbSecretes;
            case "loca" : return $this->_loca;
        }
    }

    // Setters
    public function __set($propriete, $value) {
        switch ($propriete) {
            case "id" : $this->_id = $value; break;
            case "lib" : $this->_lib = $value; break;
            case "version" : $this->_version = $value; break;
            case "dateSortie" : $this->_dateSortie = $value; break;
            case "nbCartes" : $this->_nbCartes = $value; break;
            case "nbSecretes" : $this->_nbSecretes = $value; break;
            case "loca" : $this->_loca = $value; break;
        }
    }

}