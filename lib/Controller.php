<?php

class Controller {

	protected $view;
	protected $user;

	public function __construct($name) {
		$this->user = new User();
		if ($this->user->isLoggedIn()) {
			Model::setUserId($this->user->getID());
		}

		$this->view = new View($name);
		$this->view->user = $this->user;
		$this->view->loggedIn = $this->user->isLoggedIn();
	}
	
	public function render($action) {
		$this->view->render($action);
	}
	
}