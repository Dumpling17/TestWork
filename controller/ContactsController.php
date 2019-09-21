<?php
require_once 'model/ContactsLogic.php';
class ContactsController{
	
	public function __construct() {
		$this->ContactsLogic = new ContactsLogic();
	}

	public function handleRequest()
	{
        try {
            $op = isset($_REQUEST['op'])?$_REQUEST['op']:NULL;
			switch ($op) {
				case 'create':
				$this->collectCreateContact();
				break;
				case 'reads':
				$this->collectReadContacts();
				break;
				case 'read':
				$this->collectReadContact($_REQUEST['id']);
				break;
				case 'update':
				$this->collectUpdateContact();
				break;
				case 'delete':
				$this->collectDeleteContact($_REQUEST['id']);
				break;
				default:
				$this->collectReadContacts();
				break;
			}			
		} catch (ValidationException $e) {
            $errors = $e->getErrors();
		}
		
	}

	public function collectCreateContact(){

	}

	public function collectReadContacts(){
		$contacts = $this->ContactsLogic->readContacts();
		include 'view/body.php';
	}
    
	public function collectReadContact($id){

	}
	
	public function collectUpdateContact(){

	}		

	public function collectDeleteContact($id){

	}
	public function __destruct(){

	}

}

?>