<?php
require "../accounts/vendor/autoload.php";
include ".includes/_db.php";
session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));
?>
<!-- *********************** Request display list of transaction ************************************* -->
<?php
$currentDate = date('Y-m-d');

$query = $accounts->prepare("SELECT
    id_transaction,
    name,
    amount,
    date_transaction,
    category_name,
    icon_class
FROM
    transaction
JOIN
    category USING (id_category)
WHERE
    MONTH(date_transaction) = :month
    AND YEAR(date_transaction) = :year

ORDER BY
    date_transaction DESC;");

$query->bindParam(':month', $_GET['month'], PDO::PARAM_INT);
$query->bindParam(':year', $_GET['year'], PDO::PARAM_INT);

$query->execute([':month' => $_GET['month'], ':year' => $_GET['year']]);
$displayTransactions = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ********************************* display rest amount***************************** -->
<?php
$displayMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$displayYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Déterminez le premier et le dernier jour du mois affiché
$firstDayOfMonth = date("$displayYear-$displayMonth-01");
$lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));

$queryBalance = $accounts->prepare("SELECT
    SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) AS total_recettes,
    SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) AS total_depenses
FROM
    transaction
WHERE
    date_transaction BETWEEN :firstDayOfMonth AND :lastDayOfMonth");

$queryBalance->bindParam(':firstDayOfMonth', $firstDayOfMonth, PDO::PARAM_STR);
$queryBalance->bindParam(':lastDayOfMonth', $lastDayOfMonth, PDO::PARAM_STR);
$queryBalance->execute();
$balanceResult = $queryBalance->fetch(PDO::FETCH_ASSOC);

$totalRecettes = $balanceResult['total_recettes'];
$totalDepenses = $balanceResult['total_depenses'];

// Calculez le solde total
$totalBalance = $totalRecettes - $totalDepenses;

?>
<!-- ********************************* Display month et year in the title***************************** -->
<?php
if (!empty($displayTransactions)) {
    $firstTransactionDate = strtotime($displayTransactions[0]['date_transaction']);
    $displayMonth = date('F', $firstTransactionDate);
    $displayYear = date('Y', $firstTransactionDate);
} else {
    $displayMonth = date('F');
    $displayYear = date('Y');
}
var_dump($totalBalance);

?>
<!-- ********************************* display rest amount***************************** -->
<?php
                        // Déterminez le mois et l'année à afficher (par exemple, à partir de la requête URL)
                        $displayMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
                        $displayYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

                        // display previous month
                        $previousMonth = $displayMonth - 1;
                        $previousYear = $displayYear;
                        if ($previousMonth <= 0) {
                            $previousMonth = 12;
                            $previousYear--;
                        }

                        // display next month
                        $nextMonth = $displayMonth + 1;
                        $nextYear = $displayYear;
                        if ($nextMonth > 12) {
                            $nextMonth = 1;
                            $nextYear++;
                        }
                        ?>
<!-- ********************************* display rest amount***************************** -->


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opérations de Juillet 2023 - Mes Comptes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

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
                    <input type="text" class="form-control" placeholder="Rechercher..." aria-describedby="button-search">
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
        <h2 class="my-0 fw-normal fs-4">Solde du mois en cours</h2>
    </div>
    <div class="card-body">
            <p class="card-title pricing-card-title text-center fs-1"><?= $totalBalance ?> €</p>
    </div>
</section>


        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
            <h1 class="my-0 fw-normal fs-4">Opérations de <?= strftime('%B', strtotime("$displayYear-$displayMonth-01")) . ' ' . $displayYear; ?></h1>


        </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Opération</th>
                            <th scope="col" class="text-end">Montant</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- display transactions -->
                        <?php foreach ($displayTransactions as $transaction) : ?>
                            <tr>
                                <td width="50" class="ps-3"></td>
                                <td>
                                    <time datetime="<?= $transaction['date_transaction']; ?>" class="d-block fst-italic fw-light">
                                        <?= date('d/m/Y', strtotime($transaction['date_transaction'])); ?>
                                    </time>
                                    <?= $transaction['name']; ?>
                                </td>
                                <td class="text-end">
                                    <span class="rounded-pill text-nowrap bg-warning-subtle px-2">
                                        <?= number_format($transaction['amount'], 2, ',', ' '); ?> €
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm rounded-circle">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav class="text-center">
                    <ul class="pagination d-flex justify-content-center m-2">
                        
                        <li class="page-item disabled">
                            <a class="page-link" href="index.php?month=<?= $previousMonth; ?>&year=<?= $previousYear; ?>">

                                <i class="bi bi-arrow-left"></i>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link"><?= date('F Y'); ?></span>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="index.php?month=<?= $previousMonth; ?>&year=<?= $previousYear; ?>">
                                <?= date('F Y', strtotime("$previousYear-$previousMonth-01")); ?>
                            </a>
                        </li>
                        <li class="page-item">
                            <span class="page-link">...</span>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="index.php?month=<?= $nextMonth; ?>&year=<?= $nextYear; ?>">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </div>

    <div class="position-fixed bottom-0 end-0 m-3">
        <a href="add.php" class="btn btn-primary btn-lg rounded-circle">
            <i class="bi bi-plus fs-1"></i>
        </a>
    </div>

    <footer class="py-3 mt-4 border-top">
        <p class="text-center text-body-secondary">© 2023 Mes comptes</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>