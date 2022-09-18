<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Tag extends CoreModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table tag en fonction d'un id donné
     *
     * @param int $tagId ID du tag
     * @return Tag
     */
    public static function find($tagId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `tag` WHERE `id` =' . $tagId;
        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $tag = $pdoStatement->fetchObject(self::class);
        // retourner le résultat
        return $tag;
    }
    
    /**
     * Recherche des tags en fonction d'un produit
     *
     * @param int $product_id
     * @return void
     */
    public static function findByProduct($product_id)
    {
        $pdo = Database::getPDO();

        $sql = "
            SELECT tag.*
            FROM tag
            JOIN product_has_tag AS pivot ON pivot.tag_id = tag.id AND pivot.product_id = $product_id
            ";

        $pdoStatement = $pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag
     *
     * @return Tag[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `tag`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $results;
    }

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

    public function insert()
    {
        // TODO: coder cette méthode
    }
    public function update()
    {
        // TODO: coder cette méthode
    }
    public function delete()
    {
        // TODO: coder cette méthode
    }
}