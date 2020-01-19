<?php
    // // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    //
    // // ----Connection and Model--------------
    // include_once '../../../config/Database.php';
    // // include_once '../../../models/Category.php';
    // // Instantiate DB & connect
    // $database = new Database();




    

    define("SERVER","localhost");
    define("USER","root");
    define("PASSWORD","123abc+-*/");
    define("DB","kc_restful_api");

    $mysql = new mysqli(SERVER,USER,PASSWORD,DB);

    $response = array();

    if($mysql->connect_error){
        $response['code'] = 500;
        $response['message'] = 'Error With Connection.';
    }else{
        if(is_uploaded_file($_FILES["file"]["tmp_name"]) && @$_POST["user_name"]){
            $tmp_file = $_FILES["file"]["tmp_name"]; //get file from client
            $img_name = $_FILES["file"]["name"];//get file name
            $upload_dir = "../../upl-images/".$img_name;
            $sql="INSERT INTO tbl_user(user_name,user_profile) VALUES('{$_POST['user_name']}','{$img_name}')";

            if(move_uploaded_file($tmp_file,$upload_dir) && $mysql->query($sql)){
                $response["code"] = 200;
                $response["message"] = "Uploaded Success";
            }else{
                $response["code"] = 404;
                $response["message"] = "Uploaded Failed";
            }
        }else{
            $response["code"] = 400;
            $response["message"] = "Invalid Request";
        }
    }

    echo json_encode($response);




    $img_name = $_FILES['txt_file']['name'];
    $tmp_name = $_FILES['txt_file']['tmp_name'];
    $ext = pathinfo($img_name,PATHINFO_EXTENSION);
    $t = time();

    move_uploaded_file($tmp_name,'../upl-img/'.$t.'.'.$ext);
    $msg['photoName']=$t.'.'.$ext;
    echo json_encode($msg);

















































    // body.on('change','#txt_file',function(){
    //     var eThis=$(this);
    //     upload_img(eThis);
    // });





    // function upload_img(eThis){
    //     var frm = eThis.closest('form.upl');
    //     var frm_data = new FormData(frm[0]);
    //      $.ajax({
    //         url:'action/upl.php',
    //         type:'POST',
    //         data:frm_data,
    //         contentType:false,
    //         cache:false,
    //         processData:false,
    //         dataType:"json",
    //         success:function(data){
    //             $('.img-box').css({'background-image':'url("upl-img/'+data.photoName+'")'});
    //             $('#txt_photo').val(data.photoName);
    //         }
    //     });
    //   }





    // $img_name = $_FILES['txt_file']['name'];
    // $tmp_name = $_FILES['txt_file']['tmp_name'];
    // $ext = pathinfo($img_name,PATHINFO_EXTENSION);
    // $t = time();

    // move_uploaded_file($tmp_name,'../upl-img/'.$t.'.'.$ext);
    // $msg['photoName']=$t.'.'.$ext;
    // echo json_encode($msg);
