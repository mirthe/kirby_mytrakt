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

if (!function_exists('get_img_from_themoviedb')) {
    function get_img_from_themoviedb(string $url): array {
        $cache = kirby()->cache('mirthe.mytrakt');
        $cacheKey = 'tmdb-' . sha1($url);
        $cached = $cache->get($cacheKey);

        if (is_array($cached)) {
            return $cached;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, kirby()->site()->title());
        $rawdata = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);

        $result = [];

        if ($rawdata !== false && $error === 0) {
            $decoded = json_decode($rawdata, true);
            $result = is_array($decoded) ? $decoded : [];
        }

        if ($result !== []) {
            $cache->set($cacheKey, $result, 60 * 60 * 24 * 7);
        }

        return $result;
    }
}

if ($feed === null) {
    $feed = '[]';
}

