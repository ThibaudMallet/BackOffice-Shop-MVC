<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models

// Classe abstraite, on ne peut plus l'instancier
abstract class CoreModel
{

    /* PROPERTIES */ 
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;



    /* ABSTRACT METHOD */
    /*
        Define abstract methods in order to implements into child class
    */
    abstract static public function findAll();
    abstract public static function find($id);
    abstract public function update();
    abstract public function insert();
    abstract public function delete();

    

    /* GETTER / SETTER */
    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }



    /* METHODS */
    /**
     * Return true if data is saved in database
     *
     * @return boolean
     */
    public function isPersited () {
        return $this->id > 0;
    }

    /**
     * Auto choose if insert or update according to contexte
     *
     * @return void
     */
    public function save () {
        if ( $this->isPersited() ) return $this->update();
        else return $this->insert();
    }
}
