<?php
/*
SUPARDYKE
Copyright (c) 2016 SUPARDYKE
*/

// Define a destination
$targetFolder = 'uploads/docs/'; // Relative to the root
$fileTypes = array('csv','xls','gif','png','CSV','XLS','GIF','PNG'); // File extensions
$formFieldName = 'file'; // Form field name
$changeFileName = true;// Bool for auto changing of file name by adding time stamp
$validateFileType = true; // Bool for file extension validation
$proceed = true;


if (!empty($_FILES)) {
	$tempFile = $_FILES[$formFieldName]['tmp_name'];
	$targetPath = dirname(__FILE__) . '/' . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' .round(microtime(true)). $_FILES[$formFieldName]['name'];

	$filename = $_FILES[$formFieldName]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file name
	$file_ext = substr($filename, strripos($filename, '.')); // get file ext
	$file_ext = strtolower($file_ext);
	if ($changeFileName == true) {
		$newfilename = round(microtime(true)).'_'.$file_basename . $file_ext;
	}else{
		$newfilename = $file_basename . $file_ext;
	}
	$targetFile = rtrim($targetPath,'/') . '/' . $newfilename;
	
	// Validate the file type
	$fileParts = pathinfo(round(microtime(true)). $_FILES[$formFieldName]['name']);
	$response = array ();

	if ($validateFileType == true) {
		if (!in_array($fileParts['extension'],$fileTypes)) {
			$proceed = false;
		}
	}
	if ($proceed == true) {
		move_uploaded_file($tempFile,$targetFile);
		$response['status'] = 'success';
		$response['message'] = 'successful upload';
		$response['filename'] = $newfilename;
		echo json_encode($response);
	}else{
		$response['status'] = 'error';
		$response['message'] = 'file format not allowed';
		$response['filename'] = null;
	}
}
?>