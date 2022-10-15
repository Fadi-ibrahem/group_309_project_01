<?php

require_once '../../core/connection.php';
require_once '../../core/Validation.php';
require_once '../../core/helper.php';

session_start();

if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    $validationRules = [
        'name'          => ["required", "string", "max:50", "min:4"],
        'description'   => ["required", "string","min:4"],
    ];

    $validationObj = new Validation($validationRules);
    $validationObj->validate();


    if($validationObj->check()) {
        $query = "INSERT INTO `categories` (`name`, `description`)
                VALUES ('{$_REQUEST['name']}', '{$_REQUEST['description']}')";
        $result = mysqli_query($conn, $query);
        $affectedRows = mysqli_affected_rows($conn);

        if($affectedRows >= 1) {
            $_SESSION['success'] = "Category Inserted Successfully";
            header("Location: ../../pages/categories/index.php");
            exit;
        }
    } else {
        $_SESSION['errors'] = $validationObj->getErrors();
        header("Location: ../../pages/categories/add.php");
        exit;
    }
    

} else {
    header("Location: ../../pages/categories/index.php");
    exit;
}