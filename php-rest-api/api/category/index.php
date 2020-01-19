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
  include_once '../../models/Category.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $category = new Category($db);
  // Check Request Method
  $method = $_SERVER['REQUEST_METHOD'];
  switch ($method) {
      case 'GET':
          //Here Handle GET Request Single Row
          if (isset($_GET['id']) && isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  // Get ID
                  if ($category->id = isset($_GET['id']) ? $_GET['id'] : die()){
                      // Get post
                      $category->read_single();
                      // Create array
                      $category_arr = array(
                          'id' => (int)$category->id,
                          'name' => $category->name,
                          'description' => $category->description,
                          'created_at' => $category->created_at
                      );
                      // Make JSON
                      print_r(json_encode($category_arr));
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
                  $count = $category->read();
                  $total_record = $count->rowCount();
                  $start=($limit*$page)-$limit;
                  // $result = $category->read_pagination();
                  $result = $category->read_pagination($start,$limit);
                  $num = $result->rowCount();
                  if ($num>0){
                      $cat_arr = array();
                      $cat_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                          $cat_item = array(
                              'id' => (int)$id,
                              'name' => $name,
                              'description' => $description,
                              'created_at' => $created_at
                          );
                          array_push($cat_arr['data'], $cat_item);
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($total_record/$limit);
                      $cat_arr['pagination'] = array('page' => $page,'totalRecord' => $total_record,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($cat_arr);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }
          }
          //Here Handle GET Request All Row
          else if(isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $result = $category->read();
                  // Get row count
                  $num = $result->rowCount();
                  // Check if any categories
                  if($num > 0) {
                      // Cat array
                      $cat_arr = array();
                      $cat_arr=array('code'=> '0000','message'=> 'You Have Been Find All Categories Successfully.');
                      $cat_arr['data'] = array();
                      $l=0;
                      $limit=7;//limit 7 perpage
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $l=$l+1;
                          if ($l<=$limit){
                              extract($row);
                              $cat_item = array(
                                  'id' => (int)$id,
                                  'name' => $name,
                                  'description' => $description,
                                  'created_at' => $created_at
                              );
                              // Push to "data"
                              array_push($cat_arr['data'], $cat_item);
                          }
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($num/$limit);
                      $cat_arr['pagination'] = array('page' => 1,'totalRecord' => $num,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($cat_arr);
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
                  $category->name = $data->name;
                  $category->description = $data->description;
                  // Create Category
                  if($category->create()) {
                      $cat_arr = array();
                      $cat_arr=array('code' => '0000', 'message' => 'Category Created');
                      $cat_arr['data'] = array($category);
                      echo json_encode(array($cat_arr));
                  }else{
                      echo json_encode(array('code' => '400', 'message' => 'Category Not Created'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
      case 'DELETE':
          if (isset($_GET['id']) && isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  //Here Handle DELETE Request
                  // $data = json_decode(file_get_contents("php://input"));
                  // Set ID to DELETE
                  // $category->id = $data->id;
                  if ($category->id = isset($_GET['id']) ? $_GET['id'] : die()){
                      // Delete post
                      if($category->delete()) {
                          echo json_encode(array('code' => '0000', 'message' => 'Category deleted'));
                      }else{
                          echo json_encode(array('code' => '404', 'message' => 'Category not deleted'));
                      }
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
          if (isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  //Here Handle PUT Request/Update Request
                  $data = json_decode(file_get_contents("php://input"));
                  // Set ID to UPDATE
                  $category->id = $data->id;
                  $category->name = $data->name;
                  $category->description = $data->description;
                  // Update post
                  if($category->update()) {
                      echo json_encode(array('message' => 'Category Updated'));
                  }else{
                      echo json_encode(array('message' => 'Category not updated'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
  }
