<?php
include 'easyThumbnail.php';

$uploa_dir = "image/";
  
 

if(!empty($_FILES)){
 
    $access = FALSE;

	$image_extantion = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

	$whitelist = array(".jpeg",".jpg",".png",".gif");
	foreach ($whitelist as $item) {
		if(preg_match("/$item\$/i", $_FILES['fileToUpload']['name'])){
			$new_file_name =  sha1(time())."-".time() ;
  
			$access = True; 
			$uploadfile = $uploa_dir.$new_file_name.".".$image_extantion;
		}
	}

	if($access){
		 if($_FILES["uploadfile"]["error"]=UPLOAD_ERR_OK && getimagesize($_FILES['uploadfile']['tmp_name']) || !file_exists($uploadfile)){
		 	 if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile) ) {
 				$result = easy_thumbnail(
 					$uploadfile , 
 					"32", "32",
 					$uploa_dir."/thumb32_".$new_file_name.".".$image_extantion ,
 					$log = True 
 					);

 				if(!$result)
 					logger("thumbnail not created");
 				else
 					logger("image thumbnail successfuly created ".$result);
		 	 }
		 }
	}


} 

