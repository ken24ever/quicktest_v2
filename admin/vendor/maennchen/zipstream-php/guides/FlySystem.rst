Usage with FlySystem
===============

For saving or uploading the generated zip, you can use the
`Flysystem <https://flysystem.thephpleague.com>`_ package, and its many
adapters.

For that you will need to provide another stream than the ``php://output``
default one, and pass it to Flysystem ``putStream`` method.

.. code-block:: php

    // Open Stream only once for read and write since it's a memory stream and
    // the content is lost when closing the stream / opening another one
    $tempStream = fopen('php://memory', 'w+');

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
    // Create Zip Archive
    $zipStream = new ZipStream(
        outputStream: $tempStream,
        outputName: 'test.zip',
    );
    $zipStream->addFile('test.txt', 'text');
    $zipStream->finish();

    // Store File
    // (see Flysystem documentation, and all its framework integration)
    // Can be any adapter (AWS, Google, Ftp, etc.)
    $adapter = new Local(__DIR__.'/path/to/folder');
    $filesystem = new Filesystem($adapter);

    $filesystem->writeStream('test.zip', $tempStream)

    // Close Stream
    fclose($tempStream);
<<<<<<< HEAD
=======
=======
    // Init Options
    $zipStreamOptions = new Archive();
    $zipStreamOptions->setOutputStream($tempStream);

    // Create Zip Archive
    $zipStream = new ZipStream('test.zip', $zipStreamOptions);
    $zipStream->addFile('test.txt', 'text');
    $zipStream->finish();

    // Store File (see Flysystem documentation, and all its framework integration)
    $adapter = new Local(__DIR__.'/path/to/folder'); // Can be any adapter (AWS, Google, Ftp, etc.)
    $filesystem = new Filesystem($adapter);

    $filesystem->putStream('test.zip', $tempStream)

    // Close Stream
    fclose($tempStream);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
