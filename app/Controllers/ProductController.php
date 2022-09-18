<?php


namespace App\Controllers;

use App\Models\Brand;
use App\Models\Product;

/**
 * Controller for products
 */
class ProductController extends CoreController
{

    public function list () {
        // Get all products with findAll method in model class
        // Use static syntax to avoid empty instance of Product class
        $products = Product::findAll();

        // Call the list view for product
        $this->show('product/list', [
            'products' => $products
        ]);
    }

    public function add () {
        $product = new Product();
        // Call directly the view without loading specific data
        $this->show('product/add-edit', [
            'product' => $product
        ]);
    }

    public function edit($id) {
        $product = Product::find($id);
        $this->show('product/add-edit', [
            'product' => $product
        ]);
    }



    /**
     * Methode générique pour faire soit l'insert soit l'udpate en fonction du contexte
     *
     * @return void
     */
    public function save ($id=null) {

        // Extract name with filter input
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price');
        $rate = filter_input(INPUT_POST, 'rate');
        $status = filter_input(INPUT_POST, 'status');
        $brand_id = filter_input(INPUT_POST, 'brand_id');
        $category_id = filter_input(INPUT_POST, 'category_id');
        $type_id = filter_input(INPUT_POST, 'type_id');

        // Verify data integrity
        $errors = [];

        // The name have to be filled
        if ( $name === false || empty($name) ) $errors[] = "Le nom est vide";
        if ( $picture === false ) $errors[] = "L'url de l'image n'est pas valide'";   
        
        
        // Vérifie si on a un id pour charger l'instance
        if ( $id !== null ) $product = Product::find($id);
        else $product = new Product();

        // Remplissage des propriétés
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setstatus($status);
        $product->setBrandId($brand_id);
        $product->setCategoryId($category_id);
        $product->setTypeId($type_id);


        // only if no errors
        if ( count($errors) === 0 ) {
            // Call save model method and get result
            $success = $product->save();

            if ($success) {
                if ( $id !== null ) header("Location: /product/$id");
                else header("Location: /product/list");
            }
            else $errors = ["Problème de màj"];
        }

        $this->show('product/add-edit', [
            "errors" => $errors,
            "product" => $product
        ]);
    }
}



?>