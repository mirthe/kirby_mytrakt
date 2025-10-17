<?php $localfile =  __DIR__ . "/favmovies.json";
$feedurl = "https://api.trakt.tv/users/". option('mirthe.mytrakt.username') ."/recommendations/movies/title";
include('get-trakt.php'); ?>

<div class="masonry">
<?php $json_a = json_decode($feed,true);
foreach ($json_a as $key => $value): ?>

  <?php $imgcall = "https://api.themoviedb.org/3/movie/" . 
        $value[$value['type']]['ids']['tmdb'] .
        "?api_key=". option('themoviedb.apiKey'). "&append_to_response=images";

    $ch = curl_init($imgcall);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, kirby()->site()->title());
    $rawdata = curl_exec($ch);
    curl_close($ch);
    $movieinfo = json_decode($rawdata,true); ?>

<?php // $varlink = "https://letterboxd.com/tmdb/" . $value[$value['type']]['ids']['tmdb'];
$varlink = "https://trakt.tv/movies/" . $value[$value['type']]['ids']['slug'] ?>

<div class="block block--film">

    <?php if (array_key_exists('poster_path',$movieinfo) && $movieinfo['poster_path'] !== NULL): ?>
        <a href="<?= $varlink ?>"><img class="block--img" 
            width="500" height="500" 
            loading="lazy" src="<?= "https://image.tmdb.org/t/p/w500" . $movieinfo['poster_path'] ?>" 
            alt="Still from <?= $value[$value['type']]['title'] ?>"></a>
    <?php else: ?>
        <a href="<?= $varlink ?>" class="block--fallback"></a>
    <?php endif ?>

    <div class="block--body">

        <p><a href="<?= $varlink ?>"><?= $value[$value['type']]['title'] ?></a>
        <small>(<?= $value[$value['type']]['year'] ?>)</small></a><br>
        
        <?php if (array_key_exists('overview',$movieinfo) and $movieinfo['overview'] !== NULL): ?>
            <p><strong><?= $movieinfo['tagline'] ?></strong></p> 
            <p><?= mb_strimwidth($movieinfo['overview'],0,400,'&hellip;') ?></p>        
        <?php endif ?>

        <?php /* Notes zitten alleen in de IOS app begreep ik, Android en website volgen nog. Ooit.
        <p><q><?= mb_strimwidth($value['notes'],0,300,'&hellip;') ?></q></p> */ ?>
        
        <ul class="genres">
            <?php foreach ($movieinfo['genres'] as $genre) {
                echo  '<li>'. $genre['name'] . "</li>";
            } ?>
        </ul>
    </div>

</div>

<?php endforeach ?>
</div>