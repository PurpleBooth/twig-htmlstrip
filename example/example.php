#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__);
$twig = new Twig_Environment($loader, []);
$twig->addExtension(new \PurpleBooth\HtmlStripperExtension());

$yourHtml = <<<'EXAMPLEHTML'
<p>Hello, world.</p>
EXAMPLEHTML;

echo $twig->render('example.txt.twig', ['yourhtml' => $yourHtml]);
// #=> Hello, world.
