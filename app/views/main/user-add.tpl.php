<div class="container my-4">
    <a href="<?= $this->router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2><?= $user->isPersited() ? "Modifier" : "Ajouter" ?> un utilisateur</h2>

    <?php if ( isset($errors) ) dump($errors); ?>
    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="token" value="<?= $this->generateCSRFToken(); ?>">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="Email de l'utilisateur"
                value="">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input  name="password" type="password" class="form-control" id="description" placeholder="Mot de passe" value="">
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input  name="firstname" type="text" class="form-control" id="firstname" placeholder="Prénom de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input  name="lastname" type="text" class="form-control" id="lastname" placeholder="Nom de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" name="role" id="role">
                <option value="catalog-manager">Gestionnaire de catalogue</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" name="status" id="status">
                <option value="0">-</option>
                <option value="1">Actif</option>
                <option value="2">Désactivé</option>
            </select>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>

<!-- And for every user interaction, we import Bootstrap JS components -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>