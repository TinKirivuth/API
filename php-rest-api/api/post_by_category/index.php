<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    // -----Create/Post/Delete/Update--------
    // header('Access-Control-Allow-Methods: POST');
    // header('Access-Control-Allow-Methods: DELETE');
    // header('Access-Control-Allow-Methods: PUT');
    // header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

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
        if (isset($_GET['category_id']) && isset($_GET['apiKey']) && isset($_GET['page']) && isset($_GET['limit'])){
            $apiKey=$_GET['apiKey'];
            if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                $category_id=$_GET['category_id'];
                $page=(int)$_GET['page'];
                $limit=(int)$_GET['limit'];
                //Read all by categoryid first
                $count = $post->read_by_category($category_id);
                $total_record = $count->rowCount();
                $start=($limit*$page)-$limit;
                // Read all by categoryid with pagination
                $result = $post->read_by_category_pagination($category_id,$start,$limit);
                $num = $result->rowCount();
                if ($num>0){
                    $posts_arr = array();
                    $posts_arr=array('code'=> '0000','message'=> 'You Have Been Find All Post By Category Successfully.');
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
                }
                else{
                    echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                }
            }
        }
        else if (isset($_GET['category_id']) && isset($_GET['apiKey'])){
            $apiKey=$_GET['apiKey'];
            if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
                $category_id=$_GET['category_id'];
                $result = $post->read_by_category($category_id);
                $num = $result->rowCount();
                if ($num>0){
                    $posts_arr = array();
                    $posts_arr=array('code'=> '0000', 'message'=> 'You Have Been Find All Post By Category Successfully.');
                    $posts_arr['data'] = array();
                    $l=0;
                    $limit=7;//limit 7 perpage
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
                            array_push($posts_arr['data'], $post_item);
                        }
                    }
                     // Turn to JSON & output
                     $numberOfPages = ceil($num/$limit);
                     $posts_arr['pagination'] = array('page' => 1,'totalRecord' => $num,'totalPage' => $numberOfPages,'limit' => $limit);
                     echo json_encode($posts_arr);
                }
                else{
                    echo json_encode(array('code' => '404', 'message' => 'Not Found'));
                }
            }
        }
        break;
    }
