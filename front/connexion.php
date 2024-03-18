<div class="container py-4">

<main class="form-signin w-100 m-auto">
    <form name="loginForm" id="loginForm" method="post">

        <h1 class="h3 mb-3 fw-normal">Connexion</h1>

        <div class="form-floating">
        <input type="text" class="form-control" id="identifiant" name="identifiant" placeholder="">
        <label for="identifiant">Identifiant</label>
        </div>
        <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="">
        <label for="password">Mot de passe</label>
        </div>

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errors[0] ?>
            </div>
        <?php endif ?>

        <button type="submit" class="btn btn-dark y w-100 py-2">Se connecter</button>

        <p class="mt-5 mb-3 text-body-secondary">© Pokécardex</p>

    </form>
</main>

</div>