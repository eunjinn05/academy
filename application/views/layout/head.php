<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>M!N Engl!sh</title>
    
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/common.css" rel="stylesheet">
    
    <?php
    if (file_exists("assets/css/".$class_name.".css")) { ?>
      <link href="/assets/css/<?php echo $class_name?>.css" rel="stylesheet">
    <?php } ?>
  </head>
  <body class="d-flex h-100 text-center text-white bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column <?php if($this->router->fetch_class() == "main") echo "main-img"?>">

    <?php  include_once "menu.php"; ?>
