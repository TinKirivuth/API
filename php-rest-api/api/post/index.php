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
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $post = new Post($db);
  // Check Request Method
  $method = $_SERVER['REQUEST_METHOD'];
  switch ($method) {
      case 'GET':
          if (isset($_GET['id']) && isset($_GET['apiKey'])){//Here Handle GET Request Single Row
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  // Get ID
                  if ($post->id = isset($_GET['id']) ? $_GET['id'] : die()){
                      // Get post
                      $post->read_single();
                      // Create array
                      $post_arr = array(
                          'id' => $post->id,
                          'title' => $post->title,
                          'body' => $post->body,
                          'author' => $post->author,
                          'category_id' => $post->category_id,
                          'category_name' => $post->category_name
                      );

                      // Make JSON
                      print_r(json_encode($post_arr));
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }
          else if (isset($_GET['page']) && isset($_GET['limit']) && isset($_GET['apiKey'])){ //Here Handle Get Request With Pagination
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  $page=(int)$_GET['page'];
                  $limit=(int)$_GET['limit'];
                  //count record number
                  $count = $post->read();
                  $total_record = $count->rowCount();
                  $start=($limit*$page)-$limit;
                  // $result = $category->read_pagination();
                  $result = $post->read_pagination($start,$limit);
                  $num = $result->rowCount();
                  if ($num>0){
                      $posts_arr = array();
                      $posts_arr=array('code'=> '0000','message'=> 'You Have Been Find All Post Successfully.');
                      $posts_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                          $post_item = array(
                              'id' => $id,
                              'title' => $title,
                              'body' => html_entity_decode($body),
                              'author' => $author,
                              'category_id' => $category_id,
                              'category_name' => $category_name
                          );
                          array_push($posts_arr['data'], $post_item);
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($total_record/$limit);
                      $posts_arr['pagination'] = array('page' => $page,'totalRecord' => $total_record,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($posts_arr);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }
          }
          else if(isset($_GET['apiKey'])){//Here Handle GET Request All Row
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  // Blog post query
                  $result = $post->read();
                  // Get row count
                  $num = $result->rowCount();
                  // Check if any categories
                  if($num > 0) {
                      // Post array
                      $posts_arr = array();
                      $posts_arr=array('code'=> '0000','message'=> 'You Have Been Find All Post Successfully.');
                      $posts_arr['data'] = array();
                      $l=0;
                      $limit=7;//limit 7 perpage
                      // $posts_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $l=$l+1;
                          if ($l<=$limit){
                                extract($row);
                                $post_item = array(
                                    'id' => $id,
                                    'title' => $title,
                                    'body' => html_entity_decode($body),
                                    'author' => $author,
                                    'category_id' => $category_id,
                                    'category_name' => $category_name
                                );
                                // Push to "data"
                                // array_push($posts_arr, $post_item);
                                array_push($posts_arr['data'], $post_item);
                          }
                      }

                      // Turn to JSON & output
                      $numberOfPages = ceil($num/$limit);
                      $posts_arr['pagination'] = array('page' => 1,'totalRecord' => $num,'totalPage' => $numberOfPages,'limit' => $limit);

                      echo json_encode($posts_arr);
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
                  $post->title = $data->title;
                  $post->body = $data->body;
                  $post->author = $data->author;
                  $post->category_id = $data->category_id;
                  // Create Category
                  if($post->create()) {
                      echo json_encode(array('code' => '0000', 'message' => 'Post Created'));
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Post Not Created'));
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
                  $data = json_decode(file_get_contents("php://input"));
                  // Set ID to DELETE
                  // $post->id = $data->id;
                  $post->id = isset($_GET['id']) ? $_GET['id'] : die();
                  // Delete post
                  if($post->delete()) {
                      echo json_encode(array('code' => '0000', 'message' => 'Post Deleted'));
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Post Not Deleted'));
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
                  // Set ID to update
                  $post->id = $data->id;
                  $post->title = $data->title;
                  $post->body = $data->body;
                  $post->author = $data->author;
                  $post->category_id = $data->category_id;
                  // Update post
                  if($post->update()) {
                      echo json_encode(array('code' => '0000', 'message' => 'Post Updated'));
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Post not updated'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Not Found'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found'));
          }
          break;
  }
