<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserAppController extends CoreController
{
    public function login()
    {
        $this->show('main/login');
    }

    public function connecting()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $errors = [];

        if ($email === false || empty($email)) {
            $errors[] = "Email invalide";
        }
        if (empty($password)) {
            $errors[] = "Mot de passe invalide";
        }

        if (count($errors) === 0) {
            $user = AppUser::findByEmail($email);
    
            if ($user === false) {
                $errors[] = "Utilisateur inconnu";
            }
            else if (!($user->getPassword())) {
                $errors[] = "Mot de passe incorrect";
            }
            else {
                $_SESSION['userId'] = $user->getId();
                $_SESSION['userObject'] = $user;

                header('Location: /');
            }
        }
        $this->show('main/login', [
            'errors' => $errors
        ]);
    }
    public function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);
        $this->show('main/login', [
            'errors' => [
                'A bientot'
            ]
        ]);
    }
    public function list()
    {
        $this->checkAuthorization(['admin']);

        $usersList = AppUser::findAll();

                $viewData = [
                    'users' => $usersList
                ];
        
                // Call the list view for category
                $this->show('main/user-list', $viewData);

    }
        /**
     * Method to load the category form in order to insert category
     *
     * @return void
     */
    public function add () {
        $this->checkAuthorization(['admin']);

        $this->show('main/user-add', [
            'user' => new AppUser(),
        ]);
    }

    public function insert()
    {
        $this->checkAuthorization(['admin']);

                // Extract name with filter input
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
                $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
                $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
                $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
                // Verify data integrity
                $errors = [];
        
                // The name have to be filled
                if ( $email === false || empty($email) ) $errors[] = "L'email est vide";
                if ( $password === false || empty($password)) $errors[] = "Le mot de passe n'est pas valide'";        
                if ( $firstname === false || empty($firstname)) $errors[] = "Le prénom n'est pas valide'"; 
                if ( $lastname === false || empty($lastname)) $errors[] = "Le nom n'est pas valide'";
                if ( $role === false || empty($role)) $errors[] = "Le role n'est pas valide'";
                if ( $status === false || empty($status)) $errors[] = "Le statut n'est pas valide'";
        
                $user = new AppUser();
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setRole($role);
                $user->setStatus($status);
        
        
                // Insert only if no errors
                if ( count($errors) === 0 ) {
                    // Call insert model method and get result
                    $success = $user->insert();
        
                    if ( $success ) header("Location: /user-list");
                }
        
                $this->show('main/user-add', [
                    'users' => $user,
                    "errors" => $errors
                ]);
    }
}