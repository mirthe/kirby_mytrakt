<?php

Kirby::plugin('mirthe/mytrakt', [
    'options' => [
        'apiKey' => option('trakt.apiKey'),
        'username' => option('trakt.username'),
        'limit' => 21,
        'cache' => true
    ],
    'translations' => [
        'nl' => [
            'mirthe.mytrakt.view-on-imdb' => 'Bekijken op IMDb'
        ],
        'en' => [
            'mirthe.mytrakt.view-on-imdb' => 'View on IMDb'
        ]
    ],
    'snippets' => [
        'trakt-episodes-watched' => __DIR__ . '/snippets/episodes.php',
        'trakt-episodes-watched-compact' => __DIR__ . '/snippets/episodes-compact.php',
        'trakt-movies-watched' => __DIR__ . '/snippets/movies.php',
        'trakt-favshows' => __DIR__ . '/snippets/favshows.php',
        'trakt-favmovies' => __DIR__ . '/snippets/favmovies.php'
    ]
]);