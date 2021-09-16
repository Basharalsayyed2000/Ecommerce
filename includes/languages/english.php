<?php 
function langua ( $statment ){
static $trans = array(
    //navbar word
    'HOME_ADMIN'=>'Home',
    'CATAGORIES'=>'Catagories',
    'ITEMS'=>'Items',
    'MEMBERS'=>'Members',
    'STATISTICS'=>'Statistics',
    'LOGS'=>'logs',
    'LOGOUT'=>'logout',
    'SETTINGS'=>'Settings',
    'COMMENTS'=>'Comments',
    'EDITPROFILE'=>'Edit Profile'
);
return $trans[$statment];
}
?>