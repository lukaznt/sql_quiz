<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../model/Question.php';
  include_once '../../model/Query.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  

  // Instantiate question object
  $question = new Question($db);


  
  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $question->db_name = $data->db_name;
  $question->question_text = $data->question_text;
  $question->correct_answer = $data->correct_answer;
  
  $question->is_public = $data->is_public;
  $question->theme_id = $data->theme_id;
  $question->author_id = $data->author_id;
  $question->created_at = $data->created_at;
 
  // Instantiate DB & connect
  $database_query = new Database();
  $db_query = $database_query->connect_db($data->db_name);


  // Instantiate query object
  $query = new Query($db_query);

  $query->db_name = $data->db_name;
  $query->correct_answer = $data->correct_answer;


  // Instantiate target DB & connect 
  $result_query = $query->test_query($data->correct_answer);

  //Get row count
  $num = $result_query->rowCount();

  // Check if there are any results
  if($num > 0) {
    //Result array
    $result_arr = array();
    $result_arr['data'] = array();

    while($row = $result_query->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      
      array_push($result_arr['data'], $row);

    }
    // Parse to JSON and output
    $question->correct_result = json_encode($result_arr);
  } else {
    $question->correct_result = json_encode("");
    
  }


  // Create question
  if($question->create()) {

    echo 'Question Created';
    
  } else {
    echo 'Question Not Created';
    
  }
