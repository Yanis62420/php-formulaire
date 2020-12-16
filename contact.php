<?php

use \DateTime;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require __DIR__.'/vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__.'/templates');


$twig = new Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
]);

$twig->addExtension(new DebugExtension());

$errors = [];

if ($_POST) {
    $minLengthSubject = 3;
    $maxLengthSubject = 190;

    if (empty($_POST['email'])) {
        $errors['email'] = 'Veuillez ne pas laisser ce champ vide';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'Veuillez renseigner un email valide';
    } 

    if (empty($_POST['subject'])) {
        $errors['subject'] = 'Veuillez ne pas laisser ce champ vide';
    } elseif (strlen($_POST['subject']) < 3 || strlen($_POST['subject']) > 190) {
        $errors['subject'] = "Veuillez renseigner un sujet entre {$minLengthSubject} et {$maxLengthSubject} caractères inclus";
    }

    $minLengthMessage = 3;
    $maxLengthMessage = 1000;

    if (empty($_POST['message'])) {
        $errors['message'] = 'Veuillez ne pas laisser ce champ vide';
    } elseif (strlen($_POST['message']) < 3 || strlen($_POST['message']) > 1000) {
        $errors['message'] = "Veuillez renseigner entre {$minLengthMessage} et {$maxLengthMessage} caractères inclus";
    }
}

echo $twig->render('contact.html.twig', [
    'errors' => $errors,
]);