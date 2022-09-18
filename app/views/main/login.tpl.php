<?php isset($errors) ? (dump($errors)) : ""; ?>
<div class="container my-4">
        <h2>Connexion</h2>
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input required name="email" type="email" class="form-control" id="email" placeholder="Votre Email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input required name="password" type="password" class="form-control" id="password" placeholder="Votre mot de passe">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Se connecter</button>
            </div>
        </form>
    </div>

    <!-- And for every user interaction, we import Bootstrap JS components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>