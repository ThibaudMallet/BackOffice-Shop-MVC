<div class="container my-4">
        <a href="<?= $this->router->generate('category-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2><?= $category->isPersited() ? "Modifier" : "Ajouter" ?> une catégorie</h2>

        
        <?php if ( isset($errors) ) dump($errors); ?>
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input required name="name" type="text" class="form-control" id="name" placeholder="Nom de la catégorie"
                value="<?= $category->getName(); ?>">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Sous-titre</label>
                <input name="subtitle" type="text" class="form-control" id="subtitle" placeholder="Sous-titre" aria-describedby="subtitleHelpBlock" value="<?= $category->getSubtitle(); ?>">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input required name="picture" type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="<?= $category->getPicture(); ?>">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="home_order" class="form-label">Home order</label>
                <input name="home_order" min="0" max="5" type="number" class="form-control" id="home_order" placeholder="Ordre sur la page d'acceuil" value="<?= $category->getHomeOrder() ?>">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>

    <!-- And for every user interaction, we import Bootstrap JS components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>