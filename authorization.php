<?php

session_start();

$file = file_get_contents('account.tmp', FILE_USE_INCLUDE_PATH);
$json = json_decode($file, true);

$success = false;

for($i = 0; $i < count($json); $i++) {
    if ($json[$i]['login'] == $_SESSION['login'] && $json[$i]['password'] == $_SESSION['password']) {
        $success = true;
    }
}

if ($success) {
    header("Location: http://apptest");
    exit;
}

?>
<link rel="stylesheet" href="styleLogin.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
    $(function(){
        $('.entry').on('click', function(){
            let login = $('.login').val();
            let password = $('.password').val();
            let error = $('.error');
            
            if(login != '' && password != ''){
                $.post('account.php', {'login': login, 'password': password}, function(data) {
                    if (data == 'success') {
                        window.location.href = "http://apptest/";
                    } else {
                        error.text('Не верные данные');
                    }
                });
            } else {
                error.text('Поля должны быть заполнены');
            }
        });
    });
</script>

<div class="authorization">
    <div>
        <div>Логин</div>
        <input type="text" class="login">
    </div>
    <div>
        <div>Пароль</div><input type="password" class="password">
    </div>
    <div>
        <div style="color: red;" class="error"></div>
    </div>
    <div>
        <button class="entry">Войти</button>
    </div>
</div>