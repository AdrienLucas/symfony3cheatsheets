<?php

require(__DIR__.'/vendor/autoload.php');

use Symfony\Component\Finder\Finder;

try {

    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__), [
        'cache' => false,
    ]);

    $cheatsheets = $twig->loadTemplate('layout.html.twig');

    $sheets = new Finder();
    $sheets->files()
        ->name('*.html.twig')
        ->in(__DIR__.'/sheets');

    $includes = [];
    foreach ($sheets as $sheet) {
        $includes[] = [$sheet->getBasename('.html.twig'), 'sheets/'.$sheet->getFilename()];
    }

    echo $cheatsheets->render([
        'sheets' => $includes
    ]);

} catch (\Exception $e) {
    echo "An error occurred while building the cheatsheet : ".$e->getMessage();
}
