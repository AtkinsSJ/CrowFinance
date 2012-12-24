<?php

class Categories extends Controller {
	
	public function __construct() {
		parent::__construct('categories', true);
	}

	public function index() {
		$categories = new Collection('categories');
		$categories->sortBy('name', 'DESC')->load();

		$since = new DateTime();
		$since->modify('-1 year');
		$since = $since->format('Y-m-d');

		foreach ($categories as $cat) {
			$transactionCount = new Collection('transactions');
			$transactionCount->filter('category_id = :categoryId',
				array('categoryId' => $cat->get('id'))
			)->filter('date > :since',
				array('since' => $since)
			);

			$totals = $transactionCount->customSelect(
				'SUM(income) AS "income",
				SUM(outgoing) AS "outgoing",
				COUNT(id) AS "count"'
			);
			$cat->set('income', number_format($totals[0]['income'], 2));
			$cat->set('outgoing', number_format($totals[0]['outgoing'], 2));
			$cat->set('count', $totals[0]['count']);
		}

		$this->view->categories = $categories;
		$this->view->currency = Config::get('user', 'currency');

		$this->render('index');
	}

	public function edit($id) {
		$category = new Model('categories');
		try {
			$category->load($id);
		} catch (Exception $ex) {
			Session::pushMessage('That category does not exist.', Message::ERROR);
			redirect('categories');
			return;
		}
		
		// Update the model
		if (isset($_POST['name'])) {
			$category->set('name', $_POST['name']);
			try {
				$category->save();
				Session::pushMessage( "Category '{$_POST['name']}' was saved successfully.", Message::SUCCESS );
				redirect('categories');
			} catch (DatabaseException $e) {
				$this->view->pushMessage('Could not save the category: <pre>' . print_r($e, true) . '</pre>', Message::ERROR);
			}
		}

		$this->view->category = $category;
		$this->view->render('edit');
	}

	public function delete($id) {

		$category = new Model('categories');
		try {
			$category->load($id);
		} catch (Exception $ex) {
			Session::pushMessage('That category does not exist.', Message::ERROR);
			redirect('categories');
			return;
		}

		if (isset($_POST['sure'])) {
			try {
				$name = $category->get('name');
				$category->delete();
				Session::pushMessage("Category '{$name}' was deleted successfully.", Message::SUCCESS);
				redirect('categories');
			} catch (Exception $e) {
				$this->view->pushMessage('Could not delete category: ' . $e->getMessage(), Message::ERROR);
			}
		}

		$this->view->category = $category;
		$this->view->render('delete');
	}
}