<div class="container my-4">
    <a href="<?= $this->router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2><?= $product->isPersited() ? "Modifier" : "Ajouter" ?> un produit</h2>

    <?php if ( isset($errors) ) dump($errors); ?>
    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Nom du produit"
                value="<?= $product->getName() ?>"
            >
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Description</label>
            <input  name="subtitle" type="text" class="form-control" id="description" placeholder="Description" aria-describedby="descriptionHelpBlock"
            value="<?= $product->getDescription() ?>"
            >
            <small id="descriptionHelpBlock" class="form-text text-muted">
                Description du produit
            </small>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input  name="picture" type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input  name="price" type="number" step="0.01" class="form-control" id="price" placeholder="Prix du produit">
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Note</label>
            <input  name="rate" type="number" class="form-control" id="rate" placeholder="Note du produit">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <input  name="status" type="number" class="form-control" id="status" placeholder="Statut du produit" aria-describedby="statusHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                Le statut du produit (1=dispo, 2=pas dispo)
            </small>
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Id de la marque</label>
            <input  name="brand_id" type="number" class="form-control" id="brand_id" placeholder="Id de la marque">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Id de la catégorie</label>
            <input  name="category_id" type="number" class="form-control" id="category_id" placeholder="Id de la catégorie">
        </div>
        <div class="mb-3">
            <label for="type_id" class="form-label">Id du type</label>
            <input  name="type_id" type="number" class="form-control" id="type_id" placeholder="Id du type">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>

<!-- And for every user interaction, we import Bootstrap JS components -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>