<?php

class Model {

	private $_id;
	private $_fields;
	private $_table;

	private static $db = null;
	private static $userId;

	/**
	 * Empty constructor. Just initialises base state.
	 */
	public function __construct($table) {
		$this->_table = $table;

		$this->_id = null;
		$this->_fields = array();

		if (Model::$db == null) {
			Model::$db = new Database();
		}
	}

	/**
	 * Create a Model with id and fields assigned.
	 * 
	 * This is used by Collection when loading multiple models, for
	 * convenience, rather than multiple set() calls.
	 */
	public static function createPopulated($table, $id, $fields) {
		Model $model = new Model($table);
		$model->_id = $id;
		$model->_fields = $fields;
		return $model;
	}

	/**
	 * Set the user ID for all Model instances.
	 */
	public static function setUserId($userId) {
		Model::$userId = $userId;
	}
	
	/**
	 * Load data into the model, from the database, using the given $id.
	 *
	 * Chainable
	 */
	public function load($id) {
		$stmt = Model::$db->prepare(
			"SELECT *
			FROM {$db->tablePrefix}{$this->_table}
			WHERE id = :id
				AND user_id = :userId"
		);

		if ( $stmt->execute( array('id' => $id,
									'userId' => Model::$userId) ) ) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->_id = $id;
			$this->setMultiple($result);
		} else {
			throw new Exception( 'Could not load database data for a record: ' .$stmt->errorInfo());
		}

		return $this; // Chaining
	}

	/**
	 * Set the value of the given field.
	 * Chainable.
	 */
	public function set($field, $value) {

		if ($field == 'id') { return $this; } // Don't store id as a field.

		$this->_fields[$field] = $value;

		return $this; // Chaining
	}

	/**
	 * Set the values of multiple fields.
	 * $fields is an array of fieldName => value.
	 * Chainable.
	 */
	public function setMultiple(Array $fields) {
		foreach ($fields as $field => $value) {
			$this->set($field, $value);
		}

		return $this; // Chaining
	}

	/**
	 * Returns the value of a given field
	 */
	public function get($field) {
		return $this->_fields[$field];
	}
}