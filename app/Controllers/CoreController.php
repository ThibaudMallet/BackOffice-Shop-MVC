<?php

namespace App\Controllers;

class CoreController
{
    protected $router;


    public function __construct($routeName, $router)
    {
        // Stock l'instance d'altorouter en lieux surs
        $this->router = $router;

        /* ACL */
        // Définition de mon tableau de routes et de profils autorisés sur chacunes
        $acl = [
            "main-home" => [],
            "category-list" => ["admin", "catalog-manager"],
            "category-add" => ["admin"],
            "category-insert" => ["admin"],
            "category-edit" => ["admin"],
            "category-update" => ["admin"],
            "category-delete" => ["admin"],
            "product-list" => ["admin", "catalog-manager"],
            "product-add" => ["admin", "catalog-manager"],
            "product-insert" => ["admin", "catalog-manager"],
            "product-edit" => ["admin", "catalog-manager"],
            "product-update" => ["admin", "catalog-manager"],
            "product-delete" => ["admin", "catalog-manager"],
            "user-list" => ["admin"],
            "user-add" => ["admin"],
            "user-insert" => ["admin"],
            "category-managehome" => ["admin"],
            "category-savehome" => ["admin"],
        ];

        // Est-ce que la route actuelle contient une restriction
        if ( isset($acl[$routeName]) ) {
            // Extraction des roles de l'acl
            $roles = $acl[$routeName];

            $this->checkAuthorization($roles);
        }

        // Il faudrait modifier la méthode pour exclure les routes de login :D
        // Si je n'ai pas de restriction de role spécifique, je vérifie quand 
        // meme que l'utilisateur soit connecté
        // $this->checkAuthorization();


        /* CSRF */
        // Liste des routes à protéger
        $csrfRoutes = [
            'user-insert' => "POST",
            'category-savehome' => "POST",
            "category-delete" => "GET"
        ];

        // Recherche de ma route actuelle avec les routes à vérifier
        if ( isset($csrfRoutes[$routeName]) ) {
            // Activation de la protection anti CSRF = vérification du token
            // Extraction du token de session
            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : null;


            // Extraction du token en fonction de la methode HTTP utilisé
            $method = $csrfRoutes[$routeName];
            if ( $method === "GET" ) {
                $userToken = filter_input(INPUT_GET, 'token');
            }
            else if ( $method === "POST" ) {
                //Extraction du token présent dans le formulaire
                $userToken = filter_input(INPUT_POST, 'token');
            }
            else {
                $userToken = "";
            }

            // Comparaison des 2 token (1 client et 1 serveur)
            if ( empty($userToken) || $userToken !== $sessionToken ) {
                // Erreur de token
                http_response_code(403);
                // Puis on affiche la page d'erreur 403
                $this->show('error/err403', [
                    "errors" => [
                        "Haha tu n'as pas le token CSRF"
                    ]
                ]);
                // Enfin on arrête le script pour que la page demandée ne s'affiche pas
                exit;
            }
        }
    }


    /**
     * Générer une chaine de char aléatoire, qui me servira de token anti CSRF
     *
     * @return String : Token généré
     */
    private function generateCSRFToken () :string {
        // Génération du token
        $token = bin2hex(random_bytes(32));
        // J'en profite pour le stocké en session (de l'utilisateur)
        $_SESSION['token'] = $token;
        return $token;
    }


    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }


    public function checkAuthorization ($roles=[]) {
        // Si le user est connecté
        if ( isset($_SESSION['userId']) && isset($_SESSION['userObject']) ) {
            // Alors on récupère l'utilisateur connecté
            $user = $_SESSION['userObject'];

            // Puis on récupère son role
            $userRole = $user->getRole();

            // si le role fait partie des roles autorisées (fournis en paramètres)
            // ou que tous les rôles sont ok
            if ( count($roles) === 0 || in_array($userRole, $roles) ) {
                // Alors on retourne vrai
                return true;
            }
            // Sinon le user connecté n'a pas la permission d'accéder à la page
            else {
                // => on envoie le header "403 Forbidden"
                http_response_code(403);
                // Puis on affiche la page d'erreur 403
                $this->show('error/err403', [
                    "errors" => [
                        "Page non accessible en tant que $userRole"
                    ]
                ]);
                // Enfin on arrête le script pour que la page demandée ne s'affiche pas
                exit;
            }
        }
        // Sinon, l'internaute n'est pas connecté à un compte
        else {
            // Alors on le redirige vers la page de connexion
            header('Location: /login');
            exit;
        }
    }
}
