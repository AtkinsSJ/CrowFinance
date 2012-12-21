<?php

class Login extends Controller {
	
	public function __construct() {
		parent::__construct('login');
	}

	public function index() {

		// If already logged in
		if ($this->user->isLoggedIn()) {
			$this->render('index');
			return;
		}

		// If user tried to log in
		if (isset($_POST['username'])
			&& isset($_POST['password'])) {

			// Attempt to login
			$success = $this->user->login($_POST['username'], $_POST['password']);

			if ($success) {
				Session::pushMessage('You have successfully logged-in as '. $this->user->getDisplayName());
				redirect('index');
				return;
			}

			// Incorrect login
			$this->view->pushMessage('The login details you enterred were incorrect. Please try again.', Message::ERROR);
			$this->view->username = $_POST['username'];
		}

		// Render the page!
		$this->render('index');

	}

}