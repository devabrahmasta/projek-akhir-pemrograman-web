<?php 
require_once(__DIR__ . "../../../config/connection.php");

session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_paket = $_POST['id_paket'];
    $id_trainer = $_POST['id_trainer'];

    $statement = $connection->prepare("SELECT * FROM paket_member WHERE id_paket = ?");
    $statement->bind_param('i', $id_paket);
    $data_paket = null;
    if ($statement->execute()) {
        
        $paket = $statement->get_result();
        $data_paket = $paket->fetch_object();
        $statement->close();
    }
   
    $statement = $connection->prepare("SELECT * from trainer WHERE id_trainer = ?");
    $statement->bind_param('i', $id_trainer);
    $data_trainer = null;
    if ($statement->execute()) {
        $trainer = $statement->get_result();
        $data_trainer = $paket->fetch_object();
        $statement->close();
    }
}
?>