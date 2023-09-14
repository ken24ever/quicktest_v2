<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace ZipStream\Test;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\StreamWrapper;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use ZipArchive;
use ZipStream\CompressionMethod;
use ZipStream\Exception\FileNotFoundException;
use ZipStream\Exception\FileNotReadableException;
use ZipStream\Exception\FileSizeIncorrectException;
use ZipStream\Exception\OverflowException;
use ZipStream\Exception\ResourceActionException;
use ZipStream\Exception\SimulationFileUnknownException;
use ZipStream\Exception\StreamNotReadableException;
use ZipStream\Exception\StreamNotSeekableException;
use ZipStream\OperationMode;
use ZipStream\PackField;
use ZipStream\ZipStream;

class ZipStreamTest extends TestCase
{
    use Util;
    use Assertions;
=======
namespace ZipStreamTest;

use GuzzleHttp\Psr7\Response;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ZipArchive;
use ZipStream\File;
use ZipStream\Option\Archive as ArchiveOptions;
use ZipStream\Option\File as FileOptions;
use ZipStream\Option\Method;
use ZipStream\Stream;
use ZipStream\ZipStream;

/**
 * Test Class for the Main ZipStream CLass
 */
class ZipStreamTest extends TestCase
{
    public function testFileNotFoundException(): void
    {
        $this->expectException(\ZipStream\Exception\FileNotFoundException::class);
        // Get ZipStream Object
        $zip = new ZipStream();

        // Trigger error by adding a file which doesn't exist
        $zip->addFileFromPath('foobar.php', '/foo/bar/foobar.php');
    }

    public function testFileNotReadableException(): void
    {
        // create new virtual filesystem
        $root = vfsStream::setup('vfs');
        // create a virtual file with no permissions
        $file = vfsStream::newFile('foo.txt', 0)->at($root)->setContent('bar');
        $zip = new ZipStream();
        $this->expectException(\ZipStream\Exception\FileNotReadableException::class);
        $zip->addFileFromPath('foo.txt', $file->url());
    }

    public function testDostime(): void
    {
        // Allows testing of protected method
        $class = new ReflectionClass(File::class);
        $method = $class->getMethod('dostime');
        $method->setAccessible(true);

        $this->assertSame($method->invoke(null, 1416246368), 1165069764);

        // January 1 1980 - DOS Epoch.
        $this->assertSame($method->invoke(null, 315532800), 2162688);

        // January 1 1970 -> January 1 1980 due to minimum DOS Epoch.  @todo Throw Exception?
        $this->assertSame($method->invoke(null, 0), 2162688);
    }
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

    public function testAddFile(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $zip->addFile('sample.txt', 'Sample String Data');
        $zip->addFile('test/sample.txt', 'More Simple Sample Data');

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt', 'test' . DIRECTORY_SEPARATOR . 'sample.txt'], $files);

        $this->assertStringEqualsFile($tmpDir . '/sample.txt', 'Sample String Data');
        $this->assertStringEqualsFile($tmpDir . '/test/sample.txt', 'More Simple Sample Data');
    }

    public function testAddFileUtf8NameComment(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $name = 'árvíztűrő tükörfúrógép.txt';
        $content = 'Sample String Data';
        $comment =
            'Filename has every special characters ' .
            'from Hungarian language in lowercase. ' .
            'In uppercase: ÁÍŰŐÜÖÚÓÉ';

<<<<<<< HEAD
        $zip->addFile(fileName: $name, data: $content, comment: $comment);
=======
        $fileOptions = new FileOptions();
        $fileOptions->setComment($comment);

        $zip->addFile($name, $content, $fileOptions);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame([$name], $files);
        $this->assertStringEqualsFile($tmpDir . '/' . $name, $content);

<<<<<<< HEAD
        $zipArchive = new ZipArchive();
        $zipArchive->open($tmp);
        $this->assertSame($comment, $zipArchive->getCommentName($name));
=======
        $zipArch = new ZipArchive();
        $zipArch->open($tmp);
        $this->assertSame($comment, $zipArch->getCommentName($name));
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }

    public function testAddFileUtf8NameNonUtfComment(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $name = 'á.txt';
        $content = 'any';
        $comment = mb_convert_encoding('á', 'ISO-8859-2', 'UTF-8');

        // @see https://libzip.org/documentation/zip_file_get_comment.html
        //
        // mb_convert_encoding hasn't CP437.
        // nearly CP850 (DOS-Latin-1)
        $guessComment = mb_convert_encoding($comment, 'UTF-8', 'CP850');

<<<<<<< HEAD
        $zip->addFile(fileName: $name, data: $content, comment: $comment);

=======
        $fileOptions = new FileOptions();
        $fileOptions->setComment($comment);

        $zip->addFile($name, $content, $fileOptions);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
        $zip->finish();
        fclose($stream);

        $zipArch = new ZipArchive();
        $zipArch->open($tmp);
        $this->assertSame($guessComment, $zipArch->getCommentName($name));
        $this->assertSame($comment, $zipArch->getCommentName($name, ZipArchive::FL_ENC_RAW));
    }

<<<<<<< HEAD
=======
    public function testAddFileNonUtf8NameUtfComment(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);

