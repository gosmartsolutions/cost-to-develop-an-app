<?php
require 'application/Common.php';
$recordTracking = new Tracking();

$uid = n($_GET['uid']); //user id who clicked link or opened email
$tid = n($_GET['tid']); //email template id
$url = $_GET['url']; //url member clicked
$type = $_GET['type']; //link or open

if ($type == "link" && $url != "") {
    $recordTracking->addLinkClick($type, $uid, $tid, $url);
    header("Location: " . $url);
} else {
    $recordTracking->addOpen($type, $uid, $tid);
    header("Location: ".SCRIPT_URL."assets/images/transimage.gif");
}