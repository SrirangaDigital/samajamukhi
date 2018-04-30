<?php

class data extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function insert() {

		$this->model->insertProfile('acharya');
		$this->model->insertProfile('granthakara');
		// granthakara
	}
}

?>
