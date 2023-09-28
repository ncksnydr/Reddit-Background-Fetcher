<?php
/** Create cache if it doesn't exist */
if (!file_exists('cache.txt')) {
	$my_file = 'cache.txt';
	$handle = fopen($my_file, 'w');
	fwrite($handle, '');
	fclose($handle);
}

/** Create run log if it doesn't exist. */
if (!file_exists('log.txt')) {
	$my_file = 'log.txt';
	$handle = fopen($my_file, 'w');
	fwrite($handle, '');
	fclose($handle);
}

/** Check if $save_path ends in a forward slash */
if (substr($save_path, -1) !== '/') {
	$save_path = $save_path . '/';
}

/** Add the home directory to the $save_path */
$save_path = $_SERVER['HOME'] . '/' . $save_path;

/** Create the directory if it doesn't exist */
if (!file_exists($save_path)) {
	mkdir($save_path, 0777, true);
}

/** Build the Feed URL */
if ($type == 'top' && isset($range)) {
	$feed_url = "https://www.reddit.com/r/{$subreddit}/{$type}.json?t={$range}";
} else {
	$feed_url = "https://www.reddit.com/r/{$subreddit}/{$type}.json";
}


// $contextOptions = array(
// 	"ssl" => array(
// 		"verify_peer" => false,
// 		"verify_peer_name" => false,
// 	),
// );

$contextOptions = array(
	'http' => array(
		'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
	)
);


/** Pull entries from the feed */
$feed = file_get_contents($feed_url, false, stream_context_create($contextOptions));
$feed = json_decode($feed, true);
$entries = $feed['data']['children'];

setLog();

foreach ($entries as $entry) {
	$data = $entry['data'];
	$data_id = $data['id'];
	$img = $data['preview']['images'];
	//$img = $data['url'];
	$filename = $data_id . '.jpg';
	$file = $save_path . $filename;
	$in_cache = getCache($filename);

	if (!$in_cache) {
		if (count($img) > 0) {
			$img = $img[0]['source'];
			$img_url = $data['url'];
			$img_width = $img['width'];
			$img_height = $img['height'];

			if ($img_width >= $min_bg_width && $img_width > $img_height) {
				var_dump($img_url);
				copy($img_url, $file, stream_context_create($contextOptions));
				setCache($filename);
			}
		}
	}
}


function setCache($filename) {
	$new_arr = array();
	$cache = file_get_contents('cache.txt');
	$arr = explode(',', $cache);

	array_push($new_arr, $filename);
	$new_arr = array_merge($new_arr, $arr);

	$output = implode(',', $new_arr);
	$fh = fopen('cache.txt', 'w');
	fwrite($fh, $output);
	fclose($fh);
}


function setLog() {
	$new_arr = array();
	$cache = file_get_contents('log.txt');
	$time = getdate();
	$timestamp = "{$time['year']}-{$time['mon']}-{$time['mday']}__{$time['hours']}{$time['minutes']}";
	$arr = explode(',', $cache);
	array_push($new_arr, $timestamp);
	$new_arr = array_merge($new_arr, $arr);
	$output = implode(',', $new_arr);
	$fh = fopen('log.txt', 'w');
	fwrite($fh, $output);
	fclose($fh);
}


function getCache($filename) {
	$cache = file_get_contents('cache.txt');
	$arr = explode(',', $cache);
	if (in_array($filename, $arr)) {
		return true;
	} else {
		return false;
	}
}





?>
