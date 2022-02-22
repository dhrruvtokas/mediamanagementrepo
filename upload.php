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

	// Uploading The File
	$keyName = 'content/' . basename($_FILES["file_upload"]['name']);
	$pathInS3 = 'https://s3.ap-southeast-2.amazonaws.com/' . $bucketName . '/' . $keyName;

	try {
		$file = $_FILES["file_upload"]['tmp_name'];

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}
	echo '<script>alert("File Uploaded Successfully")</script>';
	include 'index.html';
?>