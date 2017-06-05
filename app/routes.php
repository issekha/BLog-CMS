<?php

use Symfony\Component\HttpFoundation\Request;
use WrtCMS\Domain\Comment;
use WrtCMS\Form\Type\CommentType;

// Home page
$app->get('/', function () use ($app) {
    $chapters = $app['dao.chapter']->findAll();
    return $app['twig']->render('index.html.twig', array('chapters' => $chapters));
})->bind('home');

// Chapter details with comments
$app->match('/chapter/{id}', function ($id, Request $request) use ($app) {
    $chapter = $app['dao.chapter']->find($id);
    $commentFormView = null;
    if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
        // A user is fully authenticated : he can add comments
        $comment = new Comment();
        $comment->setChapter($chapter);
        $user = $app['user'];
        $comment->setAuthor($user);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
        }
        $commentFormView = $commentForm->createView();
    }
    $comments = $app['dao.comment']->findAllByChapter($id);

    return $app['twig']->render('chapter.html.twig', array(
        'chapter' => $chapter, 
        'comments' => $comments,
        'commentForm' => $commentFormView));
})->bind('chapter');

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');