<?php

if (!isset($_SESSION["login"])) {
    return;
}
$groupId = $_POST["group"];
$group = Database::getInstance()->getGroupById($groupId);
if ($group == FALSE) {
    return;
}
if (!Database::getInstance()->isSessionUserMemberOfGroup($group)) {
    return;
}
$posts = Database::getInstance()->getNewPosts($group, 6);
if ($posts != FALSE) {
    echo count($posts);
}else{
    echo 0;
}
        
    