        $name = mb_convert_encoding('á.txt', 'ISO-8859-2', 'UTF-8');
        $content = 'any';
        $comment = 'á';

        // @see https://libzip.org/documentation/zip_get_name.html
        //
        // mb_convert_encoding hasn't CP437.
        // nearly CP850 (DOS-Latin-1)
        $guessName = mb_convert_encoding($name, 'UTF-8', 'CP850');

        $fileOptions = new FileOptions();
        $fileOptions->setComment($comment);

        $zip->addFile($name, $content, $fileOptions);
        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);

        $this->assertNotSame([$name], $files);
        $this->assertSame([$guessName], $files);
        $this->assertStringEqualsFile($tmpDir . '/' . $guessName, $content);

        $zipArch = new ZipArchive();
        $zipArch->open($tmp);
        $this->assertSame($guessName, $zipArch->getNameIndex(0));
        $this->assertSame($name, $zipArch->getNameIndex(0, ZipArchive::FL_ENC_RAW));
        $this->assertSame($comment, $zipArch->getCommentName($guessName));
    }

>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    public function testAddFileWithStorageMethod(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );

        $zip->addFile(fileName: 'sample.txt', data: 'Sample String Data', compressionMethod: CompressionMethod::STORE);
        $zip->addFile(fileName: 'test/sample.txt', data: 'More Simple Sample Data');
        $zip->finish();
        fclose($stream);

        $zipArchive = new ZipArchive();
        $zipArchive->open($tmp);

        $sample1 = $zipArchive->statName('sample.txt');
        $sample12 = $zipArchive->statName('test/sample.txt');
        $this->assertSame($sample1['comp_method'], CompressionMethod::STORE->value);
        $this->assertSame($sample12['comp_method'], CompressionMethod::DEFLATE->value);

        $zipArchive->close();
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);

        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());

        $zip->addFile('sample.txt', 'Sample String Data', $fileOptions);
        $zip->addFile('test/sample.txt', 'More Simple Sample Data');
        $zip->finish();
        fclose($stream);

        $zipArch = new ZipArchive();
        $zipArch->open($tmp);

        $sample1 = $zipArch->statName('sample.txt');
        $sample12 = $zipArch->statName('test/sample.txt');
        $this->assertSame($sample1['comp_method'], Method::STORE);
        $this->assertSame($sample12['comp_method'], Method::DEFLATE);

        $zipArch->close();
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }

    public function testAddFileFromPath(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        [$tmpExample, $streamExample] = $this->getTmpFileStream();
        fwrite($streamExample, 'Sample String Data');
        fclose($streamExample);
<<<<<<< HEAD
        $zip->addFileFromPath(fileName: 'sample.txt', path: $tmpExample);
=======
        $zip->addFileFromPath('sample.txt', $tmpExample);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        [$tmpExample, $streamExample] = $this->getTmpFileStream();
        fwrite($streamExample, 'More Simple Sample Data');
        fclose($streamExample);
<<<<<<< HEAD
        $zip->addFileFromPath(fileName: 'test/sample.txt', path: $tmpExample);
=======
        $zip->addFileFromPath('test/sample.txt', $tmpExample);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt', 'test' . DIRECTORY_SEPARATOR . 'sample.txt'], $files);

        $this->assertStringEqualsFile($tmpDir . '/sample.txt', 'Sample String Data');
        $this->assertStringEqualsFile($tmpDir . '/test/sample.txt', 'More Simple Sample Data');
    }

<<<<<<< HEAD
    public function testAddFileFromPathFileNotFoundException(): void
    {
        $this->expectException(FileNotFoundException::class);

        [, $stream] = $this->getTmpFileStream();

        // Get ZipStream Object
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );

        // Trigger error by adding a file which doesn't exist
        $zip->addFileFromPath(fileName: 'foobar.php', path: '/foo/bar/foobar.php');
    }

    public function testAddFileFromPathFileNotReadableException(): void
    {
        $this->expectException(FileNotReadableException::class);


        [, $stream] = $this->getTmpFileStream();


        // create new virtual filesystem
        $root = vfsStream::setup('vfs');
        // create a virtual file with no permissions
        $file = vfsStream::newFile('foo.txt', 0)->at($root)->setContent('bar');

        // Get ZipStream Object
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );

        $zip->addFileFromPath('foo.txt', $file->url());
    }

