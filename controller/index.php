<?php

class Index extends Controller {

	public function __construct() {
		parent::__construct('index');
	}

	public function index() {
		$this->view->title = "Hello, world!";
		$this->render('index');
	}
}