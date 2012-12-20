<?php

class Error extends Controller {
	function __construct() {
		parent::__construct('error');
		//echo 'This is an error.';
	}
	
	public function index() {
		$this->view->title = 'Error: No Error Detected';
		$this->view->msg = 'You\'ve found the error page! However, there hasn\'t actually been an error.';
		$this->view->render('index');
	}
	
	public function error404($url){
		header('HTTP/1.0 404 Not Found');
		$this->view->title = 'Error 404: File not found.';
		$this->view->msg = "
			<p>
				Having conducted a thorough search, including behind the
				sofa and in the attic, Cyril the hamster could not find
				<b>{$url}</b>. Possible explanations include:
			</p>
			<ul>
				<li>Cyril wasn't trying hard enough.</li>
				<li>You mis-typed the URL by accident. Don't feel bad, we all have days like that.</li>
				<li>Somebody else entered the URL wrong in a link, and you clicked on it.</li>
				<li>I've broken something. (Somewhat likely.)</li>
				<li>The web server has run out of coal.</li>
				<li>You're just having a bad day.</li>
			</ul>";
		$this->view->render('index');
	}
}

?>