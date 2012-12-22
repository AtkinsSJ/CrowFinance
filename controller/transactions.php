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
					'date' => implode('-', $dateParts)
			));
		} elseif (isset($dateParts[1])) { // year-month
			$startDate = new DateTime("{$dateParts[0]}-{$dateParts[1]}-01");
			$endDate = clone $startDate;
			$endDate->modify('+'.($endDate->format('t')-1).' days');

			$transactions->filter('date BETWEEN :startDate AND :endDate',
				array(
					'startDate' => $startDate->format('Y-m-d'),
					'endDate' => $endDate->format('Y-m-d')
			));
		} else { // year
			$transactions->filter('date BETWEEN :startDate AND :endDate',
				array(
					'startDate' => "{$dateParts[0]}-01-01",
					'endDate' => "{$dateParts[0]}-12-31",
			));
		}

		$transactions->sortBy('date', 'ASC')->load();

		$this->view->transactions = $transactions;

		$this->render('view');
	}

}