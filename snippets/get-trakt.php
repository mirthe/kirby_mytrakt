<?php if (!file_exists($localfile) || time()-filemtime($localfile) > 1800 || isset($_GET['forcecache'])) {
// when file is not available, older than 30 minutes, or forced

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $feedurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $site->title());

    $header = array("Content-type: application/json",
            "trakt-api-key: " . option('mirthe.mytrakt.apiKey'),
            "trakt-api-version: 2");
    curl_setopt($ch,CURLOPT_HTTPHEADER, $header); 

    $feed = curl_exec($ch);
    curl_close($ch);

    $fp = fopen($localfile, 'w');
    fwrite($fp, $feed);
    fclose($fp);

    // echo '<p>Nieuwe feed opgehaald.</p>';

    // TODO cache opschonen voor deze pagina, maar hoe is die syntax!?
    // $kirby->cache('page')->series()->flush();

} else {
    $feed = file_get_contents($localfile);
}
