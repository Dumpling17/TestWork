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
require_once 'model/ContactsLogic.php';

$contactsLogic = new ContactsLogic();

$contacts = $contactsLogic->updateContact($_POST['id'], $_POST['name'], $_POST['email'], $_POST['text'], $_POST['completed']);

if ($_POST['param'] != '') {
    $contacts = $contactsLogic->readContactsSort($_POST['param']);
} else {
    $contacts = $contactsLogic->readContacts();
}
    
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
} else {
    echo 'No';
}

?>