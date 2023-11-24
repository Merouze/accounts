<?php
require "../accounts/vendor/autoload.php";
include ".includes/_db.php";
session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));

?>
<?php
if (isset($_POST['name']) && (isset($_POST))) {
    $name = strip_tags($_POST['name']);
    $amount = strip_tags($_POST['amount']);
    $date_transaction = strip_tags($_POST['date']);
    $category_name = intval(strip_tags($_POST['category']));
    // *******************
    // *******************
    
    // Insérer la transaction
    $queryInsertTransaction = $accounts->prepare("INSERT INTO transaction (name, amount, date_transaction, id_category) VALUES (:name, :amount, :date_transaction, :id_category)");
$queryInsertTransaction->bindParam(':name', $name, PDO::PARAM_STR);
$queryInsertTransaction->bindParam(':amount', $amount, PDO::PARAM_STR);
$queryInsertTransaction->bindParam(':date_transaction', $date_transaction, PDO::PARAM_STR);
$queryInsertTransaction->bindParam(':id_category', $id_category, PDO::PARAM_INT);
$queryInsertTransaction->execute();

header("Location: index.php");
exit();
}


?>