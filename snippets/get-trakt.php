<?php if (!file_exists($localfile) OR time()-filemtime($localfile) > 2 * 3600 OR isset($_GET['forcecache'])) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $feedurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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
} ?>