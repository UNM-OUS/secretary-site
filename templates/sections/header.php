<?php

use DigraphCMS\Media\Media;
use DigraphCMS\UI\Templates;
use DigraphCMS\URL\URL;

$url = new URL('/');
echo "<header id=\"header\">";
echo "<div id='header__wrapper'>";

echo "<h1><a href='$url'>";
$logo = Media::get('/logo.png');
printf('<img src="%s" alt="Office of the University Secretary">', $logo->url());
echo "</a></h1>";

echo Templates::render('sections/navbar.php');

echo "</div>";
echo "</header>";
