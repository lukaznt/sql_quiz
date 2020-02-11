<?php
	class Question {
		// Dabatase
		private $conn;
		private $table = 'sql_question';

		// Question properties
		public $question_id;
		public $db_name;
		public $question_text;
		public $correct_answer;
		public $correct_result;
		public $is_public;
		public $theme_id;
		public $author_id;
		public $created_at;

		// Constructor with Database
		public function __construct($db) {
			$this->conn = $db;
		}

		// Get questions
		public function read() {
			// Create query
			$query = 'SELECT
						q.question_id,
						q.db_name,
						q.question_text,
						q.correct_answer,
						q.correct_result,
						q.is_public,
						q.theme_id,
						q.author_id,
						q.created_at
						FROM
						' . $this->table . ' q';

			// Prepare Statement
			$stmt = $this->conn->prepare($query);

			// Execute query
			$stmt->execute();

			return $stmt;
		}

		// Get single question
		public function read_single(){

			// Create query
			$query = 'SELECT
						q.question_id,
						q.db_name,
						q.question_text,
						q.correct_answer,
						q.correct_result,
						q.is_public,
						q.theme_id,
						q.author_id,
						q.created_at
						FROM
						' . $this->table . ' q
						WHERE
						q.question_id = ?
						LIMIT 0,1';
			
			// Prepare Statement
			$stmt = $this->conn->prepare($query);

			// Bind ID
			$stmt->bindParam(1, $this->question_id);

			// Execute query
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// Set properties

			$this->db_name = $row['db_name'];
			$this->question_text = $row['question_text'];
			$this->correct_answer = $row['correct_answer'];
			$this->correct_result = $row['correct_result'];
			$this->is_public = $row['is_public'];
			$this->theme_id = $row['theme_id'];
			$this->author_id = $row['author_id'];
			$this->created_at = $row['created_at'];
		}

		// Create Question
		public function create() {

			// Create query
			$query = 'INSERT INTO ' . $this->table . ' SET db_name = :db_name, question_text = :question_text, correct_answer = :correct_answer, correct_result = :correct_result, is_public = :is_public, theme_id = :theme_id, author_id = :author_id, created_at = :created_at';
  
			// Prepare statement
			$stmt = $this->conn->prepare($query);
  
			// Bind data
			$stmt->bindParam(':db_name', $this->db_name);
			$stmt->bindParam(':question_text', $this->question_text);
			$stmt->bindParam(':correct_answer', $this->correct_answer);
			$stmt->bindParam(':correct_result', $this->correct_result);
			$stmt->bindParam(':is_public', $this->is_public);
			$stmt->bindParam(':theme_id', $this->theme_id);
			$stmt->bindParam(':author_id', $this->author_id);
			$stmt->bindParam(':created_at', $this->created_at);
  
			// Execute query
			if($stmt->execute()) {
			  return true;
		}
  
		// Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
  
		return false;
	  }
	}

