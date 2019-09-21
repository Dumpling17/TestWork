<?php
require_once 'model/DataHandler.php';

class ContactsLogic {

	public function __construct() {
		$this->DataHandler = new Datahandler('localhost', 'mysql', 'test', 'root', '');
	}

	public function createContact($name, $email, $text){
        $sql = 'INSERT INTO `list` (`name`, `email`, `text`, `completed`, `editAdmin`) VALUES ("'.$name.'", "'.$email.'", "'.$text.'", 0, 0)';
        $results = $this->DataHandler->createData($sql); 
	}

	public function readContacts(){
		$sql = 'SELECT * FROM list';
		$results = $this->DataHandler->readsData($sql); 
		return $results;
	}

    public function readContactsSort($param){
        $sort = '';
        if (strpos($param, '+')) {
            $sort = ' DESC';
        }
        
        $param = str_replace('-', '', $param);
        $param = str_replace('+', '', $param);
        
		$sql = 'SELECT * FROM list ORDER BY ' . $param . $sort;
		$results = $this->DataHandler->readsData($sql); 
		return $results;
	}
    
	public function readContact($id){

	}

	public function updateContact($id, $name, $email, $text, $completed){
        $sql = 'UPDATE `list` SET `name`="'.$name.'",`email`="'.$email.'",`text`="'.$text.'",`completed`='.$completed.',`editAdmin`= 1 WHERE `id` = '.$id;
        $results = $this->DataHandler->updateData($sql); 
	}

	public function deleteContact($id){

	}
}