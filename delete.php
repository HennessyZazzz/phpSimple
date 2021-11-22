<?php
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        echo $_POST['filepath'];
        if (unlink($_SERVER['DOCUMENT_ROOT'] . "/images/" . $_POST['filepath'])) {
            $conn = new PDO("mysql:host=localhost;dbname=test-shop.com", "root", "");
            $sql = "DELETE FROM `news` WHERE `news`.`Id` = ?";
            $conn->prepare($sql)->execute([$_POST['id']]);
        }
    }
?>
