<?php $localfile =  __DIR__ . "/episodes.json";
$feedurl = "https://api.trakt.tv/users/". 
    option('mirthe.mytrakt.username') .
    "/history/episodes/?extended=full&limit=" .
    option('mirthe.mytrakt.limit');
include('get-trakt.php'); ?>

<div class="masonry">
<?php $json_a = json_decode($feed, true);
$counter = 0;
foreach ($json_a as $key => $value):
    
    if ($counter == $limit) {break;} ?>

    <?php $varlink = "https://trakt.tv/shows/" .
        $value['show']['ids']['slug'] .
        "/seasons/" . $value['episode']['season'] .
        "/episodes/" . $value['episode']['number'];

        $epnr = "S" . str_pad($value['episode']['season'],'2','0',STR_PAD_LEFT) .
            "E". str_pad($value['episode']['number'],'2','0',STR_PAD_LEFT); 
    
    $imgcall = "https://api.themoviedb.org/3/tv/".
        $value['show']['ids']['tmdb'].
        "/images?include_image_language=en,nl,null&&api_key=". 
        option('themoviedb.apiKey');

    $ch = curl_init($imgcall);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $rawdata = curl_exec($ch);
    curl_close($ch);
    $movieinfo = json_decode($rawdata, true); ?>

    <div class="block block--compact block--tv">
        <?php if (count($movieinfo['posters'])): ?>
            <a href="<?= $varlink ?>" title="<?= $value['show']['title'] ?> - <?= $epnr ?> <?= $value['episode']['title'] ?>"><img class="block--img" 
                    width="450" height="500" loading="lazy"
                    src="<?= "https://image.tmdb.org/t/p/w500" . $movieinfo['posters'][0]['file_path'] ?>"
                    alt="">
            </a>
        <?php else: ?>
            <a href="<?= $varlink ?>" class="block--fallback"></a>
        <?php endif ?>
        <div class="block__overlay">
            <?= $epnr ?>
        </div>
    </div>

    <?php $counter++;
    endforeach ?>
</div>
