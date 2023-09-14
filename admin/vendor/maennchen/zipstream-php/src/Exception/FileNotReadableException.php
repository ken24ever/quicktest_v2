<?php

declare(strict_types=1);

namespace ZipStream\Exception;

use ZipStream\Exception;

/**
 * This Exception gets invoked if a file wasn't found
 */
class FileNotReadableException extends Exception
{
    /**
<<<<<<< HEAD
     * @internal
     */
    public function __construct(
        public readonly string $path
    ) {
=======
     * Constructor of the Exception
     *
     * @param String $path - The path which wasn't found
     */
    public function __construct(string $path)
    {
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
        parent::__construct("The file with the path $path isn't readable.");
    }
}
