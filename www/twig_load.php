<?php

require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');
$twig = new \Twig\Environment($loader);

?>