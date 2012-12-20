<?php

require_once('csscrush/CssCrush.php');

class View {

	public $controller;
	public $styles = array();

	public function __construct($controller) {
		$this->controller = $controller;
		$this->addStylesheet("style.css");

		$this->messages = Session::popMessages();
	}

	public function __get($name) {
		if (property_exists($this, $name)) {
			return $this->$name;
		} else {
			return array();
		}
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