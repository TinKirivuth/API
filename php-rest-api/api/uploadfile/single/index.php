<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include('../../_config_inc.php');
    // Declare Array Empty
    $response = array();
    if (isset($_GET['apiKey'])){
        $apiKey=$_GET['apiKey'];
        if($apiKey=='27730144301d426b8aa2fc2c89f56177'){
            if(is_uploaded_file($_FILES["file"]["tmp_name"])){
                $img_name = $_FILES['file']['name'];
                $tmp_name = $_FILES['file']['tmp_name'];
                $ext = pathinfo($img_name,PATHINFO_EXTENSION);
                $t = time();
                $new_name = $t.'.'.$ext;
                $upload_dir = '../../upl-images/'.$new_name;

                if (move_uploaded_file($tmp_name,$upload_dir)){
                    $response["code"] = 200;
                    $response["message"] = "Uploaded Success";
                    $response["data"] = BASE_URL.'upl-images/'.$new_name;
                }else{
                    $response["code"] = 404;
                    $response["message"] = "Uploaded Failed";
                }
            }
            else{
                $response["code"] = 400;
                $response["message"] = "Invalid Request";
            }
            echo json_encode($response);

        }
    }else{
        $response["code"] = 400;
        $response["message"] = "Invalid Request";
        echo json_encode($response);
    }
   
















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