<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']))
{
  header('Location: login.php');
};


  $stmt = $pdo->prepare("DELETE FROM categories WHERE id=".$_GET['id']);
  $stmt->execute();
    echo"<script>alert('Values is Successfully Deleted');window.location.href='category.php';</script>";
?>
