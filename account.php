<?php

$file = file_get_contents('account.tmp', FILE_USE_INCLUDE_PATH);
$json = json_decode($file, true);

for($i = 0; $i < count($json); $i++) {
    if ($json[$i]['login'] == $_POST['login'] && $json[$i]['password'] == $_POST['password']) {
        
        session_start();
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['password'] = $_POST['password'];
        
        echo 'success';
    }
}

?>