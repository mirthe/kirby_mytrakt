<?php $localfile =  __DIR__ . "/episodes.json";
$feedurl = "https://api.trakt.tv/users/". 
    option('mirthe.mytrakt.username') .
    "/history/episodes/?extended=full&limit=" . 
    option('mirthe.mytrakt.limit');
include('get-trakt.php'); ?>

<div class="masonry">
    <?php $json_a = json_decode($feed, true);
    foreach ($json_a as $key => $value): ?>

    <div class="block block--tv">

        <?php $varlink = "https://trakt.tv/shows/" .
        $value['show']['ids']['slug'] .
            "/seasons/" . $value['episode']['season'] .
            "/episodes/" . $value['episode']['number'];
        
        $imgcall = "https://api.themoviedb.org/3/tv/" .
        $value['show']['ids']['tmdb'] .
            "/season/" . $value['episode']['season'] .
            "/episode/" . $value['episode']['number'] .
            "?api_key=". option('themoviedb.apiKey'). "&append_to_response=images";

        $ch = curl_init($imgcall);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        $movieinfo = json_decode($rawdata, true); ?>

        <?php if (array_key_exists('still_path', $movieinfo) && $movieinfo['still_path'] !== null): ?>
        <a href="<?= $varlink ?>"><img class="block--img" width="500"
                height="281" loading="lazy"
                src="<?= "https://image.tmdb.org/t/p/w500" . $movieinfo['still_path'] ?>"
                alt="Still from <?= $value['episode']['title'] ?>"></a>
        <?php else: ?>
        <a href="<?= $varlink ?>" class="block--fallback"></a>
        <?php endif ?>

        <div class="block--body">

            <p><a href="<?= $varlink ?>"><?= $value['episode']['season'] ?>x<?= $value['episode']['number'] ?>
                    <?= $value['episode']['title'] ?></a><br>
                <a href="https://www.imdb.com/title/<?= $value['show']['ids']['imdb'] ?>"
                    class="subtiel" title="Bekijken op IMDb"><?= $value['show']['title'] ?>
                    <small>(<?= $value['show']['year'] ?>)</small></a><br>
            </p>

            <?php if($value['episode']['overview']): ?>
                <p><?= mb_strimwidth($value['episode']['overview'], 0, 300, '&hellip;') ?></p>
            <?php endif ?>

            <ul class="genres">
                <?php foreach ($value['show']['genres'] as $genre) {
                    echo  '<li>'. $genre . "</li>";
                } ?>
            </ul>

        </div>

    </div>

    <?php endforeach ?>
</div>