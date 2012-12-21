<?php

class Transactions extends Controller {
	
	public function __construct() {
		parent::__construct('transactions');
	}

	public function view($dateString) {
		$dateParts = explode('-', $dateString);
		$date = new DateTime();
		$dateNext = new DateTime();
		$datePrevious = new DateTime();

		$transactions = new Collection('transactions');

		if (isset($dateParts[2])) { // year-month-day
			$transactions->filter('date = :date',
				array(
					'startDate' => implode('-', $dateParts)
			));
		} elseif (isset($dateParts[1])) { // year-month

		} else { // year

		}

		$transactions->sortBy('date', 'ASC')->load();

		$this->view->transactions = $transactions;

		$this->render('view');
	}

}