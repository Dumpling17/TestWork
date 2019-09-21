<?php
session_start();
include 'header.php';

$file = file_get_contents('account.tmp', FILE_USE_INCLUDE_PATH);
$json = json_decode($file, true);

$success = false;

for($i = 0; $i < count($json); $i++) {
    if ($json[$i]['login'] == $_SESSION['login'] && $json[$i]['password'] == $_SESSION['password']) {
        $success = true;
    }
}
?>

<script>
    $(function(){
        let add_task = $('.add-task');
        
        add_task.hide();
        $('.add-new-task').on('click', function(){
            add_task.show();
        });
        
        $('.add').on('click', function(){
            let new_name = $('.new-name');
            let new_email = $('.new-email');
            let new_text = $('.new-text');
            
            let collector = {'name': new_name.val(), 'email': new_email.val(), 'text': new_text.val(), 'param': $('.sort').val()};
            
            if (validateEmail(new_email.val())) {
                $('.validate').empty();
                if (new_name.val() != '' && new_email.val() != '' && new_text.val() != '') {
                    $.post('add.php', collector, function(data) {
                        
                        new_name.val('');
                        new_email.val('');
                        new_text.val('');
                        
                        add_task.hide();
                        
                        $('.list').append(data);
                        alert('Успешно');
                    });
                }
            } else {
                $('.validate').text('Не валидный email');
            }
        });
        
        $('.sort').on('change', function(){
            let sort_val = $('.sort').val();
            if (sort_val != '') {
                $.post('sort.php', {param: sort_val}, function(data) {
                    $('.list').empty();
                    $('.list').append(data);
                });
            }
        });
        
        $('.list').on('click', '.edit-save-task', function(){
            let id = $(this).parent().attr('data');
            let name = $(this).parent().find('.name').val();
            let email = $(this).parent().find('.email').val();
            let text = $(this).parent().find('.text').val();
            let completed = 0;
            
            if ($(this).parent().find('.completed').prop("checked")) {
                completed = 1;
            }
            
            let collector = {'id': id, 'name': name, 'email': email, 'text': text, 'completed': completed, 'param': $('.sort').val()};
            
            $.post('edit.php', collector, function(data) {
                if (data != 'No') {
                    $('.list').empty();
                    $('.list').append(data);
                    alert('Изменено');
                } else {
                    alert('Авторизируйтесь');
                }
            });
        });
        
        $('.authorization').on('click', function(){
            window.location.href = "http://apptest/authorization.php";
        });
        
        $('.exit').on('click', function(){
            $.post('exit.php', '', function(data) {
                if (data == 'success')
                    window.location.reload();
            });
        });
        
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    });
</script>

<div class="add-task">
    <div>
        <span>name </span><input class="new-name" type="text">
    </div>
    <div>
        <span>email </span><input class="new-email" type="text">
    </div>
    <div>
        <span>text </span><textarea class="new-text" type="text"></textarea>
    </div>
    
    <div class="validate" style="color: red;">
    </div>
    
    <button class="add">Добавить</button>
</div>

<div>
    <button class="add-new-task">Добавить новую задачу</button>
</div>

<div>
    <?php
    if (!$success) {
        echo '<button class="authorization">Авторизация</button>';
    } else {
        echo '<button class="exit">Выход</button>';
    }
    
    ?>
</div>

<div class='sort-div'>
    <select class="sort">
        <option value=""></option>
        <option value="name+">name(по возрастанию)</option>
        <option value="name-">name(по убыванию)</option>
        <option value="email">email</option>
        <option value="completed+">статус(выполненые)</option>
        <option value="completed-">статус(не выполненые)</option>
    </select>
</div>

<div class="list">
    <?php
    while($row = $contacts->fetch(PDO::FETCH_ASSOC)) {
        $completed = '<div class="no-completed">Не выполнена</div>';
        $editAdmin = '';
        
        if ($row['completed']) {
            $completed = '<div class="completed">Выполнена</div>';
        }
        
        if ($row['editAdmin']) {
            $editAdmin = '<div class="editAdmin">отредактировано администратором</div>';
        }
        
        if ($success) {
            $completed = '<input type="checkbox" class="completed" value="'.$row['completed'].'"/>';
            if ($row['completed']) {
                $completed = '<input type="checkbox" class="completed" value="'.$row['completed'].'" checked/>';
            }
            
            echo 
            '<div data='.$row['id'].' class="task">'.
                '<input class="name" value="'.$row['name'].'"/>'.
                '<input class="email" value="'.$row['email'].'"/>'.
                $completed.
                '<textarea class="text">'.$row['text'].'</textarea>'.
                $editAdmin.
                '<button class="edit-save-task">Сохранить</button>'.
            '</div>';
        } else {
            echo 
            '<div data='.$row['id'].' class="task">'.
                '<div class="name">'.$row['name'].'</div>'.
                '<div class="email">'.$row['email'].'</div>'.
                $completed.
                '<div class="text">'.$row['text'].'</div>'.
                $editAdmin.
            '</div>';
        }
    }
    ?>
</div>


</body>
</html>