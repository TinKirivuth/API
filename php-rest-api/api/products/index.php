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
  include_once '../../models/Product.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $product = new Product($db);
  // Check Request Method
  $method = $_SERVER['REQUEST_METHOD'];
  switch ($method) {
      case 'GET':
          //Here Handle GET Request Single Row
          if (isset($_GET['id']) && isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  //Method1
                    // // Get ID
                    // if ($product->id = isset($_GET['id']) ? $_GET['id'] : die()){
                    //     // Get post
                    //     $product->read_single();
                    //     // Post array
                    //     $products_arr = array();
                    //     $products_arr=array('code'=> '0000','message'=> 'You Have Been Find All Product Successfully.');
                    //     $products_arr['data'] = array();
                    //     // Create array
                    //     $product_item = array(
                    //         'id' => $product->id,
                    //         'name' => $product->name,
                    //         'title' => $product->title,
                    //         'description' => $product->description,
                    //         'icon' => $product->icon,
                    //         'category' => array('category_id' => $product->category_id, 'category_name' => $product->category_name),
                    //         // 'category_id' => $product->category_id,
                    //         // 'category_name' => $product->category_name,
                    //         'created_at' => $product->created_at,
                    //         'is_public' => $product->is_public
                    //     );
                    //     array_push($products_arr['data'], $product_item);
                    //     // Make JSON
                    //     echo json_encode($products_arr);
                    //
                    // }else{
                    //     echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                    // }

                  //Method2
                  $id=(int)$_GET['id'];
                  $result = $product->read_single($id);
                  $num = $result->rowCount();
                  if ($num>0){
                      $products_arr = array();
                      $products_arr=array('code'=> '0000','message'=> 'You Have Been Find Products Successfully.');
                      $products_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                          $product_item = array(
                              'id' => $id,
                              'name' => $name,
                              'title' => $title,
                            //   'description' => html_entity_decode($description),
                              'description' => htmlspecialchars(strip_tags($description)),
                              'icon' => $icon,
                              'category' => array('category_id' => $category_id, 'category_name' => $category_name),
                              'created_at' => $created_at,
                              'is_public' => $is_public
                          );
                          array_push($products_arr['data'], $product_item);
                      }
                      // Turn to JSON & output
                      echo json_encode($products_arr);
                  }

                  else{
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
                  $count = $product->read();
                  $total_record = $count->rowCount();
                  $start=($limit*$page)-$limit;
                  // $result = $category->read_pagination();
                  $result = $product->read_pagination($start,$limit);
                  $num = $result->rowCount();
                  if ($num>0){
                      $products_arr = array();
                      $products_arr=array('code'=> '0000','message'=> 'You Have Been Find All Products Successfully.');
                      $products_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                          $product_item = array(
                              'id' => $id,
                              'name' => $name,
                              'title' => $title,
                            //   'description' => html_entity_decode($description),
                              'description' => htmlspecialchars(strip_tags($description)),
                              'icon' => $icon,
                              'category' => array('category_id' => $category_id, 'category_name' => $category_name),
                              'created_at' => $created_at,
                              'is_public' => $is_public
                          );
                          array_push($products_arr['data'], $product_item);
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($total_record/$limit);
                      $products_arr['pagination'] = array('page' => $page,'totalRecord' => $total_record,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($products_arr);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }
          }
          //Here Handle GET Request All Row
          else if(isset($_GET['apiKey'])){
              $apiKey=$_GET['apiKey'];
              if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                  // Blog post query
                  $result = $product->read();
                  // Get row count
                  $num = $result->rowCount();
                  // Check if any categories
                  if($num > 0) {
                      // Post array
                      $products_arr = array();
                      $products_arr=array('code'=> '0000','message'=> 'You Have Been Find All Products Successfully.');
                      $products_arr['data'] = array();
                      $l=0;
                      $limit=7;//limit 7 perpage
                      // $products_arr['data'] = array();
                      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $l=$l+1;
                          if ($l<=$limit){
                                extract($row);
                                $product_item = array(
                                    'id' => $id,
                                    'name' => $name,
                                    'title' => $title,
                                    // 'description' => html_entity_decode($description),
                                    'description' => htmlspecialchars(strip_tags($description)),
                                    // 'description' => base64_encode($description),
                                    'icon' => $icon,
                                    'category' => array('category_id' => $category_id, 'category_name' => $category_name),
                                    'created_at' => $created_at,
                                    'is_public' => $is_public
                                );
                                // Push to "data"
                                array_push($products_arr['data'], $product_item);
                          }
                      }
                      // Turn to JSON & output
                      $numberOfPages = ceil($num/$limit);
                      $products_arr['pagination'] = array('page' => 1,'totalRecord' => $num,'totalPage' => $numberOfPages,'limit' => $limit);
                      echo json_encode($products_arr);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'No Record To Fetch.'));
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
                  $product->name = $data->name;
                  $product->title = $data->title;
                  $product->description = $data->description;
                  $product->icon = $data->icon;
                  $product->category_id = $data->category_id;
                  $product->is_public = $data->is_public;
                  // Create Category
                  if($product->create()) {
                      $product->id = $db->lastInsertId(); //get last insert id
                      $date = date('Y-m-d H:i:s');
                      $product->created_at = $date;
                      $products_arr = array();
                      $products_arr=array('code' => '0000', 'message' => 'Product Created');
                      $products_arr['data'] = array($product);
                      echo json_encode(array($products_arr));
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Product Not Created'));
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
                  // Get ID
                  if ($product->id = isset($_GET['id']) ? $_GET['id'] : die()){
                      $id=(int)$_GET['id'];
                      // Get product
                      getCurrentID($product,$id);
                      $product->delete(); //Delete data from server
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                  }
              }else{
                  echo json_encode(array('code' => '404', 'message' => 'Bad Request.'));
              }
          }else{
              echo json_encode(array('code' => '404', 'message' => 'Not Found.'));
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
                  $product->id = $id;
                  $product->name = $data->name;
                  $product->title = $data->title;
                  $product->description = $data->description;
                  $product->icon = $data->icon;
                  $product->category_id = $data->category_id;
                  $product->is_public = $data->is_public;
                  // Update post
                  if($product->update()) {
                      getCurrentID($product,$id);
                  }else{
                      echo json_encode(array('code' => '404', 'message' => 'Product not updated'));
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
  function getCurrentID($product,$id){
      $result = $product->read_single($id);
      $num = $result->rowCount();
      if ($num>0){
          $products_arr = array();
          $products_arr=array('code'=> '0000','message'=> 'Product Was Deleted.');
          $products_arr['data'] = array();
          while($row = $result->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $product_item = array(
                  'id' => $id,
                  'name' => $name,
                  'title' => $title,
                  'description' => html_entity_decode($description),
                  'icon' => $icon,
                  'category' => array('category_id' => $category_id, 'category_name' => $category_name),
                  'created_at' => $created_at,
                  'is_public' => $is_public
              );
              array_push($products_arr['data'], $product_item);
          }
          // Turn to JSON & output
          echo json_encode($products_arr);
      }else{
          echo json_encode(array('code' => '404', 'message' => 'Not Found'));
      }
  }
