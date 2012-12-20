<?php

class Index extends Controller {

	public function __construct() {
		parent::__construct('index');
	}

	public function index() {
		$transaction = new Model('transaction');
		$transaction->load(142);
		$this->view->transaction = $transaction;
		$this->render('index');
	}
}