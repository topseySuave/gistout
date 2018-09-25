<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/16/2017
 * Time: 2:54 PM
 */

require_once "func.php";
require_once "/../classes/trending-hashtag.php";

$TrendHashtags = new TrendingHashtags();

$trendCountRecent = 0;
$trendCountPrevious = 0;
$decayRate = 1/20;
$rate = 0;

/**
 * @start extracts trend and count, update the recent count field...
 * At the end of every 20 minutes.
 * Scan through all records in trending hash tag table
 **/
$TrendingHashtags = json_decode($TrendHashtags->getAll());
for ($i = 0; $i < sizeof($TrendingHashtags->trending_hashtag); $i++) {
    $trendingCountPrevious = $TrendingHashtags->trending_hashtag[$i]->last_count;
    $trendCountRecent = $TrendingHashtags->trending_hashtag[$i]->recent_count;
    $rate = $TrendingHashtags->trending_hashtag[$i]->rate;
    if(($trendCountRecent - $trendingCountPrevious) <= 0):
        $rate = $rate - $decayRate;
        $rate = ($rate < 0)? 0: $rate;
    else:
        $rate = ($trendCountRecent - $trendCountPrevious)/20;
    endif;
    $updatedTrendingRate = $TrendHashtags->updateByRate($TrendingHashtags->trending_hashtag[$i]->id, $rate);
    $updatedTrendingLastCount = $TrendHashtags->updateByLastCount($TrendingHashtags->trending_hashtag[$i]->id, $trendCountRecent);
}
