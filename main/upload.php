<?php
error_reporting(0);
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

#!! IMPORTANT: 
#!! this file is just an example, it doesn't incorporate any security checks and 
#!! is not recommended to be used in production environment as it is. Be sure to 
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* 
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = "/home/test/python/Flask-Auth-REST-API/uploads";
//$targetDir = 'uploads';
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
	@mkdir($targetDir);
}

// Get a file name
if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
	$date = new DateTime();
	$ext = pathinfo($_REQUEST["name"], PATHINFO_EXTENSION);
	$fileName = $date->getTimestamp().'.'.$ext;
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
	$date = new DateTime();
	$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
	$fileName = $date->getTimestamp().'.'.$ext;
} else {
	$fileName = uniqid("file_");
	$date = new DateTime();
	$ext = pathinfo(uniqid("file_"), PATHINFO_EXTENSION);
	$fileName = $date->getTimestamp().'.'.$ext;
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files	
if ($cleanupTargetDir) {
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// If temp file is current file proceed to the next
		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}	


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
} else {	
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
}

while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
	rename("{$filePath}.part", $filePath);
}

$ret = callAPI('GET', 'http://127.0.0.1:5000/filedata?filename='.$fileName.'&dept=na', false, $fileName);
$manage = json_decode($ret);
// echo $manage -> status;
if($manage->status == 'complete'){
	$sent = 'true';
}
else{
	$sent = 'false';
}

function login($email, $pass){
	$url = 'http://127.0.0.1:5000/api/auth/login';
	$data = array("email" => $email,"password" => $pass);
 
	$postdata = json_encode($data);
 
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	curl_close($ch);
	$res = json_decode($result);
	return $res->jwt_token;
 }

function callAPI($method, $url, $data, $fileName){
	$key = login('test@test.com','123'); 
    $curl = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 40000);
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Authorization: Bearer '.$key,
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){
		delete("/home/test/python/Flask-Auth-REST-API/uploads/".$fileName);
		die("Connection Failure");
	}
    curl_close($curl);
    return $result;
}

function delete($file_pointer){
	if (!unlink($file_pointer)) {
	}  
	else {
	}  
}

// Return Success JSON-RPC response
if($sent == 'true'){
	die('{"jsonrpc" : "2.0", "result" : "Successfully uploaded and processed file!", "id" : "id", "filename" : "'.$fileName.'"}');
}
else{
	delete("/home/test/python/Flask-Auth-REST-API/uploads/".$fileName);
	die('{"jsonrpc" : "2.0", "result" : "Failed to process file.", "id" : "id", "filename" : "'.$fileName.'"}');
}
// die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

