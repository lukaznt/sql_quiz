<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../model/Query.php';

  





  
  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  // Instantiate DB & connect
  $database_query = new Database();
  $db_query = $database_query->connect_db($data->db_name);
  // Instantiate question object
  $query = new Query($db_query);

  $query->db_name = $data->db_name;
  $query->correct_answer = $data->correct_answer;

  
  
  // Instantiate target DB & connect 
  $result = $query->test_query($data->correct_answer);

  //Get row count
  $num = $result->rowCount();

  print_r($num);

  // Cheack if there are any questions
  if($num > 0) {
    //Question array
    $answer_arr = array();
    $answer_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      
      array_push($answer_arr['data'], $row);

    }
    // Parse to JSON and output

    echo json_encode($answer_arr);
  } else {
    echo json_encode("");
  }

  

  

