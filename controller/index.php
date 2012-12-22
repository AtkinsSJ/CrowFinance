<?php

class Index extends Controller {

	public function __construct() {
		parent::__construct('index');
	}

	public function index() {
		$transactions = new Collection('transactions');
		$transactions->sortBy('outgoing', 'DESC')
					->load();
		$this->view->transaction = $transactions;
		$this->render('index');
	}
}