=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    public function testAddFileFromPathWithStorageMethod(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);

        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        [$tmpExample, $streamExample] = $this->getTmpFileStream();
        fwrite($streamExample, 'Sample String Data');
        fclose($streamExample);
<<<<<<< HEAD
        $zip->addFileFromPath(fileName: 'sample.txt', path: $tmpExample, compressionMethod: CompressionMethod::STORE);
=======
        $zip->addFileFromPath('sample.txt', $tmpExample, $fileOptions);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        [$tmpExample, $streamExample] = $this->getTmpFileStream();
        fwrite($streamExample, 'More Simple Sample Data');
        fclose($streamExample);
        $zip->addFileFromPath('test/sample.txt', $tmpExample);

        $zip->finish();
        fclose($stream);

<<<<<<< HEAD
        $zipArchive = new ZipArchive();
        $zipArchive->open($tmp);

        $sample1 = $zipArchive->statName('sample.txt');
        $this->assertSame(CompressionMethod::STORE->value, $sample1['comp_method']);

        $sample2 = $zipArchive->statName('test/sample.txt');
        $this->assertSame(CompressionMethod::DEFLATE->value, $sample2['comp_method']);

        $zipArchive->close();
=======
        $zipArch = new ZipArchive();
        $zipArch->open($tmp);

        $sample1 = $zipArch->statName('sample.txt');
        $this->assertSame(Method::STORE, $sample1['comp_method']);

        $sample2 = $zipArch->statName('test/sample.txt');
        $this->assertSame(Method::DEFLATE, $sample2['comp_method']);

        $zipArch->close();
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }

    public function testAddLargeFileFromPath(): void
    {
<<<<<<< HEAD
        foreach ([CompressionMethod::DEFLATE, CompressionMethod::STORE] as $compressionMethod) {
            foreach ([false, true] as $zeroHeader) {
                foreach ([false, true] as $zip64) {
                    if ($zeroHeader && $compressionMethod === CompressionMethod::DEFLATE) {
                        continue;
                    }
                    $this->addLargeFileFileFromPath(
                        compressionMethod: $compressionMethod,
                        zeroHeader: $zeroHeader,
                        zip64: $zip64
                    );
=======
        $methods = [Method::DEFLATE(), Method::STORE()];
        $falseTrue = [false, true];
        foreach ($methods as $method) {
            foreach ($falseTrue as $zeroHeader) {
                foreach ($falseTrue as $zip64) {
                    if ($zeroHeader && $method->equals(Method::DEFLATE())) {
                        continue;
                    }
                    $this->addLargeFileFileFromPath($method, $zeroHeader, $zip64);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
                }
            }
        }
    }

    public function testAddFileFromStream(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        // In this test we can't use temporary stream to feed data
        // because zlib.deflate filter gives empty string before PHP 7
        // it works fine with file stream
        $streamExample = fopen(__FILE__, 'rb');
        $zip->addFileFromStream('sample.txt', $streamExample);
<<<<<<< HEAD
        fclose($streamExample);
=======
//        fclose($streamExample);

        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $streamExample2 = fopen('php://temp', 'wb+');
        fwrite($streamExample2, 'More Simple Sample Data');
        rewind($streamExample2); // move the pointer back to the beginning of file.
<<<<<<< HEAD
        $zip->addFileFromStream('test/sample.txt', $streamExample2); //, $fileOptions);
        fclose($streamExample2);
=======
        $zip->addFileFromStream('test/sample.txt', $streamExample2, $fileOptions);
//        fclose($streamExample2);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt', 'test' . DIRECTORY_SEPARATOR . 'sample.txt'], $files);

        $this->assertStringEqualsFile(__FILE__, file_get_contents($tmpDir . '/sample.txt'));
        $this->assertStringEqualsFile($tmpDir . '/test/sample.txt', 'More Simple Sample Data');
    }

<<<<<<< HEAD
    public function testAddFileFromStreamUnreadableInput(): void
    {
        $this->expectException(StreamNotReadableException::class);

        [, $stream] = $this->getTmpFileStream();
        [$tmpInput] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );

        $streamUnreadable = fopen($tmpInput, 'w');

        $zip->addFileFromStream('sample.json', $streamUnreadable);
    }

    public function testAddFileFromStreamBrokenOutputWrite(): void
    {
        $this->expectException(ResourceActionException::class);

        $outputStream = FaultInjectionResource::getResource(['stream_write']);

        $zip = new ZipStream(
            outputStream: $outputStream,
            sendHttpHeaders: false,
        );

        $zip->addFile('sample.txt', 'foobar');
    }

    public function testAddFileFromStreamBrokenInputRewind(): void
    {
        $this->expectException(ResourceActionException::class);

        [,$stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            defaultEnableZeroHeader: false,
        );

        $fileStream = FaultInjectionResource::getResource(['stream_seek']);

        $zip->addFileFromStream('sample.txt', $fileStream, maxSize: 0);
    }

    public function testAddFileFromStreamUnseekableInputWithoutZeroHeader(): void
    {
        $this->expectException(StreamNotSeekableException::class);

        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            defaultEnableZeroHeader: false,
        );

        if (file_exists('/dev/null')) {
            $streamUnseekable = fopen('/dev/null', 'w+');
        } elseif (file_exists('NUL')) {
            $streamUnseekable = fopen('NUL', 'w+');
        } else {
            $this->markTestSkipped('Needs file /dev/null');
        }

        $zip->addFileFromStream('sample.txt', $streamUnseekable, maxSize: 2);
    }

    public function testAddFileFromStreamUnseekableInputWithZeroHeader(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            defaultEnableZeroHeader: true,
            defaultCompressionMethod: CompressionMethod::STORE,
        );

        $streamUnseekable = StreamWrapper::getResource(new class ('test') extends EndlessCycleStream {
            public function isSeekable(): bool
            {
                return false;
            }

            public function seek(int $offset, int $whence = SEEK_SET): void
            {
                throw new RuntimeException('Not seekable');
            }
        });

        $zip->addFileFromStream('sample.txt', $streamUnseekable, maxSize: 7);

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt'], $files);

        $this->assertSame(filesize($tmpDir . '/sample.txt'), 7);
    }

