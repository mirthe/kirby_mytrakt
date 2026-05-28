<?php
$cache = kirby()->cache('mirthe.mytrakt');
$username = strtolower(option('mirthe.mytrakt.username'));
$cacheKey = 'trakt-' . $username . '-' . $cachesection;
$feed = $cache->get($cacheKey);
$force = isset($_GET['forcecache']);

if ($feed === null || $force) {
    $previousFeed = $feed;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $feedurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, kirby()->site()->title());

    $header = [
        'Content-type: application/json',
        'trakt-api-key: ' . option('mirthe.mytrakt.apiKey'),
        'trakt-api-version: 2'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $feed = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);

    if ($feed !== false && $error === 0 && $feed !== '') {
        $cache->set($cacheKey, $feed, 1800);
    } else {
        $feed = $previousFeed;
    }
}

if ($feed === null) {
    $feed = '[]';
}

