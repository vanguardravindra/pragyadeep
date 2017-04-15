<?php
class Submission extends CI_Controller
{
	function __construct()
	{
		parent:: __construct();
		$this->load->library(array('form_validation','session','pagination'));
	$this->load->helper(array('form','url','template','html','date'));
	$this->load->model('master_model');
	}
	
	function index()
	{
		//$_POST['token']=md5("vanguard");
		//category_id=2;
		//user_id=2;
	//image=my_img.jpg
		
			if(!isset($_POST['category_id'])|| $_POST['category_id']=="")
		{
			$error['err_category_id']="category_id required";
			}	
			if(!isset($_POST['user_id'])|| $_POST['user_id']=="")
		{
			$error['err_user_id']="user_id required";
			}
		if(!isset($_POST['image'])|| $_POST['image']=="")
		{
			$error['err_image']="image required";
			}	
		
		
		if(!empty($error))
	{
		echo json_encode(array('status'=>0,'msg'=>$error,'record'=>""));
	}
		
	else
	{
	 
      /*   header('Content-Type: bitmap; charset=utf-8');
	// Get image string posted from Android App
  
if($_REQUEST['filename1']!="")
{
 $base1=$_REQUEST['image1'];
    // Get file name posted from Android App
    $filename1 = $_REQUEST['filename1'];
    // Decode Image
    $binary1=base64_decode($base1);
    
    // Images will be saved under 'www/imgupload/uplodedimages' folder
    $file1 = fopen('img/'.$filename1, 'wb');
    // Create File
    fwrite($file1, $binary1);
    fclose($file1);
	// Get image string posted from Android App
}
else
{
  $filename1="";
}*/
 //move_uploaded_file($_FILES['Upload_document']['tmp_name'], "uploads/images/" . $img);
 if (isset($_FILES['image']))
                    {
        $des="img/".time().$_FILES['image']['name'];
		$src=$_FILES['image']['tmp_name'];
		move_uploaded_file($src,$des);
					}

$data=array(
		'image'=>$des,
		'date_add'=>date('Y-m-d H:i:s'),
		'user_id'=>$this->input->post('user_id'),
		'category_id'=>$this->input->post('category_id'),
		'is_display'=>1);
		$this->master_model->insert_entry('user_submission',$data);
		echo json_encode(array('status'=>1,'msg'=>"welldone"));



}
	
	 }	
	
	function submission_list()
	{
		 // $_POST['token']=md5("vanguard");
		 // $_POST['user_id']=8;
	
	
	$error=array();
		if(!isset($_POST['token']) || $_POST['token']=="")
		{
			$error['error_token']="invalid token";
		}
	 else if($_POST['token']=="587bb16b7ae57a697c5381b20253e80a")
{
		if(!isset($_POST['user_id'])|| $_POST['user_id']=="")
		{
			$error['err_user_id']="user_id required";
		}
		}
		
		
		if(!empty($error))
	{
		echo json_encode(array('status'=>0,'msg'=>$error,'record'=>""));
	}
	
	else{
		$query = $this->db->query("
		SELECT `user`.`fname`,CONCAT('".PRODUCT_IMAGE."',`image`) as `img`,`user_submission`.`us_id`,`user_submission`.`user_id`,`user_submission`.`date_add` FROM `user_submission` INNER JOIN `user` ON `user`.`user_id`=`user_submission`.`user_id`  WHERE `user_submission`.`user_id`='".$_POST['user_id']."'");
		
		
       if ($query->num_rows()>0)
		{
		echo json_encode(array("status"=>1,"msg"=>$error,"record"=>$query->row()));
	
	
	}
	else
	{
		echo json_encode(array("status"=>0,"msg"=>"invalid user."));
	}
	}
   
	}
	}
	
	
	
	
	
	