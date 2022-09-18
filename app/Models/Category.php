<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{
    /* PROPERTIES */ 
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;



    /* GETTER / SETTER */
    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }



    /* METHODS */
    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    
    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }


    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
            LIMIT 3
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }


    /**
     * Insert a new cagegory
     *
     * @return void
     */
    public function insert () {

        // Get pdo instance
        $pdo = Database::getPDO();

        // Write the sql request without data directly, use key to bind values after
        $sql = "
            INSERT INTO `category` (name, subtitle, picture, home_order)
            VALUES (:name, :subtitle, :picture, :home_order)
        ";

        // Prepare the request with pdo instance
        $sth = $pdo->prepare($sql);

        // Bind values according to data type
        $sth->bindValue('name', $this->name, PDO::PARAM_STR);
        $sth->bindValue('subtitle', $this->subtitle, PDO::PARAM_STR);
        $sth->bindValue('picture', $this->picture, PDO::PARAM_STR);
        $sth->bindValue('home_order', $this->home_order, PDO::PARAM_INT);

        // Execute the request and get sucess or fail
        $success = $sth->execute();

        // Check success and number of row modified
        if ( $success && $sth->rowCount() === 1 ) {

            // Get inserted id to fill id property in this object
            $this->id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }


    /**
     * Save updates into db
     *
     * @return void
     */
    public function update () {
        // Get pdo instance to talk with database
        $pdo = Database::getPDO();

        $sql = "
            UPDATE category
            SET 
                name = :name,
                subtitle = :subtitle,
                picture = :picture,
                home_order = :home_order
            WHERE id = :id
        ";

        // Pass the request to pdo
        $sth = $pdo->prepare($sql);

        // Replace data in request
        $sth->bindValue("name", $this->name, PDO::PARAM_STR);
        $sth->bindValue('subtitle', $this->subtitle, PDO::PARAM_STR);
        $sth->bindValue('picture', $this->picture, PDO::PARAM_STR);
        $sth->bindValue('home_order', $this->home_order, PDO::PARAM_INT);
        $sth->bindValue('id', $this->id);

        // Execute the request
        $success = $sth->execute();
        if ( $success && $sth->rowCount() === 1 ) return true;
        else return false;
    }

    public function resetHomeOrder () {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE category
            SET 
                home_order = 0
            WHERE home_order > 0
        ";
        return $pdo->exec($sql);
    }


    /**
     * Remove a category from db
     *
     * @return void
     */
    public function delete () {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM category WHERE id = :id";
        // Pass the request to pdo
        $sth = $pdo->prepare($sql);
        // Replace data in request
        $sth->bindValue('id', $this->id);

        // Execute the request
        $success = $sth->execute();
        if ( $success && $sth->rowCount() === 1 ) return true;
        else return false;
    }
}