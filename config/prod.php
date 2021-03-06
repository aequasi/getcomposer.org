<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

// force ssl
$app->before(function (Request $request) {
    // skip SSL & non-GET/HEAD requests
    if (strtolower($request->headers->get('X_FORWARDED_PROTO')) == 'https' || !$request->isMethodSafe()) {
        return;
    }

    return new RedirectResponse('https://'.substr($request->getUri(), 7));
});

$app->after(function (Request $request, Response $response) {
    if (!$response->headers->has('Strict-Transport-Security')) {
        $response->headers->set('Strict-Transport-Security', 'max-age=2592000');
    }
});
