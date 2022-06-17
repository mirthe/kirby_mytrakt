<?php $localfile =  __DIR__ . "/movies.json";
$feedurl = "https://api.trakt.tv/users/". option('mirthe.mytrakt.username') ."/history/movies/?extended=full&limit=" . option('mirthe.mytrakt.limit');
include('get-trakt.php'); ?>

<div class="masonry">
<?php $json_a = json_decode($feed,true);
foreach ($json_a as $key => $value): ?>

<div class="block">

    <?php $varlink = "https://trakt.tv/movies/" . 
        $value['movie']['ids']['slug'];
        
    $imgcall = "https://api.themoviedb.org/3/movie/" . 
        $value['movie']['ids']['tmdb']. 
        "?api_key=". option('themoviedb.apiKey'). "&append_to_response=images";

    // TODO retrieve rating?

    $ch = curl_init($imgcall);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $rawdata = curl_exec($ch);
    curl_close($ch);
    $movieinfo = json_decode($rawdata,true); ?>

    <?php if (array_key_exists('poster_path',$movieinfo) && $movieinfo['poster_path'] !== NULL): ?>
        <a href="<?= $varlink ?>"><img class="block--img" 
            width="500" height="500" 
            loading="lazy" src="<?= "https://image.tmdb.org/t/p/w500" . $movieinfo['poster_path'] ?>" 
            alt="Still from <?= $value['movie']['title'] ?>"></a>
    <?php else: ?>
        <a href="<?= $varlink ?>" class="block--fallback"></a>
    <?php endif ?>

    <div class="block--body">

        <p><a href="<?= $varlink ?>" class="subtiel" title="Bekijken op IMDb"><?= $value['movie']['title'] ?>
        <small>(<?= $value['movie']['year'] ?>)</small></a><br>
        <!-- <span style="color: silver"><?= strftime("%e %b %Y", strtotime($value['watched_at'])) ?></span></p> -->
        
        <p><strong><?= $value['movie']['tagline'] ?></strong></p>
        <p><?= mb_strimwidth($value['movie']['overview'],0,300,'&hellip;') ?></p>

        <ul class="genres">
            <?php foreach ($value['movie']['genres'] as $genre) {
                    echo  '<li>'. $genre . "</li>";
                } ?>
        </ul>
        
    </div>

</div>

<?php endforeach ?>
</div>