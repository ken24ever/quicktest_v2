<?php

namespace PhpOffice\PhpSpreadsheet\Shared;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use ZipArchive;

class File
{
    /**
     * Use Temp or File Upload Temp for temporary files.
     *
     * @var bool
     */
    protected static $useUploadTempDirectory = false;

    /**
     * Set the flag indicating whether the File Upload Temp directory should be used for temporary files.
     */
    public static function setUseUploadTempDirectory(bool $useUploadTempDir): void
    {
        self::$useUploadTempDirectory = (bool) $useUploadTempDir;
    }

    /**
     * Get the flag indicating whether the File Upload Temp directory should be used for temporary files.
     */
    public static function getUseUploadTempDirectory(): bool
    {
        return self::$useUploadTempDirectory;
    }

    // https://pkware.cachefly.net/webdocs/casestudies/APPNOTE.TXT
    // Section 4.3.7
    // Looks like there might be endian-ness considerations
    private const ZIP_FIRST_4 = [
        "\x50\x4b\x03\x04", // what it looks like on my system
        "\x04\x03\x4b\x50", // what it says in documentation
    ];

    private static function validateZipFirst4(string $zipFile): bool
    {
        $contents = @file_get_contents($zipFile, false, null, 0, 4);

        return in_array($contents, self::ZIP_FIRST_4, true);
    }

    /**
     * Verify if a file exists.
     */
    public static function fileExists(string $filename): bool
    {
        // Sick construction, but it seems that
        // file_exists returns strange values when
        // doing the original file_exists on ZIP archives...
        if (strtolower(substr($filename, 0, 6)) == 'zip://') {
            // Open ZIP file and verify if the file exists
            $zipFile = substr($filename, 6, strrpos($filename, '#') - 6);
            $archiveFile = substr($filename, strrpos($filename, '#') + 1);

            if (self::validateZipFirst4($zipFile)) {
                $zip = new ZipArchive();
                $res = $zip->open($zipFile);
                if ($res === true) {
                    $returnValue = ($zip->getFromName($archiveFile) !== false);
                    $zip->close();

                    return $returnValue;
                }
            }

            return false;
        }

        return file_exists($filename);
    }

    /**
     * Returns canonicalized absolute pathname, also for ZIP archives.
     */
    public static function realpath(string $filename): string
    {
        // Returnvalue
        $returnValue = '';

        // Try using realpath()
        if (file_exists($filename)) {
            $returnValue = realpath($filename) ?: '';
        }

        // Found something?
        if ($returnValue === '') {
            $pathArray = explode('/', $filename);
            while (in_array('..', $pathArray) && $pathArray[0] != '..') {
                $iMax = count($pathArray);
                for ($i = 0; $i < $iMax; ++$i) {
                    if ($pathArray[$i] == '..' && $i > 0) {
                        unset($pathArray[$i], $pathArray[$i - 1]);

                        break;
                    }
                }
            }
            $returnValue = implode('/', $pathArray);
        }

        // Return
        return $returnValue;
    }

    /**
     * Get the systems temporary directory.
     */
    public static function sysGetTempDir(): string
    {
        $path = sys_get_temp_dir();
        if (self::$useUploadTempDirectory) {
            //  use upload-directory when defined to allow running on environments having very restricted
            //      open_basedir configs
            if (ini_get('upload_tmp_dir') !== false) {
                if ($temp = ini_get('upload_tmp_dir')) {
                    if (file_exists($temp)) {
                        $path = $temp;
                    }
                }
            }
        }

        return realpath($path) ?: '';
    }

    public static function temporaryFilename(): string
    {
        $filename = tempnam(self::sysGetTempDir(), 'phpspreadsheet');
        if ($filename === false) {
            throw new Exception('Could not create temporary file');
        }

        return $filename;
    }

    /**
     * Assert that given path is an existing file and is readable, otherwise throw exception.
     */
    public static function assertFile(string $filename, string $zipMember = ''): void
    {
        if (!is_file($filename)) {
            throw new ReaderException('File "' . $filename . '" does not exist.');
        }

        if (!is_readable($filename)) {
            throw new ReaderException('Could not open "' . $filename . '" for reading.');
        }

        if ($zipMember !== '') {
            $zipfile = "zip://$filename#$zipMember";
            if (!self::fileExists($zipfile)) {
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
                // Has the file been saved with Windoze directory separators rather than unix?
                $zipfile = "zip://$filename#" . str_replace('/', '\\', $zipMember);
                if (!self::fileExists($zipfile)) {
                    throw new ReaderException("Could not find zip member $zipfile");
                }
<<<<<<< HEAD
=======
=======
                throw new ReaderException("Could not find zip member $zipfile");
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
            }
        }
    }

    /**
     * Same as assertFile, except return true/false and don't throw Exception.
     */
    public static function testFileNoThrow(string $filename, ?string $zipMember = null): bool
    {
        if (!is_file($filename)) {
            return false;
        }
        if (!is_readable($filename)) {
            return false;
        }
        if ($zipMember === null) {
            return true;
        }
        // validate zip, but don't check specific member
        if ($zipMember === '') {
            return self::validateZipFirst4($filename);
        }

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
        $zipfile = "zip://$filename#$zipMember";
        if (self::fileExists($zipfile)) {
            return true;
        }

        // Has the file been saved with Windoze directory separators rather than unix?
        $zipfile = "zip://$filename#" . str_replace('/', '\\', $zipMember);

        return self::fileExists($zipfile);
<<<<<<< HEAD
=======
=======
        return self::fileExists("zip://$filename#$zipMember");
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
    }
}