=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    public function testAddFileFromStreamWithStorageMethod(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);

        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $streamExample = fopen('php://temp', 'wb+');
        fwrite($streamExample, 'Sample String Data');
        rewind($streamExample); // move the pointer back to the beginning of file.
<<<<<<< HEAD
        $zip->addFileFromStream('sample.txt', $streamExample, compressionMethod: CompressionMethod::STORE);
        fclose($streamExample);
=======
        $zip->addFileFromStream('sample.txt', $streamExample, $fileOptions);
//        fclose($streamExample);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $streamExample2 = fopen('php://temp', 'bw+');
        fwrite($streamExample2, 'More Simple Sample Data');
        rewind($streamExample2); // move the pointer back to the beginning of file.
<<<<<<< HEAD
        $zip->addFileFromStream('test/sample.txt', $streamExample2, compressionMethod: CompressionMethod::DEFLATE);
        fclose($streamExample2);
=======
        $zip->addFileFromStream('test/sample.txt', $streamExample2);
//        fclose($streamExample2);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $zip->finish();
        fclose($stream);

<<<<<<< HEAD
        $zipArchive = new ZipArchive();
        $zipArchive->open($tmp);

        $sample1 = $zipArchive->statName('sample.txt');
        $this->assertSame(CompressionMethod::STORE->value, $sample1['comp_method']);

        $sample2 = $zipArchive->statName('test/sample.txt');
        $this->assertSame(CompressionMethod::DEFLATE->value, $sample2['comp_method']);

        $zipArchive->close();
=======
        $zipArch = new ZipArchive();
        $zipArch->open($tmp);

        $sample1 = $zipArch->statName('sample.txt');
        $this->assertSame(Method::STORE, $sample1['comp_method']);

        $sample2 = $zipArch->statName('test/sample.txt');
        $this->assertSame(Method::DEFLATE, $sample2['comp_method']);

        $zipArch->close();
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }

    public function testAddFileFromPsr7Stream(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $body = 'Sample String Data';
        $response = new Response(200, [], $body);

<<<<<<< HEAD
        $zip->addFileFromPsr7Stream('sample.json', $response->getBody());
=======
        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());

        $zip->addFileFromPsr7Stream('sample.json', $response->getBody(), $fileOptions);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.json'], $files);
        $this->assertStringEqualsFile($tmpDir . '/sample.json', $body);
    }

