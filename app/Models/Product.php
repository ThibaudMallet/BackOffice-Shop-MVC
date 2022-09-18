<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel
{

    /* PROPERTIES */     
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;


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
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }



    /* METHODS */
    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public static function find($productId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $productId;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
        $result = $pdoStatement->fetchObject('App\Models\Product');

        return $result;
    }

        /**
     * Gestion des tags d'un produit
     *
     * Permet, à partir de l'instance, de récupérer la liste des tags
     * @return void
     */
    public function getTags() 
    {
        // Centralisation des requêtes sur les tags dans la class Model Tag
        return Tag::findByProduct($this->id);
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $results;
    }

    /**
     * Récupérer les 5 category mises en avant sur la home
     *
     * @return Product[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM product
            ORDER BY id DESC
            LIMIT 3
        ';
        $pdoStatement = $pdo->query($sql);
        $products = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $products;
    }

    /**
     * Insert a new product
     *
     * @return void
     */
    public function insert () {

        // Get pdo instance
        $pdo = Database::getPDO();

        // Write the sql request without data directly, use key to bind values after
        $sql = '
            INSERT INTO `product` (name, description, picture, price, rate, status, brand_id, category_id, type_id)
            VALUES (:name, :description, :picture, :price, :rate, :status, :brand_id, :category_id, :type_id)
            ';

        // Prepare the request with pdo instance
        $sth = $pdo->prepare($sql);

        // Bind values according to data type
        $sth->bindValue('name', $this->name, PDO::PARAM_STR);
        $sth->bindValue('description', $this->description, PDO::PARAM_STR);
        $sth->bindValue('picture', $this->picture, PDO::PARAM_STR);
        $sth->bindValue('price', $this->price, PDO::PARAM_INT);
        $sth->bindValue('rate', $this->rate, PDO::PARAM_INT);
        $sth->bindValue('status', $this->status, PDO::PARAM_INT);
        $sth->bindValue('brand_id', $this->brand_id, PDO::PARAM_INT);
        $sth->bindValue('category_id', $this->category_id, PDO::PARAM_INT);
        $sth->bindValue('type_id', $this->type_id, PDO::PARAM_INT);

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
            UPDATE product
            SET 
                name = :name,
                description = :description,
                picture = :picture,
                price = :price,
                rate = :rate,
                status = :status,
                brand_id = :brand_id,
                category_id = :category_id,
                type_id = :type_id

            WHERE id = :id
        ";

        // Pass the request to pdo
        $sth = $pdo->prepare($sql);

        $sth->bindValue("name", $this->name, PDO::PARAM_STR);
        $sth->bindValue("description", $this->description, PDO::PARAM_STR);
        $sth->bindValue('picture', $this->picture, PDO::PARAM_STR);
        $sth->bindValue('price', $this->price, PDO::PARAM_INT);
        $sth->bindValue('rate', $this->rate, PDO::PARAM_INT);
        $sth->bindValue('status', $this->status, PDO::PARAM_INT);
        $sth->bindValue('brand_id', $this->brand_id, PDO::PARAM_INT);
        $sth->bindValue('category_id', $this->category_id, PDO::PARAM_INT);
        $sth->bindValue('type_id', $this->type_id, PDO::PARAM_INT);
        $sth->bindValue('id', $this->id, PDO::PARAM_INT);

        // Execute the request
        $success = $sth->execute();
        if ( $success && $sth->rowCount() === 1 ) return true;
        else return false;
    }

    /**
     * Remove a category from db
     *
     * @return void
     */
    public function delete () {
        
    }
}
