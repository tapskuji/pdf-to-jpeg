<?php

date_default_timezone_set('Africa/Johannesburg');

error_reporting(E_ALL);

define('ABSPATH', dirname(__DIR__));

require_once ABSPATH . '/libs/KLogger.php';

$logfile = ABSPATH . '/logs/errors.log';
$logger = new KLogger($logfile, KLogger::DEBUG);

$logger->LogInfo('start');

$directory = ABSPATH . '/files/pdf/';
$fileExtension = 'pdf';
$pattern = $directory . "*." . $fileExtension;
$fileList = glob($pattern);

if (empty($fileList)) {
    $logger->LogInfo('No files to convert');
    $logger->LogInfo('end');
    exit;
}

foreach ($fileList as $pdfFile) {

    try {
        splitPdf($pdfFile);
    } catch (Exception $e) {
        $logger->LogWarn("Fatal error processing pdf: {$e->getMessage()}");
    }

    $logger->LogInfo("Deleting pdf {$pdfFile}");
    unlink($pdfFile);
    $logger->LogInfo('Sleeping for 2 seconds');
    sleep(2); // sleep to lower cpu usage
}

/**
 * @throws Exception
 */
function splitPdf($pdfFile)
{
    global $logger;

    $logger->LogInfo("Processing {$pdfFile}");
    $imageDirectory = ABSPATH . '/files/images/';
    $path_parts = pathinfo($pdfFile);
    $filename = $path_parts['filename'];
    $imageFilename = explode('-', $filename);
    $imageFilename = trim($imageFilename[1]);

    $images = new Imagick();
    $exception = null;

    try {
        $images->setResolution(150, 150);
        $images->readImage($pdfFile);

        foreach($images as $i=>$image) {
            $newImageName = $imageDirectory . $imageFilename . "_page_{$i}.jpg";
            $image->setImageCompressionQuality(20);
            $image->writeImage($newImageName);
            $logger->LogInfo("New image {$newImageName}");
        }
    } catch (Exception $e) {
        $exception = $e; //store exception so that we can rethrow it later
    }

    //clean up to prevent high cpu use
    $images->clear();
    $images->destroy();

    if ($exception) {
        throw $exception; //now throw the exception
    }
}

$logger->LogInfo('end');
