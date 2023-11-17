Adding Content-Length header
=============

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
Adding a ``Content-Length`` header for ``ZipStream`` can be achieved by
using the options ``SIMULATION_STRICT`` or ``SIMULATION_LAX`` in the
``operationMode`` parameter.

In the ``SIMULATION_STRICT`` mode, ``ZipStream`` will not allow to calculate the
size based on reading the whole file. ``SIMULATION_LAX`` will read the whole
file if neccessary.

``SIMULATION_STRICT`` is therefore useful to make sure that the size can be
calculated efficiently.

.. code-block:: php
    use ZipStream\OperationMode;
    use ZipStream\ZipStream;

    $zip = new ZipStream(
        operationMode: OperationMode::SIMULATE_STRICT, // or SIMULATE_LAX
        defaultEnableZeroHeader: false,
        sendHttpHeaders: true,
        outputStream: $stream,
    );

    // Normally add files
    $zip->addFile('sample.txt', 'Sample String Data');

    // Use addFileFromCallback and exactSize if you want to defer opening of
    // the file resource
    $zip->addFileFromCallback(
        'sample.txt',
        exactSize: 18,
        callback: function () {
            return fopen('...');
        }
    );

    // Read resulting file size
    $size = $zip->finish();
    
    // Tell it to the browser
    header('Content-Length: '. $size);
    
    // Execute the Simulation and stream the actual zip to the client
    $zip->executeSimulation();

<<<<<<< HEAD
=======
=======
Adding a ``Content-Length`` header for ``ZipStream`` is not trivial since the
size is not known beforehand.

The following workaround adds an approximated header:

.. code-block:: php

    class Zip
    {
        /** @var string */
        private $name;

        private $files = [];

        public function __construct($name)
        {
            $this->name = $name;
        }

        public function addFile($name, $data)
        {
            $this->files[] = ['type' => 'addFile', 'name' => $name, 'data' => $data];
        }

        public function addFileFromPath($name, $path)
        {
            $this->files[] = ['type' => 'addFileFromPath', 'name' => $name, 'path' => $path];
        }

        public function getEstimate()
        {
            $estimate = 22;
            foreach ($this->files as $file) {
            $estimate += 76 + 2 * strlen($file['name']);
            if ($file['type'] === 'addFile') {
                $estimate += strlen($file['data']);
            }
            if ($file['type'] === 'addFileFromPath') {
                $estimate += filesize($file['path']);
            }
            }
            return $estimate;
        }

        public function finish()
        {
            header('Content-Length: ' . $this->getEstimate());
            $options = new \ZipStream\Option\Archive();
            $options->setSendHttpHeaders(true);
            $options->setEnableZip64(false);
            $options->setDeflateLevel(-1);
            $zip = new \ZipStream\ZipStream($this->name, $options);

            $fileOptions = new \ZipStream\Option\File();
            $fileOptions->setMethod(\ZipStream\Option\Method::STORE());
            foreach ($this->files as $file) {
            if ($file['type'] === 'addFile') {
                $zip->addFile($file['name'], $file['data'], $fileOptions);
            }
            if ($file['type'] === 'addFileFromPath') {
                $zip->addFileFromPath($file['name'], $file['path'], $fileOptions);
            }
            }
            $zip->finish();
            exit;
        }
    }

It only works with the following constraints:

- All file content is known beforehand.
- Content Deflation is disabled

Thanks to
`partiellkorrekt <https://github.com/maennchen/ZipStream-PHP/issues/89#issuecomment-1047949274>`_
for this workaround.
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
