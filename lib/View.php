<?php

require_once('csscrush/CssCrush.php');

class View {

	public $controller;
	public $styles = array();

	public function __construct($controller) {
		$this->controller = $controller;
		$this->addStylesheet("style.css");
	}

	public function addStylesheet($filename) {
		$this->styles[] = csscrush::tag(
			Config::get('global', 'cssdir') . $filename,
			array('debug' => false)
		);
	}

	public function render($action) {
		require("view/header.php");
		require("view/{$this->controller}/{$action}.php");
		require("view/footer.php");
	}

}