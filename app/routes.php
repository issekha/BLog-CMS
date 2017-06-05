<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    $chapters = $app['dao.chapter']->findAll();
    return $app['twig']->render('index.html.twig', array('chapters' => $chapters));
})->bind('home');

// Chapter details with comments
$app->get('/chapter/{id}', function ($id) use ($app) {
    $chapter = $app['dao.chapter']->find($id);
    $comments = $app['dao.comment']->findAllByChapter($id);
    return $app['twig']->render('chapter.html.twig', array('chapter' => $chapter, 'comments' => $comments));
})->bind('chapter');

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');