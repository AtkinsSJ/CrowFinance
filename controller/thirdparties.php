<?php
class ThirdParties extends Controller {
	public function __construct() {
		parent::__construct('thirdparties', true);
	}

	public function index() {

		$thirdParties = new Collection('thirdparties');
		$thirdParties->sortBy('name', 'ASC')
					->load();

		$since = new DateTime();
		$since->modify('-1 year');
		$since = $since->format('Y-m-d');

		// Load statistics for last year for each third party
		foreach ($thirdParties as $tp) {
			$transactionCount = new Collection('transactions');
			$transactionCount->filter('thirdparty_id = :thirdPartyId',
				array('thirdPartyId' => $tp->get('id'))
			)->filter('date > :since',
				array('since' => $since)
			);

			$totals = $transactionCount->customSelect(
				'SUM(income) AS "income",
				SUM(outgoing) AS "outgoing",
				COUNT(id) AS "count"'
			);
			$tp->set('income', number_format($totals[0]['income'], 2));
			$tp->set('outgoing', number_format($totals[0]['outgoing'], 2));
			$tp->set('count', $totals[0]['count']);
		}

		$this->view->thirdParties = $thirdParties;
		$this->view->currency = Config::get('user', 'currency');
		$this->render('index');
	}

	public function create() {

		$thirdParty = new Model('thirdparties');

		if (isset($_POST['name'])) {
			$thirdParty->set('name', $_POST['name']);
			$thirdParty->set('description', $_POST['description']);

			try {
				$thirdParty->save();
				Session::pushMessage("Successfully created new Third Party, '{$thirdParty->get('name')}'", Message::SUCCESS);
				redirect('thirdparties');
			} catch (DatabaseException $e) {
				$this->view->pushMessage('Could not create new Third Party.', Message::ERROR);
			}
		}

		$this->view->thirdParty = $thirdParty;
		$this->render('create');
	}

	public function edit($id) {

		$thirdParty = new Model('thirdparties');
		try {
			$thirdParty->load($id);
		} catch (DatabaseException $e) {
			Session::pushMessage('The third party you requested does not exist.', Message::ERROR);
			redirect('thirdparties');
			return;
		}

		if (isset($_POST['name'])) {
			$thirdParty->set('name', $_POST['name']);
			$thirdParty->set('description', $_POST['description']);

			try {
				$thirdParty->save();
				Session::pushMessage("Successfully saved the Third Party, '{$thirdParty->get('name')}'", Message::SUCCESS);
				redirect('thirdparties');
			} catch (DatabaseException $e) {
				$this->view->pushMessage('Could not save the Third Party.', Message::ERROR);
			}
		}

		$this->view->thirdParty = $thirdParty;
		$this->render('edit');
	}

	public function delete($id) {

		$thirdParty = new Model('thirdparties');

		try {
			$thirdParty->load($id);
		} catch (DatabaseException $e) {
			Session::pushMessage('The third party you tried to delete does not exist.', Message::ERROR);
			redirect('thirdparties');
		}

		if (isset($_POST['sure'])) {
			try {
				$transactions = new Collection('transactions');
				$transactions->filter('thirdparty_id = :tp', array('tp' => $id));
				$transactions->update(array('thirdparty_id' => 0));

				$thirdParty->delete();
				Session::pushMessage("Sucessfully deleted the third party '{$thirdParty->get('name')}'", Message::SUCCESS);
				redirect('thirdparties');
			} catch (Exception $e) {
				$this->view->pushMessage('Failed to delete the third party.', Message::ERROR);
			}
		}

		$this->view->thirdParty = $thirdParty;
		$this->render('delete');
	}
}