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
}