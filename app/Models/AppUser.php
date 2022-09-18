<?php
namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel {
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;



    /* METHODS */
    /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
     *
     * @param int $id ID de l'utilisateur
     * @return AppUser
     */
    public static function find($id)
    {
    }

    
    /**
     * Méthode permettant de récupérer tous les enregistrements de la table app_user
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $results;
    }


    public function insert () {

        // Get pdo instance
        $pdo = Database::getPDO();

        // Write the sql request without data directly, use key to bind values after
        $sql = "
            INSERT INTO `app_user` (email, password, firstname, lastname, role, status)
            VALUES (:email, :password, :firstname, :lastname, :role, :status)
        ";

        // Prepare the request with pdo instance
        $sth = $pdo->prepare($sql);

        // Bind values according to data type
        $sth->bindValue('email', $this->email, PDO::PARAM_STR);
        $sth->bindValue('password', $this->password, PDO::PARAM_STR);
        $sth->bindValue('firstname', $this->firstname, PDO::PARAM_STR);
        $sth->bindValue('lastname', $this->lastname, PDO::PARAM_STR);
        $sth->bindValue('role', $this->role, PDO::PARAM_STR);
        $sth->bindValue('status', $this->status, PDO::PARAM_INT);

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
     * Save user into db
     *
     * @return void
     */
    public function update () {
    }


    /**
     * Remove a user from db
     *
     * @return void
     */
    public function delete () {
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword ($pwd) { $this->password = password_hash($pwd, PASSWORD_DEFAULT); }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     *
     * @return  self
     */ 
    public function setRole(string $role)
    {
        $this->role = $role;

        return $this;
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
     *
     * @return  self
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * FROM `app_user` WHERE `email` = :email";

        $sth = $pdo->prepare($sql);
        $sth->bindValue('email', $email, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchObject('App\Models\AppUser');
    }
}

?>