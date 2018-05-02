<?php
/**
 * Created by PhpStorm.
 * User: Mitko Zhechev
 * Date: 02.5.2018 г.
 * Time: 10:01 ч.
 */

include_once "Models\News.php";

if (isset($_GET['date'])) {
	$date = $_GET['date'];
} else {
	$date = '';
}

if (isset($_GET['title'])) {
	$title = $_GET['title'];
} else {
	$title = '';
}

if (isset($_GET['sortdate']) && $_GET['sortdate'] == 'true') {
	$sortDate = true;
} else {
	$sortDate = false;
}

if (isset($_GET['sorttitle']) && $_GET['sorttitle'] == 'true') {
	$sortTitle = true;
} else {
	$sortTitle = false;
}

$newsModel = new Models\News();

$allNews = $newsModel->getAllNews($date, $title, $sortDate, $sortTitle);

if (!empty($allNews)) {
	header('Content-Type: application/json');
	echo json_encode($allNews);
} else {
	echo 'No RESULTS';
}