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

		Model::getDatabase(); // Init db;
	}

	public static function getDatabase() {
		if (Model::$db == null) {
			Model::$db = new Database();
		}
		return Model::$db;
	}

	/**
	 * Create a Model with id and fields assigned.
	 * 
	 * This is used by Collection when loading multiple models, for
	 * convenience, rather than multiple set() calls.
	 */
	public static function createPopulated($table, $id, $fields) {
		$model = new Model($table);
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

	public static function getUserId() {
		return Model::$userId;
	}
	
	/**
	 * Load data into the model, from the database, using the given $id.
	 *
	 * Chainable
	 */
	public function load($id) {
		$db = Model::$db;
		$stmt = $db->prepare(
			"SELECT *
			FROM {$db->tablePrefix}{$this->_table}
			WHERE id = :id
				AND user_id = :userId"
		);

		if ( $stmt->execute( array('id' => $id,
									'userId' => Model::$userId) ) ) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$result) {
				throw new DatabaseException('Record does not exist', $query, $stmt->errorInfo());
			}
			$this->_id = $id;
			$this->setMultiple($result);
		} else {
			throw new DatabaseException('Could not load a record', $query, $stmt->errorInfo());
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
		if ($field == 'id') { return $this->_id; }
		return $this->_fields[$field];
	}

	/**
	 * Save the state of the model to the database
	 */
	public function save() {
		$db = Model::$db;
		$query = "UPDATE {$db->tablePrefix}{$this->_table}
			SET ";

		$parts = array();
		foreach ($this->_fields as $field => $value) {
			$parts[] = "{$field} = :{$field}";
		}
		$query .= implode(', ', $parts);

		$query .= " WHERE id = :id
			LIMIT 1";

		$params = $this->_fields;
		$params['id'] = $this->_id;

		$stmt = $db->prepare($query);
		if ( $stmt->execute( $params ) ) {
			return;
		} else {
			throw new DatabaseException('Failed to save record.', $query, $stmt->errorInfo());
		}
	}
}