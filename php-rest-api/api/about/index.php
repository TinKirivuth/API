<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  // -----Create/Post/Delete/Update--------
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');
  // ----Connection and Model--------------
  include_once '../../config/Database.php';
  include_once '../../models/About.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $about = new About($db);
  // Check Request Method
  $method = $_SERVER['REQUEST_METHOD'];
  switch ($method) {
      case 'GET':
          //Here Handle GET Request Single Row
          if (isset($_GET['id']) && isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  // Get ID
                  if ($about->id = isset($_GET['id']) ? $_GET['id'] : die()){
                      // Get post
                      $result=$about->read_single();
                      if($result){
                          $about_arr = array();
                          $about_arr=array('code'=> '0000','message'=> 'You Have Been Find About Successfully.');
                          $about_arr['data'] = array();
                          $about_item = array(
                              'id' => $about->id,
                              'name' => $about->name,
                              'description' => $about->description,
                              'created_at' => $about->created_at
                          );
                          array_push($about_arr['data'], $about_item);
                      }else{
                        $about_arr=array('code'=> '404','message'=> 'Note Found');
                      }
                      print_r(json_encode($about_arr));
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }
          //Here Handle Get Request With Pagination
          else if (isset($_GET['page']) && isset($_GET['limit']) && isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $page=(int)$_GET['page'];
                  $limit=(int)$_GET['limit'];
                  //count record number
                  $count = $about->read();
                  $total_record = $count->rowCount();
                  $start=($limit*$page)-$limit;
                  // $result = $about->read_pagination();
                  $result = $about->read_pagination($start,$limit);
                  $num = $result->rowCount();
                  if ($num>0){
                      $about_arr = array();
                      $about_arr=array('code'=> '0000','message'=> 'You Have Been Find All Abouts Successfully.');
                      $about_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                          $about_item = array(
                              'id' => $id,
                              'name' => $name,
                              'description' => $description,
                              'created_at' => $created_at
                          );
                          array_push($about_arr['data'], $about_item);
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($total_record/$limit);
                      $about_arr['pagination'] = array('page' => $page,'totalRecord' => $total_record,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($about_arr);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }
          }
          //Here Handle GET Request All Row
          else if(isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $result = $about->read();
                  // Get row count
                  $num = $result->rowCount();
                  // Check if any categories
                  if($num > 0) {
                      // Cat array
                      $about_arr = array();
                      $about_arr=array('code'=> '0000','message'=> 'You Have Been Find All Abouts Successfully.');
                      $about_arr['data'] = array();
                      $l=0;
                      $limit=7;//limit 7 perpage
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $l=$l+1;
                          if ($l<=$limit){
                              extract($row);
                              $about_item = array(
                                  'id' => $id,
                                  'name' => $name,
                                  'description' => $description,
                                  'created_at' => $created_at
                              );
                              // Push to "data"
                              array_push($about_arr['data'], $about_item);
                          }
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($num/$limit);
                      $about_arr['pagination'] = array('page' => 1,'totalRecord' => $num,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($about_arr);
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
                  $about->name = $data->name;
                  $about->description = $data->description;
                  // Create Category
                  if($about->create()) {
                      $about->id = $db->lastInsertId(); //get last insert id
                      $date = date('Y-m-d H:i:s'); // get current date
                      $about->created_at = $date;
                      $about_arr = array();
                      $about_arr=array('code' => '0000', 'message' => 'About Created');
                      $about_arr['data'] = array($about);
                      echo json_encode(array($about_arr));
                  }else{
                      echo json_encode(array('code' => '400', 'message' => 'About Not Created'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
      case 'DELETE':
          if (isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  //Here Handle DELETE Request
                  // $data = json_decode(file_get_contents("php://input"));
                  // Set ID to DELETE
                  if ($about->id = isset($_GET['id']) ? $_GET['id'] : die()){
                      $id=(int)$_GET['id'];
                      // Get About
                      getCurrentID($about,$id);
                      $about->delete();//Delete data from server
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }

              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
      case 'PUT':
          if (isset($_GET['id']) && isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $id=(int)$_GET['id'];
                  //Here Handle PUT Request/Update Request
                  $data = json_decode(file_get_contents("php://input"));
                  // Set ID to update
                  $about->id = $id;
                  $about->name = $data->name;
                  $about->description = $data->description;
                  $about->created_at= date('Y-m-d H:i:s'); // get current date
                  $about->status = $data->status;
                  // Update post
                  if($about->update()) {
                      $about_arr = array();
                      $about_arr=array('code' => '0000', 'message' => 'About Was Updated');
                      $about_arr['data'] = array($about);
                      echo json_encode(array($about_arr));
                      // getCurrentID($about,$id);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'About not updated'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;

  }

  // Get current data after DELETE And UPDATE
  function getCurrentID($about,$id){
      $result = $about->read_single($id);
      $num = $result->rowCount();
      if ($num>0){
          $about_arr = array();
          $about_arr=array('code'=> '0000','message'=> 'About Was Deleted.');
          $about_arr['data'] = array();
          while($row = $result->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $about_item = array(
                  'id' => $id,
                  'name' => $name,
                  'description' => html_entity_decode($description),
                  'created_at' => $created_at,
                  'status' => $status
              );
              array_push($about_arr['data'], $about_item);
          }
          // Turn to JSON & output
          echo json_encode($about_arr);
      }else{
          echo json_encode(array('code' => '404', 'message' => 'Not Found'));
      }
  }
?>
