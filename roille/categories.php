<?php
session_start();
require('application/database.php');

$categories=listCategories();


// Sélection et affichage du template PHTML.
$template = 'categories';
include 'layout.phtml';