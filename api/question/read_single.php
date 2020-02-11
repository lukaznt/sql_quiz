<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../model/Question.php';

  // Instatiate DB and Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Question object
  $question = new Question($db);

  // Get ID
  $question->question_id = isset($_GET['question_id']) ? $_GET['question_id'] : die();

  // Get question
  $question->read_single();

  // Create array
  $question_arr = array(
    'db_name' => $question->db_name,
    'question_text' => $question->question_text,
    'correct_answer' => $question->correct_answer,
    'correct_result' => $question->correct_result,
    'is_public' => $question->is_public,
    'theme_id' => $question->theme_id,
    'author_id' => $question->author_id,
    'created_at' => $question->created_at
  );

  // Parse to JSON
  print_r(json_encode($question_arr));