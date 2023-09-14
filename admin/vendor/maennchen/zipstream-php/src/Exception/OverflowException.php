<?php

declare(strict_types=1);

namespace ZipStream\Exception;

use ZipStream\Exception;

/**
 * This Exception gets invoked if a counter value exceeds storage size
 */
class OverflowException extends Exception
{
<<<<<<< HEAD
    /**
     * @internal
     */
=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    public function __construct()
    {
        parent::__construct('File size exceeds limit of 32 bit integer. Please enable "zip64" option.');
    }
}
