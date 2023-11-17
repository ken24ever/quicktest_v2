Usage with PSR 7 Streams
===============

PSR-7 streams are `standardized streams <https://www.php-fig.org/psr/psr-7/>`_.

ZipStream-PHP supports working with these streams with the function
``addFileFromPsr7Stream``. 

For all parameters of the function see the API documentation.

Example
---------------

.. code-block:: php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742

    $stream = $response->getBody();
    // add a file named 'streamfile.txt' from the content of the stream
    $zip->addFileFromPsr7Stream(
        fileName: 'streamfile.txt',
        stream: $stream,
    );
<<<<<<< HEAD
=======
=======
    
    $stream = $response->getBody();
    // add a file named 'streamfile.txt' from the content of the stream
    $zip->addFileFromPsr7Stream('streamfile.txt', $stream);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
