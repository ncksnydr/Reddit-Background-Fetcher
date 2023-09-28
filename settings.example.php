<?php

/*
    Alfred Background Fetcher
    @author Nick Snyder <nick@nicksnyder.is>

    $subreddit - [Name of Subreddit from URL; after /r/]
    $type - [top,new,hot]
    $range - [hour,day,week,month,year,all]
    $save_path - Where you want the images to go.
*/

$subreddit = 'EarthPorn';
$type = 'top';
$range = 'day';
$save_path = 'Documents/Backgrounds/';
$min_bg_width = 3300;

require_once('bg.php');
