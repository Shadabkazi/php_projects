<?php
	session_start(); 
    
			if(isset($_POST["btnSubmit"]))
			{
				$errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$bytes = 1024;
				$KB = 5120;
				$totalBytes = $bytes * $KB;			//size should not exceed 5MB
				$UploadFolder = "UploadFolder";		//folder in which images will be uploaded
				
				$counter = 0;
				
				foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["files"]["tmp_name"][$key];
					$name = $_FILES["files"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
					if($_FILES["files"]["size"][$key] > $totalBytes)
					{
						$UploadOk = false;
						array_push($errors, $name." file size is larger than the 1 MB.");
					}
					
					$ext = pathinfo($name, PATHINFO_EXTENSION);			//returns extension of file
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $name." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$name) == true){		// check if file already exists
						$UploadOk = false;
						array_push($errors, $name." file is already exist.");
					}
					
					if($UploadOk  == true){									//file is safe to be uploaded
						move_uploaded_file($temp,$UploadFolder."/".$name);
						array_push($uploadedFiles, $name);
					}
				}
			$_SESSION['error']=$UploadOk;
			}
		?>