<?php

class Controller {

	protected $view;

	public function __construct($name) {
		$this->view = new View($name);
	}
	
	public function render($action) {
		$this->view->render($action);
	}
	
}