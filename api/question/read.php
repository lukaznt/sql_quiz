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

  // Question query
  $result = $question->read();

  //Get row count
  $num = $result->rowCount();

  // Cheack if there are any questions
  if($num > 0) {
    //Question array
    $question_arr = array();
    $question_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      $question_item = array(
        'question_id' => $question_id,
        'db_name' => $db_name,
        'question_text' => $question_text,
        'correct_answer' => $correct_answer,
        'correct_result' => $correct_result,
        'is_public' => $is_public,
        'theme_id' => $theme_id,
        'author_id' => $author_id,
        'created_at' => $created_at
      );

      //push to "data"
      array_push($question_arr['data'], $question_item);

    }
    // Parse to JSON and output
    echo json_encode($question_arr);
  } else {
    echo json_encode(
      array('message' => 'No questions found.')
    );
  }