<?php

Kirby::plugin('mirthe/mytrakt', [
    'options' => [
        'apiKey' => option('trakt.apiKey'),
        'username' => option('trakt.username'),
        'limit' => 21
    ],
    'snippets' => [
        'trakt-episodes-watched' => __DIR__ . '/snippets/episodes.php',
        'trakt-movies-watched' => __DIR__ . '/snippets/movies.php',
        'trakt-favshows' => __DIR__ . '/snippets/favshows.php',
        'trakt-favmovies' => __DIR__ . '/snippets/favmovies.php'
    ]
]);