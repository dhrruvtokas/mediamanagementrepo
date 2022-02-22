<?php
	// Loading the required packages (aws sdk) using the composer
	require 'vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Details
	//Bucket Name	
	$bucketName = 'dungeon';	
	
	// Access Key
	$IAM_KEY = 'AKIASNKD732LZBBFZJ45';
	
	// Secret Key
	$IAM_SECRET = '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';

	// AWS Connection
	try {
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'ap-southeast-2'
			)
		);
	} catch (Exception $e) {
		die("Error: " . $e->getMessage());
	}
	
	$response = $s3->listObjects(array('Bucket' => $bucketName, 'Prefix' => 'content/'));
    
	$files = $response->getPath('Contents');
    $request_id = array();
	$file_array = array();
    
	foreach ($files as $file) {
		$filename = $file['Key'];
		$retrieved_file = substr($filename,8);
		$file_array[] = $retrieved_file;
    }
	$file_array_size = count($file_array);
	?>
	
<html> 
<head> 
<title> AWS Upload Prototpe </title>
<style>
.upload_button {
  display:inline-block;
  padding:0.5em 1.5em;
  border-radius:3em;
  box-sizing: border-box;
  font-family: "Comic Sans MS", "Comic Sans", cursive;
  font-weight:300;
  color:white;
  background-color:red;
  text-align:center;
  transition: all 0.4s;
}
.upload_button:hover {
  background-color:white;
  color: red;
}

.download_button {
  display:inline-block;
  padding:0.5em 1.5em;
  border-radius:3em;
  box-sizing: border-box;
  font-family: "Comic Sans MS", "Comic Sans", cursive;
  font-weight:300;
  color:white;
  background-color:DodgerBlue;
  text-align:center;
  transition: all 0.4s;
}
.download_button:hover {
  background-color:white;
  color: DodgerBlue;
}

.home_button {
  display:inline-block;
  padding:0.5em 1.5em;
  border-radius:3em;
  box-sizing: border-box;
  font-family: "Comic Sans MS", "Comic Sans", cursive;
  font-weight:300;
  color:white;
  background-color:orange;
  text-align:center;
  transition: all 0.4s;
}
.home_button:hover {
  background-color:white;
  color: orange;
}

</style>
</head> 
<body style="background-color:black;">

<BR><BR>

<center>
<h1 style="color:white;">Media File Uploader V2</h1>

<form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
<input type="file" name="file_upload" id="file_upload" style="color:white;">
<input type="submit" value="Upload" name="submit" class="upload_button">
</form>

<form action="download.php" method="post" enctype="multipart/form-data" id="downloadForm">
<select name="dynamic_data">
<?php
for ($i=0;$i<$file_array_size;$i++){
?>
<option value="<?=$file_array[$i];?>"><?=$file_array[$i];?></option>
<?php
}
?>
</select>
<input type="submit" value="Download" name="submit" class="download_button">
</form>

<form action="index.html" method="post" enctype="multipart/form-data" id="indexForm">
<input type="submit" value="Dashboard" name="submit" class="home_button">
</form>

</center>
</body> 
</html>


