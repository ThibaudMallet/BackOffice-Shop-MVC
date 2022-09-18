<?php
namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;

/**
 * Controller for categories
 */
class CategoryController extends CoreController
{

    public function list () {
        $this->checkAuthorization();
        // Get all categories with findAll method in model class
        // Use static syntax to avoid empty instance of Category class
        $categories = Category::findAll();

        // Create array with key value, to send it to the view
        $viewData = [
            'categories' => $categories
        ];

        // Call the list view for category
        $this->show('category/list', $viewData);
    }



    /**
     * Method to load the category form in order to insert category
     *
     * @return void
     */
    public function add () {
        $this->show('category/add-edit', [
            'category' => new Category()
        ]);
    }

    /**
     * Catch the post route to insert data
     *
     * @return void
     */
    public function insert () {
        // Extract name with filter input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        $homeorder = filter_input(INPUT_POST, 'home_order', FILTER_VALIDATE_INT);

        // Verify data integrity
        $errors = [];

        // The name have to be filled
        if ( $name === false || empty($name) ) $errors[] = "Le nom est vide";
        if ( $picture === false ) $errors[] = "L'url de l'image n'est pas valide'";        
        if ( $homeorder === false ) $homeorder = 0; 

        $categorie = new Category();
        $categorie->setName($name);
        $categorie->setSubtitle($subtitle);
        $categorie->setPicture($picture);
        $categorie->setHomeOrder($homeorder);


        // Insert only if no errors
        if ( count($errors) === 0 ) {
            // Call insert model method and get result
            $success = $categorie->insert();

            if ( $success ) header("Location: /category/list");
        }

        $this->show('category/add-edit', [
            'category' => $categorie,
            "errors" => $errors
        ]);
    }



    /**
     * Show form to update category
     *
     * @param [type] $id
     * @return void
     */
    public function edit ($id) {
        $this->checkAuthorization(['admin']);
        // Load category according to id
        $category = Category::find($id);

        // Load form template with category object
        $this->show('category/add-edit', [
            'category' => $category
        ]);
    }

    /**
     * Update a existing category (extremely similar to insert)
     *
     * @param [type] $id
     * @return void
     */
    public function update ($id) {
        // Extract name with filter input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        $homeorder = filter_input(INPUT_POST, 'home_order', FILTER_VALIDATE_INT);

        // Verify data integrity
        $errors = [];

        // The name have to be filled
        if ( $name === false || empty($name) ) $errors[] = "Le nom est vide";
        if ( $picture === false ) $errors[] = "L'url de l'image n'est pas valide'";        
        if ( $homeorder === false ) $homeorder = 0; 

        // Création d'une instance préremplie
        $categorie = Category::find($id);
        $categorie->setName($name);
        $categorie->setSubtitle($subtitle);
        $categorie->setPicture($picture);
        $categorie->setHomeOrder($homeorder);

         // Insert only if no errors
        if (count($errors) === 0) {
            $success = $categorie->update();
            if ( $success ) header("Location: /category/{$id}");
            else $errors[] = "Erreur de mise à jour :(";
        }

        $this->show('category/add-edit', [
            'category' => $categorie,
            "errors" => $errors
        ]);
    }



    /**
     * Remove a category
     *
     * @param [type] $id
     * @return void
     */
    public function delete ($id) {
        // Charge la cartegorie pour la supprimer ensuite
        $category = Category::find($id);
        $category->delete();

        // Redirige vers la liste
        $this->list();
    }
    public function manageHome()
    {        
        $categories = Category::findAll();

        $this->show('category/manage-home', [
            'categories' => $categories
        ]);
    }
    public function saveHome()
    {
        $emplacements = filter_input(INPUT_POST, "emplacement", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        //Reset tous les emplacements 
        Category::resetHomeOrder();

        foreach ($emplacements as $num_emplacement => $category_id) {
            // Ajoute 1 au numéro d'emplacement
            $num_emplacement++;
            // Recupère la catégorie
            $category = Category::find($category_id);
            // On change l'emplacement de la propriété
            $category->setHomeOrder($num_emplacement);
            // Met à jour la catégorie
            $category->save();
        }

        header("Location: /category/list");
    }
}



?>