<?php

require_once('csscrush/CssCrush.php');

class View {

	public $controller;
	public $styles = array();

	public function __construct($controller) {
		$this->controller = $controller;
	}

	public function addStylesheet($filename) {
		$this->styles[] = csscrush::tag(
			"css/$filename",
			array('debug' => false)
		);
	}

	public function render($action) {
		require("view/header.php");
		require("view/{$this->controller}/{$action}.php");
		require("view/footer.php");
	}

}