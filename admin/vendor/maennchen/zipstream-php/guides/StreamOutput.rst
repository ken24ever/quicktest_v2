Stream Output
===============

Stream to S3 Bucket
---------------

.. code-block:: php
<<<<<<< HEAD

    use Aws\S3\S3Client;
    use Aws\Credentials\CredentialProvider;
=======
    use Aws\S3\S3Client;
    use Aws\Credentials\CredentialProvider;
    use ZipStream\Option\Archive;
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    use ZipStream\ZipStream;

    $bucket = 'your bucket name';
    $client = new S3Client([
        'region' => 'your region',
        'version' => 'latest',
        'bucketName' => $bucket,
        'credentials' => CredentialProvider::defaultProvider(),
    ]);
    $client->registerStreamWrapper();

    $zipFile = fopen("s3://$bucket/example.zip", 'w');

<<<<<<< HEAD
    $zip = new ZipStream(
        enableZip64: false,
        outputStream: $zipFile,
    );

    $zip->addFile(
        fileName: 'file1.txt',
        data: 'File1 data',
    );
    $zip->addFile(
        fileName: 'file2.txt',
        data: 'File2 data',
    );
    $zip->finish();

    fclose($zipFile);
=======
    $options = new Archive();
    $options->setEnableZip64(false);
    $options->setOutputStream($zipFile);

    $zip = new ZipStream(null, $options);
    $zip->addFile('file1.txt', 'File1 data');
    $zip->addFile('file2.txt', 'File2 data');
    $zip->finish();

    fclose($zipFile);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
