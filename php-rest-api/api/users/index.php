<?php
  // Headers
  //   header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Max-Age: 3600");
  // -----Create/Post/Delete/Update--------
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  // ----Connection and Model--------------
  include_once '../../config/Database.php';
  include_once '../../models/User.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $user = new User($db);
  // Check Request Method
  $method = $_SERVER['REQUEST_METHOD'];
  switch ($method) {
      case 'GET':
          if(isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $result = $user->read();
                  // Get row count
                  $num = $result->rowCount();
                  // Check if any categories
                  if($num > 0) {
                      // Cat array
                      $user_arr = array();
                      $user_arr=array('code'=> '0000','message'=> 'You Have Been Find All User Successfully.');
                      $user_arr['data'] = array();
                      $l=0;
                      $limit=7;//limit 7 perpage
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $l=$l+1;
                          if ($l<=$limit){
                              extract($row);
                              $user_item = array(
                                  'id' => (int)$id,
                                  'name' => $name,
                                  'password' => $password,
                                  'type' => (int)$type,
                                  'status' => (int)$status
                              );
                              // Push to "data"
                              array_push($user_arr['data'], $user_item);
                          }
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($num/$limit);
                      $user_arr['pagination'] = array('page' => 1,'totalRecord' => $num,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($user_arr);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }
          }
          else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
      case 'POST':
          //Here Handle POST Request/Create New Record
          if (isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $data = json_decode(file_get_contents("php://input"));
                  $user->name = $data->name;
                  $user->password = $data->password;
                  $user->type = $data->type;
                  $user->status = $data->status;
                  // Create Category
                  if(
                      !empty($user->name) &&
                      !empty($user->password) &&
                      !empty($user->type) &&
                      !empty($user->status) &&
                      $user->create()
                  ){
                      // set response code
                      http_response_code(200);
                      $user_arr = array();
                      $user_arr=array('code' => '0000', 'message' => 'User Created');
                      $user_arr['data'] = array($user);
                      echo json_encode(array($user_arr));
                  }else{
                      // set response code
                      http_response_code(400);
                      echo json_encode(array('code' => '400', 'message' => 'User Not Created'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
      case 'DELETE':

          break;
      case 'PUT':

          break;
  }
?>
