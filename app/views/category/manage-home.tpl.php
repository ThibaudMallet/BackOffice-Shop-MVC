<?php 

function getOptions ($categories, $num) {
    foreach ($categories as $category) {
        $selected = $category->getHomeOrder() == $num ? "selected" : "";

        echo "<option value='{$category->getId()}' $selected>
            {$category->getName()}
        </option>";
    }
}

?>


<div class="container my-4">
    <a href="<?= $this->router->generate('category-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2>Gérer l'emplacement des catégories sur la page d'accueil</h2>
    <form action="" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $this->generateCSRFToken(); ?>">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="emplacement1">Emplacement #1</label>
                    <select class="form-control" id="emplacement1" name="emplacement[]">
                        <option value="">choisissez :</option>
                        <?php getOptions($categories, 1) ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="emplacement2">Emplacement #2</label>
                    <select class="form-control" id="emplacement2" name="emplacement[]">
                        <option value="">choisissez :</option>
                        <?php getOptions($categories, 2) ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="emplacement3">Emplacement #3</label>
                    <select class="form-control" id="emplacement3" name="emplacement[]">
                        <option value="">choisissez :</option>
                        <?php getOptions($categories, 3) ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="emplacement4">Emplacement #4</label>
                    <select class="form-control" id="emplacement4" name="emplacement[]">
                        <option value="">choisissez :</option>
                        <?php getOptions($categories, 4) ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="emplacement5">Emplacement #5</label>
                    <select class="form-control" id="emplacement5" name="emplacement[]">
                        <option value="">choisissez :</option>
                        <?php getOptions($categories, 5) ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>