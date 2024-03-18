<?php

class Article{
    // Variables
    private $_id;
    private $_titre;
    private $_desc;
    private $_contenu;
    private $_imgId;

    // Constructeurs
    public function __construct($id,$titre,$desc,$contenu,$imgId)
    {
        $this->_id = $id;
        $this->_titre = $titre;
        $this->_desc = $desc;
        $this->_contenu = $contenu;
        $this->_imgId = $imgId;
    }

    // Getters
    public function __get($propriete) {
        switch ($propriete) {
            case "id" : return $this->_id;
            case "titre" : return $this->_titre;
            case "desc" : return $this->_desc;
            case "contenu" : return $this->_contenu;
            case "imgId" : return $this->_imgId;
        }
    }

    // Setters
    public function __set($propriete, $value) {
        switch ($propriete) {
            case "id" : $this->_id = $value; break;
            case "titre" : $this->_titre = $value; break;
            case "desc" : $this->_desc = $value; break;
            case "contenu" : $this->_contenu = $value; break;
            case "imgId" : $this->_imgId = $value; break;
        }
    }

}