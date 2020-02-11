<?php
	class Query {
		// Dabatase
		private $conn;
		private $table;

		// query properties
		public $db_name;
		public $correct_result;

		// Constructor with Database
		public function __construct($db) {
			$this->conn = $db;
		}

		// Get result
		public function get_result() {
			// Create query
			$query =  $this->correct_answer;

			// Prepare Statement
			$stmt = $this->conn->prepare($query);

			// Execute query
			$stmt->execute();

			return $stmt;
		}



	  // Test a query and get answer
		public function test_query($query){

			// Create query
			$test_query = $query;
			
			// Prepare Statement
			$stmt = $this->conn->prepare($test_query);

			// Execute query
			$stmt->execute();

			return $stmt;
		}

	}