<<<<<<< HEAD
    /**
     * @group slow
     */
    public function testAddLargeFileFromPsr7Stream(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: true,
        );

        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: new EndlessCycleStream('0'),
            maxSize: 0x100000000,
            compressionMethod: CompressionMethod::STORE,
            lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
        );
        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.json'], $files);
        $this->assertFileIsReadable($tmpDir . '/sample.json');
        $this->assertStringStartsWith('000000', file_get_contents(filename: $tmpDir . '/sample.json', length: 20));
    }

    public function testContinueFinishedZip(): void
    {
        $this->expectException(RuntimeException::class);

        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
        $zip->finish();

        $zip->addFile('sample.txt', '1234');
    }

    /**
     * @group slow
     */
    public function testManyFilesWithoutZip64(): void
    {
        $this->expectException(OverflowException::class);

        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: false,
        );

        for ($i = 0; $i <= 0xFFFF; $i++) {
            $zip->addFile('sample' . $i, '');
        }

        $zip->finish();
    }

    /**
     * @group slow
     */
    public function testManyFilesWithZip64(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: true,
        );

        for ($i = 0; $i <= 0xFFFF; $i++) {
            $zip->addFile('sample' . $i, '');
        }

        $zip->finish();

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);

        $this->assertSame(count($files), 0x10000);
    }

    /**
     * @group slow
     */
    public function testLongZipWithout64(): void
    {
        $this->expectException(OverflowException::class);

        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: false,
            defaultCompressionMethod: CompressionMethod::STORE,
        );

        for ($i = 0; $i < 4; $i++) {
            $zip->addFileFromPsr7Stream(
                fileName: 'sample' . $i,
                stream: new EndlessCycleStream('0'),
                maxSize: 0xFFFFFFFF,
                compressionMethod: CompressionMethod::STORE,
                lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
            );
        }
    }

    /**
     * @group slow
     */
    public function testLongZipWith64(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: true,
            defaultCompressionMethod: CompressionMethod::STORE,
        );

        for ($i = 0; $i < 4; $i++) {
            $zip->addFileFromPsr7Stream(
                fileName: 'sample' . $i,
                stream: new EndlessCycleStream('0'),
                maxSize: 0x5FFFFFFF,
                compressionMethod: CompressionMethod::STORE,
                lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
            );
        }

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample0', 'sample1', 'sample2', 'sample3'], $files);
    }

    /**
     * @group slow
     */
    public function testAddLargeFileWithoutZip64WithZeroHeader(): void
    {
        $this->expectException(OverflowException::class);

        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: false,
            defaultEnableZeroHeader: true,
        );

        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: new EndlessCycleStream('0'),
            maxSize: 0x100000000,
            compressionMethod: CompressionMethod::STORE,
            lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
        );
    }

    /**
     * @group slow
     */
    public function testAddsZip64HeaderWhenNeeded(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: true,
            defaultEnableZeroHeader: false,
        );

        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: new EndlessCycleStream('0'),
            maxSize: 0x100000000,
            compressionMethod: CompressionMethod::STORE,
            lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
        );

        $zip->finish();

        $tmpDir = $this->validateAndExtractZip($tmp);
        $files = $this->getRecursiveFileList($tmpDir);

        $this->assertSame(['sample.json'], $files);
        $this->assertFileContains($tmp, PackField::pack(
            new PackField(format: 'V', value: 0x06064b50)
        ));
    }

    /**
     * @group slow
     */
    public function testDoesNotAddZip64HeaderWhenNotNeeded(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: true,
            defaultEnableZeroHeader: false,
        );

        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: new EndlessCycleStream('0'),
            maxSize: 0x10,
            compressionMethod: CompressionMethod::STORE,
            lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
        );

        $zip->finish();

        $tmpDir = $this->validateAndExtractZip($tmp);
        $files = $this->getRecursiveFileList($tmpDir);

        $this->assertSame(['sample.json'], $files);
        $this->assertFileDoesNotContain($tmp, PackField::pack(
            new PackField(format: 'V', value: 0x06064b50)
        ));
    }

    /**
     * @group slow
     */
    public function testAddLargeFileWithoutZip64WithoutZeroHeader(): void
    {
        $this->expectException(OverflowException::class);

        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            enableZip64: false,
            defaultEnableZeroHeader: false,
        );

        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: new EndlessCycleStream('0'),
            maxSize: 0x100000000,
            compressionMethod: CompressionMethod::STORE,
            lastModificationDateTime: new DateTimeImmutable('2022-01-01 01:01:01Z'),
        );
    }

    public function testAddFileFromPsr7StreamWithOutputToPsr7Stream(): void
    {
        [$tmp, $resource] = $this->getTmpFileStream();
        $psr7OutputStream = new ResourceStream($resource);


        $zip = new ZipStream(
            outputStream: $psr7OutputStream,
            sendHttpHeaders: false,
        );
=======
    public function testAddFileFromPsr7StreamWithOutputToPsr7Stream(): void
    {
        [$tmp, $resource] = $this->getTmpFileStream();
        $psr7OutputStream = new Stream($resource);

        $options = new ArchiveOptions();
        $options->setOutputStream($psr7OutputStream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $body = 'Sample String Data';
        $response = new Response(200, [], $body);

<<<<<<< HEAD
        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: $response->getBody(),
            compressionMethod: CompressionMethod::STORE,
        );
=======
        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());

        $zip->addFileFromPsr7Stream('sample.json', $response->getBody(), $fileOptions);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
        $zip->finish();
        $psr7OutputStream->close();

        $tmpDir = $this->validateAndExtractZip($tmp);
        $files = $this->getRecursiveFileList($tmpDir);

        $this->assertSame(['sample.json'], $files);
        $this->assertStringEqualsFile($tmpDir . '/sample.json', $body);
    }

    public function testAddFileFromPsr7StreamWithFileSizeSet(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $body = 'Sample String Data';
        $fileSize = strlen($body);
        // Add fake padding
        $fakePadding = "\0\0\0\0\0\0";
        $response = new Response(200, [], $body . $fakePadding);

<<<<<<< HEAD
        $zip->addFileFromPsr7Stream(
            fileName: 'sample.json',
            stream: $response->getBody(),
            compressionMethod: CompressionMethod::STORE,
            maxSize: $fileSize
        );
=======
        $fileOptions = new FileOptions();
        $fileOptions->setMethod(Method::STORE());
        $fileOptions->setSize($fileSize);
        $zip->addFileFromPsr7Stream('sample.json', $response->getBody(), $fileOptions);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.json'], $files);
        $this->assertStringEqualsFile($tmpDir . '/sample.json', $body);
    }

