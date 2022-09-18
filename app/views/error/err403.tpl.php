<h1>403 Forbidden</h1>

<p>
    <?php if(isset($errors)) dump($errors); ?>
</p>

<a href="<?= $this->router->generate('main-home') ?>">retour à l'accueil</a>