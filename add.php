<?php
require "../accounts/vendor/autoload.php";
include ".includes/_db.php";
session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));

?>


<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter une opération - Mes Comptes</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
    
    <body>
    var_dump($_POST['category']);

    <div class="container-fluid">
        <header class="row flex-wrap justify-content-between align-items-center p-3 mb-4 border-bottom">
            <a href="index.html" class="col-1">
                <i class="bi bi-piggy-bank-fill text-primary fs-1"></i>
            </a>
            <nav class="col-11 col-md-7">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link link-secondary" aria-current="page">Opérations</a>
                    </li>
                    <li class="nav-item">
                        <a href="summary.html" class="nav-link link-body-emphasis">Synthèses</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.html" class="nav-link link-body-emphasis">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a href="import.html" class="nav-link link-body-emphasis">Importer</a>
                    </li>
                </ul>
            </nav>
            <form action="" class="col-12 col-md-4" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher..."
                        aria-describedby="button-search">
                    <button class="btn btn-primary" type="submit" id="button-search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </header>
    </div>

    <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Ajouter une opération</h1>
            </div>
            <div class="card-body">
                <form method="post" action="action.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'opération *</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Facture d'électricité" required>
                            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">

                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date *</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Montant *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="amount" id="amount" required>
                            <span class="input-group-text">€</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Catégorie</label>
                        <select class="form-select" name="category" id="category">
                            <option value="" selected>Aucune catégorie</option>
                            <option value="1">Nourriture</option>
                            <option value="2">Loisir</option>
                            <option value="3">Travail</option>
                            <option value="4">Voyage</option>
                            <option value="5">Sport</option>
                            <option value="6">Habitat</option>
                            <option value="7">Cadeaux</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Ajouter</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="position-fixed bottom-0 end-0 m-3">
        <a href="add.html" class="btn btn-primary btn-lg rounded-circle">
            <i class="bi bi-plus fs-1"></i>
        </a>
    </div>

    <footer class="py-3 mt-4 border-top">
        <p class="text-center text-body-secondary">© 2023 Mes comptes</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>