<<<<<<< HEAD
    public function testCreateArchiveHeaders(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $headers = [];

        $httpHeaderCallback = function (string $header) use (&$headers) {
            $headers[] = $header;
        };

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: true,
            outputName: 'example.zip',
            httpHeaderCallback: $httpHeaderCallback,
        );

        $zip->addFile(
            fileName: 'sample.json',
            data: 'foo',
        );
        $zip->finish();
        fclose($stream);

        $this->assertContains('Content-Type: application/x-zip', $headers);
        $this->assertContains("Content-Disposition: attachment; filename*=UTF-8''example.zip", $headers);
        $this->assertContains('Pragma: public', $headers);
        $this->assertContains('Cache-Control: public, must-revalidate', $headers);
        $this->assertContains('Content-Transfer-Encoding: binary', $headers);
    }

=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    public function testCreateArchiveWithFlushOptionSet(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            flushOutput: true,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);
        $options->setFlushOutput(true);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $zip->addFile('sample.txt', 'Sample String Data');
        $zip->addFile('test/sample.txt', 'More Simple Sample Data');

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt', 'test' . DIRECTORY_SEPARATOR . 'sample.txt'], $files);

        $this->assertStringEqualsFile($tmpDir . '/sample.txt', 'Sample String Data');
        $this->assertStringEqualsFile($tmpDir . '/test/sample.txt', 'More Simple Sample Data');
    }

    public function testCreateArchiveWithOutputBufferingOffAndFlushOptionSet(): void
    {
        // WORKAROUND (1/2): remove phpunit's output buffer in order to run test without any buffering
        ob_end_flush();
        $this->assertSame(0, ob_get_level());

        [$tmp, $stream] = $this->getTmpFileStream();

<<<<<<< HEAD
        $zip = new ZipStream(
            outputStream: $stream,
            flushOutput: true,
            sendHttpHeaders: false,
        );
=======
        $options = new ArchiveOptions();
        $options->setOutputStream($stream);
        $options->setFlushOutput(true);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $zip->addFile('sample.txt', 'Sample String Data');

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);
        $this->assertStringEqualsFile($tmpDir . '/sample.txt', 'Sample String Data');

        // WORKAROUND (2/2): add back output buffering so that PHPUnit doesn't complain that it is missing
        ob_start();
    }

