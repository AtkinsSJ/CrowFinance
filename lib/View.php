<?php

class View {

	public $controller;

	public function __construct($controller) {
		$this->controller = $controller;
	}


	public function render($action) {
		require("view/header.php");
		require("view/{$this->controller}/{$action}.php");
		require("view/footer.php");
	}

}