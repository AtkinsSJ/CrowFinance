<?php

class Transactions extends Controller {
	
	public function __construct() {
		parent::__construct('transactions', true);
	}

	public function index() {
		$date = new DateTime();
		$this->view($date->format('Y-m'));
	}

	public function view($dateString) {
		$dateParts = explode('-', $dateString);

		$previousDate = null;
		$nextDate = null;

		$transactions = new Collection('transactions');

		if (isset($dateParts[2])) { // year-month-day
			$transactions->filter('date = :date',
				array(
					'date' => implode('-', $dateParts)
			));

			$d = new DateTime(implode('-', $dateParts));
			$d->modify('-1 day');
			$previousDate = $d->format('Y-m-d');
			$d->modify('+2 days');
			$nextDate = $d->format('Y-m-d');

		} elseif (isset($dateParts[1])) { // year-month
			$startDate = new DateTime("{$dateParts[0]}-{$dateParts[1]}-01");
			$endDate = clone $startDate;
			$endDate->modify('+'.($endDate->format('t')-1).' days');

			$transactions->filter('date BETWEEN :startDate AND :endDate',
				array(
					'startDate' => $startDate->format('Y-m-d'),
					'endDate' => $endDate->format('Y-m-d')
			));

			$startDate->modify('-1 day');
			$previousDate = $startDate->format('Y-m');
			$endDate->modify('+1 day');
			$nextDate = $endDate->format('Y-m');

		} else { // year
			$transactions->filter('date BETWEEN :startDate AND :endDate',
				array(
					'startDate' => "{$dateParts[0]}-01-01",
					'endDate' => "{$dateParts[0]}-12-31",
			));

			$d = new DateTime("{$dateParts[0]}-01-01");
			$d->modify('-1 year');
			$previousDate = $d->format('Y');
			$d->modify('+2 years');
			$nextDate = $d->format('Y');
		}

		$transactions->sortBy('date', 'ASC')->load();

		$totalIn = 0;
		$totalOut = 0;
		foreach ($transactions as $key => $t) {
			$totalIn += $t->get('income');
			$totalOut += $t->get('outgoing');
		}

		$this->view->transactions = $transactions;
		$this->view->totalIn = $totalIn;
		$this->view->totalOut = $totalOut;
		$this->view->total = $totalIn - $totalOut;

		$this->view->date = $dateString;
		$this->view->previous = $previousDate;
		$this->view->next = $nextDate;

		$this->view->currency = Config::get('user', 'currency');

		// Load categories
		$categories = new Collection('categories');
		$categories->load();
		$this->view->categories = array( 0 => '' );
		foreach ($categories as $cat) {
			$this->view->categories[$cat->get('id')] = $cat->get('name');
		}

		$this->render('view');
	}

	public function create() {
		
		if (isset($_POST['date'])) {

			// Try and save it
			$transaction = new Model('transactions');
			// TODO: Ensure date is valid
			$transaction->set('date', $_POST['date'])
						->set('description', $_POST['description']);

			// TODO: Ensure amount is valid
			switch ($_POST['type']) {
			case 'in':
				$transaction->set('income', $_POST['amount'])
							->set('outgoing', 0);
				break;
			case 'out':
				$transaction->set('outgoing', $_POST['amount'])
							->set('income', 0);
				break;
			default:
				// TODO: Some kind of error, as no type was selected
			}

			// third party if set
			if (isset($_POST['thirdParty'])) {
				// TODO: Ensure third party is valid
				$transaction->set('thirdparty_id', $_POST['thirdParty']);
			} else {
				$transaction->set('thirdparty_id', 0);
			}

			// category if set
			if (isset($_POST['category'])) {
				// TODO: Ensure category is valid
				$transaction->set('category_id', $_POST['category']);
			} else {
				$transaction->set('category_id', 0);
			}

			try {
				$transaction->save();
				Session::pushMessage('Successfully created new transaction.', Message::SUCCESS);
				redirect('transactions');
			} catch (Exception $e) {
				$this->view->pushMessage($e->getMessage(), Message::ERROR);
			}
		}

		$categories = new Collection('categories');
		$categories->sortBy('name')->load();

		$thirdParties = new Collection('thirdparties');
		$thirdParties->sortBy('name')->load();

		$this->view->categories = $categories;
		$this->view->thirdParties = $thirdParties;

		$this->render('create');
	}
}