<<<<<<< HEAD
    public function testAddEmptyDirectory(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
        );

        $zip->addDirectory('foo');

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir, includeDirectories: true);

        $this->assertContains('foo', $files);

        $this->assertFileExists($tmpDir . DIRECTORY_SEPARATOR . 'foo');
        $this->assertDirectoryExists($tmpDir . DIRECTORY_SEPARATOR . 'foo');
    }

    public function testAddFileSimulate(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $create = function (OperationMode $operationMode) use ($stream): int {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                operationMode: $operationMode,
                defaultEnableZeroHeader: true,
                outputStream: $stream,
            );

            $zip->addFile('sample.txt', 'Sample String Data');
            $zip->addFile('test/sample.txt', 'More Simple Sample Data');

            return $zip->finish();
        };


        $sizeExpected = $create(OperationMode::NORMAL);
        $sizeActual = $create(OperationMode::SIMULATE_LAX);

        $this->assertEquals($sizeExpected, $sizeActual);
    }

    public function testAddFileSimulateWithMaxSize(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $create = function (OperationMode $operationMode) use ($stream): int {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                operationMode: $operationMode,
                defaultCompressionMethod: CompressionMethod::STORE,
                defaultEnableZeroHeader: true,
                outputStream: $stream,
            );

            $zip->addFile('sample.txt', 'Sample String Data', maxSize: 0);

            return $zip->finish();
        };


        $sizeExpected = $create(OperationMode::NORMAL);
        $sizeActual = $create(OperationMode::SIMULATE_LAX);

        $this->assertEquals($sizeExpected, $sizeActual);
    }

    public function testAddFileSimulateWithFstat(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $create = function (OperationMode $operationMode) use ($stream): int {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                operationMode: $operationMode,
                defaultCompressionMethod: CompressionMethod::STORE,
                defaultEnableZeroHeader: true,
                outputStream: $stream,
            );

            $zip->addFile('sample.txt', 'Sample String Data');
            $zip->addFile('test/sample.txt', 'More Simple Sample Data');

            return $zip->finish();
        };


        $sizeExpected = $create(OperationMode::NORMAL);
        $sizeActual = $create(OperationMode::SIMULATE_LAX);

        $this->assertEquals($sizeExpected, $sizeActual);
    }

    public function testAddFileSimulateWithExactSizeZero(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $create = function (OperationMode $operationMode) use ($stream): int {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                operationMode: $operationMode,
                defaultCompressionMethod: CompressionMethod::STORE,
                defaultEnableZeroHeader: true,
                outputStream: $stream,
            );

            $zip->addFile('sample.txt', 'Sample String Data', exactSize: 18);

            return $zip->finish();
        };


        $sizeExpected = $create(OperationMode::NORMAL);
        $sizeActual = $create(OperationMode::SIMULATE_LAX);

        $this->assertEquals($sizeExpected, $sizeActual);
    }

    public function testAddFileSimulateWithExactSizeInitial(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $create = function (OperationMode $operationMode) use ($stream): int {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                operationMode: $operationMode,
                defaultCompressionMethod: CompressionMethod::STORE,
                defaultEnableZeroHeader: false,
                outputStream: $stream,
            );

            $zip->addFile('sample.txt', 'Sample String Data', exactSize: 18);

            return $zip->finish();
        };

        $sizeExpected = $create(OperationMode::NORMAL);
        $sizeActual = $create(OperationMode::SIMULATE_LAX);

        $this->assertEquals($sizeExpected, $sizeActual);
    }

    public function testAddFileSimulateWithZeroSizeInFstat(): void
    {
        [, $stream] = $this->getTmpFileStream();

        $create = function (OperationMode $operationMode) use ($stream): int {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                operationMode: $operationMode,
                defaultCompressionMethod: CompressionMethod::STORE,
                defaultEnableZeroHeader: false,
                outputStream: $stream,
            );

            $zip->addFileFromPsr7Stream('sample.txt', new class () implements StreamInterface {
                public $pos = 0;

                public function __toString(): string
                {
                    return 'test';
                }

                public function close(): void
                {
                }

                public function detach()
                {
                }

                public function getSize(): ?int
                {
                    return null;
                }

                public function tell(): int
                {
                    return $this->pos;
                }

                public function eof(): bool
                {
                    return $this->pos >= 4;
                }

                public function isSeekable(): bool
                {
                    return true;
                }

                public function seek(int $offset, int $whence = SEEK_SET): void
                {
                    $this->pos = $offset;
                }

                public function rewind(): void
                {
                    $this->pos = 0;
                }

                public function isWritable(): bool
                {
                    return false;
                }

                public function write(string $string): int
                {
                    return 0;
                }

                public function isReadable(): bool
                {
                    return true;
                }

                public function read(int $length): string
                {
                    $data = substr('test', $this->pos, $length);
                    $this->pos += strlen($data);
                    return $data;
                }

                public function getContents(): string
                {
                    return $this->read(4);
                }

                public function getMetadata(?string $key = null)
                {
                    return $key !== null ? null : [];
                }
            });

            return $zip->finish();
        };

        $sizeExpected = $create(OperationMode::NORMAL);
        $sizeActual = $create(OperationMode::SIMULATE_LAX);


        $this->assertEquals($sizeExpected, $sizeActual);
    }

    public function testAddFileSimulateWithWrongExactSize(): void
    {
        $this->expectException(FileSizeIncorrectException::class);

        $zip = new ZipStream(
            sendHttpHeaders: false,
            operationMode: OperationMode::SIMULATE_LAX,
        );

        $zip->addFile('sample.txt', 'Sample String Data', exactSize: 1000);
    }

    public function testAddFileSimulateStrictZero(): void
    {
        $this->expectException(SimulationFileUnknownException::class);

        $zip = new ZipStream(
            sendHttpHeaders: false,
            operationMode: OperationMode::SIMULATE_STRICT,
            defaultEnableZeroHeader: true
        );

        $zip->addFile('sample.txt', 'Sample String Data');
    }

    public function testAddFileSimulateStrictInitial(): void
    {
        $this->expectException(SimulationFileUnknownException::class);

        $zip = new ZipStream(
            sendHttpHeaders: false,
            operationMode: OperationMode::SIMULATE_STRICT,
            defaultEnableZeroHeader: false
        );

        $zip->addFile('sample.txt', 'Sample String Data');
    }

    public function testAddFileCallbackStrict(): void
    {
        $this->expectException(SimulationFileUnknownException::class);

        $zip = new ZipStream(
            sendHttpHeaders: false,
            operationMode: OperationMode::SIMULATE_STRICT,
            defaultEnableZeroHeader: false
        );

        $zip->addFileFromCallback('sample.txt', callback: function () {
            return '';
        });
    }

    public function testAddFileCallbackLax(): void
    {

        $zip = new ZipStream(
            operationMode: OperationMode::SIMULATE_LAX,
            defaultEnableZeroHeader: false,
            sendHttpHeaders: false,
        );

        $zip->addFileFromCallback('sample.txt', callback: function () {
            return 'Sample String Data';
        });

        $size = $zip->finish();

        $this->assertEquals($size, 142);
    }

    public function testExecuteSimulation(): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            operationMode: OperationMode::SIMULATE_LAX,
            defaultEnableZeroHeader: false,
            sendHttpHeaders: false,
            outputStream: $stream,
        );

        $zip->addFileFromCallback(
            'sample.txt',
            exactSize: 18,
            callback: function () {
                return 'Sample String Data';
            }
        );

        $size = $zip->finish();

        $this->assertEquals(filesize($tmp), 0);

        $zip->executeSimulation();
        fclose($stream);

        clearstatcache();

        $this->assertEquals(filesize($tmp), $size);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt'], $files);
    }

    public function testExecuteSimulationBeforeFinish(): void
    {
        $this->expectException(RuntimeException::class);


        [, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            operationMode: OperationMode::SIMULATE_LAX,
            defaultEnableZeroHeader: false,
            sendHttpHeaders: false,
            outputStream: $stream,
        );

        $zip->executeSimulation();
    }

    private function addLargeFileFileFromPath(CompressionMethod $compressionMethod, $zeroHeader, $zip64): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $zip = new ZipStream(
            outputStream: $stream,
            sendHttpHeaders: false,
            defaultEnableZeroHeader: $zeroHeader,
            enableZip64: $zip64,
        );
