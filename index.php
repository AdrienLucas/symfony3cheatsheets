<?php

require(__DIR__.'/vendor/autoload.php');
//require_once '/path/to/lib/Twig/Autoloader.php';

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

    /*
    $buildPath = __DIR__.'/build';
    if (!$fs->exists($buildPath)) {
        $fs->mkdir($buildPath);
    }
    */


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

} catch (IOExceptionInterface $e) {
    echo "An error occurred while building the cheatsheet : ".$e->getMessage();
}
