<?php

class Collection { // implements Countable, ArrayAccess {
	
	private $_table;
	public $_models = array();

	private $_conditions = array();
	private $_parameters = array();
	private $_sortField;
	private $_sortDirection;
	private $_limit;
	private $_offset;

	public function __construct($table) {
		$this->_table = $table;
		$this->filter("user_id = :userId",
				array('userId' => Model::getUserId()));
	}

	public function filter($condition, $parameters=array()) {
		$this->_conditions[] = $condition;
		$this->_parameters = array_merge($this->_parameters, $parameters);
		
		return $this;
	}

	public function sortBy($field, $direction) {
		$this->_sortField = $field;
		$this->_sortDirection = $direction;

		return $this;
	}

	public function page($pageNumber, $perPage) {
		$this->_limit = $perPage;
		$this->_offset = $perPage * ($pageNumber-1);

		return $this;
	}

	public function load() {
		$db = Model::getDatabase();
		$query = "SELECT *
			FROM {$db->tablePrefix}{$this->_table}
			";

		// WHERE clause
		if (count($this->_conditions) > 0) {
			$conditions = implode($this->_conditions, ' AND ');
			$query .= ' WHERE ' . $conditions;
		}

		// ORDER BY clause
		if ($this->_sortField) {
			$query .= " ORDER BY {$this->_sortField} {$this->_sortDirection} ";
		}

		// LIMIT OFFSET clause
		if ($this->_limit) {
			$query .= " LIMIT {$this->_limit} OFFSET {$this->_offset} ";
		}
		
		$stmt = $db->prepare( $query );

		if ( $stmt->execute( $this->_parameters ) ) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $record) {
				$this->_models[] = Model::createPopulated($this->_table, $record['id'], $record);
			}
		} else {
			$err = print_r($stmt->errorInfo(), true);
			throw new Exception( 'Could not load database data for a records: ' . $err);
		}

		return $this; // Chaining
	}
}