=======
    /**
     * @return array
     */
    protected function getTmpFileStream(): array
    {
        $tmp = tempnam(sys_get_temp_dir(), 'zipstreamtest');
        $stream = fopen($tmp, 'wb+');

        return [$tmp, $stream];
    }

    /**
     * @param string $tmp
     * @return string
     */
    protected function validateAndExtractZip($tmp): string
    {
        $tmpDir = $this->getTmpDir();

        $zipArch = new ZipArchive();
        $res = $zipArch->open($tmp);

        if ($res !== true) {
            $this->fail("Failed to open {$tmp}. Code: $res");

            return $tmpDir;
        }

        $this->assertSame(0, $zipArch->status);
        $this->assertSame(0, $zipArch->statusSys);

        $zipArch->extractTo($tmpDir);
        $zipArch->close();

        return $tmpDir;
    }

    protected function getTmpDir(): string
    {
        $tmp = tempnam(sys_get_temp_dir(), 'zipstreamtest');
        unlink($tmp);
        mkdir($tmp) or $this->fail('Failed to make directory');

        return $tmp;
    }

    /**
     * @param string $path
     * @return string[]
     */
    protected function getRecursiveFileList(string $path): array
    {
        $data = [];
        $path = (string)realpath($path);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        $pathLen = strlen($path);
        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            if (!is_dir($filePath)) {
                $data[] = substr($filePath, $pathLen + 1);
            }
        }

        sort($data);

        return $data;
    }

    protected function addLargeFileFileFromPath($method, $zeroHeader, $zip64): void
    {
        [$tmp, $stream] = $this->getTmpFileStream();

        $options = new ArchiveOptions();
        $options->setOutputStream($stream);
        $options->setLargeFileMethod($method);
        $options->setLargeFileSize(5);
        $options->setZeroHeader($zeroHeader);
        $options->setEnableZip64($zip64);

        $zip = new ZipStream(null, $options);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        [$tmpExample, $streamExample] = $this->getTmpFileStream();
        for ($i = 0; $i <= 10000; $i++) {
            fwrite($streamExample, sha1((string)$i));
            if ($i % 100 === 0) {
                fwrite($streamExample, "\n");
            }
        }
        fclose($streamExample);
        $shaExample = sha1_file($tmpExample);
        $zip->addFileFromPath('sample.txt', $tmpExample);
        unlink($tmpExample);

        $zip->finish();
        fclose($stream);

        $tmpDir = $this->validateAndExtractZip($tmp);

        $files = $this->getRecursiveFileList($tmpDir);
        $this->assertSame(['sample.txt'], $files);

<<<<<<< HEAD
        $this->assertSame(sha1_file($tmpDir . '/sample.txt'), $shaExample, "SHA-1 Mismatch Method: {$compressionMethod->value}");
=======
        $this->assertSame(sha1_file($tmpDir . '/sample.txt'), $shaExample, "SHA-1 Mismatch Method: {$method}");
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }
}
