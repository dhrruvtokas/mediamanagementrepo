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
	
	# File name
	$keyname =  $_POST["dynamic_data"];

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

	// Downloading The File
	try {
        $result = $s3->getObject([
        'Bucket' => $bucketName,
        'Key' => 'content/' .$keyname
    ]);
    
	# Configuring File Properties
    header("Content-Type: {$result['ContentType']}");
	header('Content-Disposition: attachment; filename=' . $keyname);
    echo $result['Body'];
    } catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    }
	echo 'Done';
?>