<?php

declare(strict_types=1);

namespace ZipStream;

<<<<<<< HEAD
use Closure;
use DateTimeInterface;
use DeflateContext;
use RuntimeException;
use ZipStream\Exception\FileSizeIncorrectException;
use ZipStream\Exception\OverflowException;
use ZipStream\Exception\ResourceActionException;
use ZipStream\Exception\SimulationFileUnknownException;
use ZipStream\Exception\StreamNotReadableException;
use ZipStream\Exception\StreamNotSeekableException;

/**
 * @internal
 */
class File
{
    private const CHUNKED_READ_BLOCK_SIZE = 0x1000000;

    private Version $version;

    private int $compressedSize = 0;

    private int $uncompressedSize = 0;

    private int $crc = 0;

    private int $generalPurposeBitFlag = 0;

    private readonly string $fileName;

    /**
     * @var resource|null
     */
    private $stream;

    /**
     * @param Closure $dataCallback
     * @psalm-param Closure(): resource $dataCallback
     */
    public function __construct(
        string $fileName,
        private readonly Closure $dataCallback,
        private readonly OperationMode $operationMode,
        private readonly int $startOffset,
        private readonly CompressionMethod $compressionMethod,
        private readonly string $comment,
        private readonly DateTimeInterface $lastModificationDateTime,
        private readonly int $deflateLevel,
        private readonly ?int $maxSize,
        private readonly ?int $exactSize,
        private readonly bool $enableZip64,
        private readonly bool $enableZeroHeader,
        private readonly Closure $send,
        private readonly Closure $recordSentBytes,
    ) {
        $this->fileName = self::filterFilename($fileName);
        $this->checkEncoding();

        if ($this->enableZeroHeader) {
            $this->generalPurposeBitFlag |= GeneralPurposeBitFlag::ZERO_HEADER;
        }

        $this->version = $this->compressionMethod === CompressionMethod::DEFLATE ? Version::DEFLATE : Version::STORE;
    }

    public function cloneSimulationExecution(): self
    {
        return new self(
            $this->fileName,
            $this->dataCallback,
            OperationMode::NORMAL,
            $this->startOffset,
            $this->compressionMethod,
            $this->comment,
            $this->lastModificationDateTime,
            $this->deflateLevel,
            $this->maxSize,
            $this->exactSize,
            $this->enableZip64,
            $this->enableZeroHeader,
            $this->send,
            $this->recordSentBytes,
        );
    }

    public function process(): string
    {
        $forecastSize = $this->forecastSize();

        if ($this->enableZeroHeader) {
            // No calculation required
        } elseif ($this->isSimulation() && $forecastSize) {
            $this->uncompressedSize = $forecastSize;
            $this->compressedSize = $forecastSize;
        } else {
            $this->readStream(send: false);
            if (rewind($this->unpackStream()) === false) {
                throw new ResourceActionException('rewind', $this->unpackStream());
            }
        }

        $this->addFileHeader();

        $detectedSize = $forecastSize ?? $this->compressedSize;

        if (
            $this->isSimulation() &&
            $detectedSize > 0
        ) {
            ($this->recordSentBytes)($detectedSize);
        } else {
            $this->readStream(send: true);
        }

        $this->addFileFooter();
        return $this->getCdrFile();
    }

    /**
     * @return resource
     */
    private function unpackStream()
    {
        if ($this->stream) {
            return $this->stream;
        }

        if ($this->operationMode === OperationMode::SIMULATE_STRICT) {
            throw new SimulationFileUnknownException();
        }

        $this->stream = ($this->dataCallback)();

        if (!$this->enableZeroHeader && !stream_get_meta_data($this->stream)['seekable']) {
            throw new StreamNotSeekableException();
        }
        if (!(
            str_contains(stream_get_meta_data($this->stream)['mode'], 'r')
            || str_contains(stream_get_meta_data($this->stream)['mode'], 'w+')
            || str_contains(stream_get_meta_data($this->stream)['mode'], 'a+')
            || str_contains(stream_get_meta_data($this->stream)['mode'], 'x+')
            || str_contains(stream_get_meta_data($this->stream)['mode'], 'c+')
        )) {
            throw new StreamNotReadableException();
        }

        return $this->stream;
    }

    private function forecastSize(): ?int
    {
        if ($this->compressionMethod !== CompressionMethod::STORE) {
            return null;
        }
        if ($this->exactSize) {
            return $this->exactSize;
        }
        $fstat = fstat($this->unpackStream());
        if (!$fstat || !array_key_exists('size', $fstat) || $fstat['size'] < 1) {
            return null;
        }

        if ($this->maxSize !== null && $this->maxSize < $fstat['size']) {
            return $this->maxSize;
        }

        return $fstat['size'];
=======
use HashContext;
use Psr\Http\Message\StreamInterface;
use ZipStream\Exception\FileNotFoundException;
use ZipStream\Exception\FileNotReadableException;
use ZipStream\Exception\OverflowException;
use ZipStream\Option\File as FileOptions;
use ZipStream\Option\Method;
use ZipStream\Option\Version;

class File
{
    public const HASH_ALGORITHM = 'crc32b';

    public const BIT_ZERO_HEADER = 0x0008;

    public const BIT_EFS_UTF8 = 0x0800;

    public const COMPUTE = 1;

    public const SEND = 2;

    private const CHUNKED_READ_BLOCK_SIZE = 1048576;

    /**
     * @var string
     */
    public $name;

    /**
     * @var FileOptions
     */
    public $opt;

    /**
     * @var Bigint
     */
    public $len;

    /**
     * @var Bigint
     */
    public $zlen;

    /** @var  int */
    public $crc;

    /**
     * @var Bigint
     */
    public $hlen;

    /**
     * @var Bigint
     */
    public $ofs;

    /**
     * @var int
     */
    public $bits;

    /**
     * @var Version
     */
    public $version;

    /**
     * @var ZipStream
     */
    public $zip;

    /**
     * @var resource
     */
    private $deflate;

    /**
     * @var HashContext
     */
    private $hash;

    /**
     * @var Method
     */
    private $method;

    /**
     * @var Bigint
     */
    private $totalLength;

    public function __construct(ZipStream $zip, string $name, ?FileOptions $opt = null)
    {
        $this->zip = $zip;

        $this->name = $name;
        $this->opt = $opt ?: new FileOptions();
        $this->method = $this->opt->getMethod();
        $this->version = Version::STORE();
        $this->ofs = new Bigint();
    }

    public function processPath(string $path): void
    {
        if (!is_readable($path)) {
            if (!file_exists($path)) {
                throw new FileNotFoundException($path);
            }
            throw new FileNotReadableException($path);
        }
        if ($this->zip->isLargeFile($path) === false) {
            $data = file_get_contents($path);
            $this->processData($data);
        } else {
            $this->method = $this->zip->opt->getLargeFileMethod();

            $stream = new Stream(fopen($path, 'rb'));
            $this->processStream($stream);
            $stream->close();
        }
    }

    public function processData(string $data): void
    {
        $this->len = new Bigint(strlen($data));
        $this->crc = crc32($data);

        // compress data if needed
        if ($this->method->equals(Method::DEFLATE())) {
            $data = gzdeflate($data);
        }

        $this->zlen = new Bigint(strlen($data));
        $this->addFileHeader();
        $this->zip->send($data);
        $this->addFileFooter();
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }

    /**
     * Create and send zip header for this file.
<<<<<<< HEAD
     */
    private function addFileHeader(): void
    {
        $forceEnableZip64 = $this->enableZeroHeader && $this->enableZip64;

        $footer = $this->buildZip64ExtraBlock($forceEnableZip64);

        $zip64Enabled = $footer !== '';

        if($zip64Enabled) {
            $this->version = Version::ZIP64;
        }

        if ($this->generalPurposeBitFlag & GeneralPurposeBitFlag::EFS) {
            // Put the tricky entry to
            // force Linux unzip to lookup EFS flag.
            $footer .= Zs\ExtendedInformationExtraField::generate();
        }

        $data = LocalFileHeader::generate(
            versionNeededToExtract: $this->version->value,
            generalPurposeBitFlag: $this->generalPurposeBitFlag,
            compressionMethod: $this->compressionMethod,
            lastModificationDateTime: $this->lastModificationDateTime,
            crc32UncompressedData: $this->crc,
            compressedSize: $zip64Enabled
                ? 0xFFFFFFFF
                : $this->compressedSize,
            uncompressedSize: $zip64Enabled
                ? 0xFFFFFFFF
                : $this->uncompressedSize,
            fileName: $this->fileName,
            extraField: $footer,
        );


        ($this->send)($data);
=======
     *
     * @return void
     * @throws \ZipStream\Exception\EncodingException
     */
    public function addFileHeader(): void
    {
        $name = static::filterFilename($this->name);

        // calculate name length
        $nameLength = strlen($name);

        // create dos timestamp
        $time = static::dosTime($this->opt->getTime()->getTimestamp());

        $comment = $this->opt->getComment();

        if (!mb_check_encoding($name, 'ASCII') ||
            !mb_check_encoding($comment, 'ASCII')) {
            // Sets Bit 11: Language encoding flag (EFS).  If this bit is set,
            // the filename and comment fields for this file
            // MUST be encoded using UTF-8. (see APPENDIX D)
            if (mb_check_encoding($name, 'UTF-8') &&
                mb_check_encoding($comment, 'UTF-8')) {
                $this->bits |= self::BIT_EFS_UTF8;
            }
        }

        if ($this->method->equals(Method::DEFLATE())) {
            $this->version = Version::DEFLATE();
        }

        $force = (bool)($this->bits & self::BIT_ZERO_HEADER) &&
            $this->zip->opt->isEnableZip64();

        $footer = $this->buildZip64ExtraBlock($force);

        // If this file will start over 4GB limit in ZIP file,
        // CDR record will have to use Zip64 extension to describe offset
        // to keep consistency we use the same value here
        if ($this->zip->ofs->isOver32()) {
            $this->version = Version::ZIP64();
        }

        $fields = [
            ['V', ZipStream::FILE_HEADER_SIGNATURE],
            ['v', $this->version->getValue()],      // Version needed to Extract
            ['v', $this->bits],                     // General purpose bit flags - data descriptor flag set
            ['v', $this->method->getValue()],       // Compression method
            ['V', $time],                           // Timestamp (DOS Format)
            ['V', $this->crc],                      // CRC32 of data (0 -> moved to data descriptor footer)
            ['V', $this->zlen->getLowFF($force)],   // Length of compressed data (forced to 0xFFFFFFFF for zero header)
            ['V', $this->len->getLowFF($force)],    // Length of original data (forced to 0xFFFFFFFF for zero header)
            ['v', $nameLength],                     // Length of filename
            ['v', strlen($footer)],                 // Extra data (see above)
        ];

        // pack fields and calculate "total" length
        $header = ZipStream::packFields($fields);

        // print header and filename
        $data = $header . $name . $footer;
        $this->zip->send($data);

        // save header length
        $this->hlen = Bigint::init(strlen($data));
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }

    /**
     * Strip characters that are not legal in Windows filenames
     * to prevent compatibility issues
<<<<<<< HEAD
     */
    private static function filterFilename(
        /**
         * Unprocessed filename
         */
        string $fileName
    ): string {
        // strip leading slashes from file name
        // (fixes bug in windows archive viewer)
        $fileName = ltrim($fileName, '/');

        return str_replace(['\\', ':', '*', '?', '"', '<', '>', '|'], '_', $fileName);
    }

    private function checkEncoding(): void
    {
        // Sets Bit 11: Language encoding flag (EFS).  If this bit is set,
        // the filename and comment fields for this file
        // MUST be encoded using UTF-8. (see APPENDIX D)
        if (mb_check_encoding($this->fileName, 'UTF-8') &&
                mb_check_encoding($this->comment, 'UTF-8')) {
            $this->generalPurposeBitFlag |= GeneralPurposeBitFlag::EFS;
        }
    }

    private function buildZip64ExtraBlock(bool $force = false): string
    {
        $outputZip64ExtraBlock = false;

        $originalSize = null;
        if ($force || $this->uncompressedSize > 0xFFFFFFFF) {
            $outputZip64ExtraBlock = true;
            $originalSize = $this->uncompressedSize;
        }

        $compressedSize = null;
        if ($force || $this->compressedSize > 0xFFFFFFFF) {
            $outputZip64ExtraBlock = true;
            $compressedSize = $this->compressedSize;
        }

        // If this file will start over 4GB limit in ZIP file,
        // CDR record will have to use Zip64 extension to describe offset
        // to keep consistency we use the same value here
        $relativeHeaderOffset = null;
        if ($this->startOffset > 0xFFFFFFFF) {
            $outputZip64ExtraBlock = true;
            $relativeHeaderOffset = $this->startOffset;
        }

        if (!$outputZip64ExtraBlock) {
            return '';
        }

        if (!$this->enableZip64) {
            throw new OverflowException();
        }

        return Zip64\ExtendedInformationExtraField::generate(
            originalSize: $originalSize,
            compressedSize: $compressedSize,
            relativeHeaderOffset: $relativeHeaderOffset,
            diskStartNumber: null,
        );
    }

    private function addFileFooter(): void
    {
        if (($this->compressedSize > 0xFFFFFFFF || $this->uncompressedSize > 0xFFFFFFFF) && $this->version !== Version::ZIP64) {
            throw new OverflowException();
        }

        if (!$this->enableZeroHeader) {
            return;
        }

        if ($this->version === Version::ZIP64) {
            $footer = Zip64\DataDescriptor::generate(
                crc32UncompressedData: $this->crc,
                compressedSize: $this->compressedSize,
                uncompressedSize: $this->uncompressedSize,
            );
        } else {
            $footer = DataDescriptor::generate(
                crc32UncompressedData: $this->crc,
                compressedSize: $this->compressedSize,
                uncompressedSize: $this->uncompressedSize,
            );
        }

        ($this->send)($footer);
    }

    private function readStream(bool $send): void
    {
        $this->compressedSize = 0;
        $this->uncompressedSize = 0;
        $hash = hash_init('crc32b');

        $deflate = $this->compressionInit();

        while (
            !feof($this->unpackStream()) &&
            ($this->maxSize === null || $this->uncompressedSize < $this->maxSize) &&
            ($this->exactSize === null || $this->uncompressedSize < $this->exactSize)
        ) {
            $readLength = min(
                ($this->maxSize ?? PHP_INT_MAX) - $this->uncompressedSize,
                ($this->exactSize ?? PHP_INT_MAX) - $this->uncompressedSize,
                self::CHUNKED_READ_BLOCK_SIZE
            );

            $data = fread($this->unpackStream(), $readLength);

            hash_update($hash, $data);

            $this->uncompressedSize += strlen($data);

            if ($deflate) {
                $data =  deflate_add(
                    $deflate,
                    $data,
                    feof($this->unpackStream()) ? ZLIB_FINISH : ZLIB_NO_FLUSH
                );
            }

            $this->compressedSize += strlen($data);

            if ($send) {
                ($this->send)($data);
            }
        }

        if ($this->exactSize && $this->uncompressedSize !== $this->exactSize) {
            throw new FileSizeIncorrectException(expectedSize: $this->exactSize, actualSize: $this->uncompressedSize);
        }

        $this->crc = hexdec(hash_final($hash));
    }

    private function compressionInit(): ?DeflateContext
    {
        switch($this->compressionMethod) {
            case CompressionMethod::STORE:
                // Noting to do
                return null;
            case CompressionMethod::DEFLATE:
                $deflateContext = deflate_init(
                    ZLIB_ENCODING_RAW,
                    ['level' => $this->deflateLevel]
                );

                if (!$deflateContext) {
                    // @codeCoverageIgnoreStart
                    throw new RuntimeException("Can't initialize deflate context.");
                    // @codeCoverageIgnoreEnd
                }

                // False positive, resource is no longer returned from this function
                return $deflateContext;
            default:
                // @codeCoverageIgnoreStart
                throw new RuntimeException('Unsupported Compression Method ' . print_r($this->compressionMethod, true));
                // @codeCoverageIgnoreEnd
        }
    }

    private function getCdrFile(): string
    {
        $footer = $this->buildZip64ExtraBlock();

        return CentralDirectoryFileHeader::generate(
            versionMadeBy: ZipStream::ZIP_VERSION_MADE_BY,
            versionNeededToExtract:$this->version->value,
            generalPurposeBitFlag: $this->generalPurposeBitFlag,
            compressionMethod: $this->compressionMethod,
            lastModificationDateTime: $this->lastModificationDateTime,
            crc32: $this->crc,
            compressedSize: $this->compressedSize > 0xFFFFFFFF
                ? 0xFFFFFFFF
                : $this->compressedSize,
            uncompressedSize: $this->uncompressedSize > 0xFFFFFFFF
                ? 0xFFFFFFFF
                : $this->uncompressedSize,
            fileName: $this->fileName,
            extraField: $footer,
            fileComment: $this->comment,
            diskNumberStart: 0,
            internalFileAttributes: 0,
            externalFileAttributes: 32,
            relativeOffsetOfLocalHeader: $this->startOffset > 0xFFFFFFFF
                ? 0xFFFFFFFF
                : $this->startOffset,
        );
    }

    private function isSimulation(): bool
    {
        return $this->operationMode === OperationMode::SIMULATE_LAX || $this->operationMode === OperationMode::SIMULATE_STRICT;
=======
     *
     * @param string $filename Unprocessed filename
     * @return string
     */
    public static function filterFilename(string $filename): string
    {
        // strip leading slashes from file name
        // (fixes bug in windows archive viewer)
        $filename = preg_replace('/^\\/+/', '', $filename);

        return str_replace(['\\', ':', '*', '?', '"', '<', '>', '|'], '_', $filename);
    }

    /**
     * Create and send data descriptor footer for this file.
     *
     * @return void
     */
    public function addFileFooter(): void
    {
        if ($this->bits & self::BIT_ZERO_HEADER) {
            // compressed and uncompressed size
            $sizeFormat = 'V';
            if ($this->zip->opt->isEnableZip64()) {
                $sizeFormat = 'P';
            }
            $fields = [
                ['V', ZipStream::DATA_DESCRIPTOR_SIGNATURE],
                ['V', $this->crc],              // CRC32
                [$sizeFormat, $this->zlen],     // Length of compressed data
                [$sizeFormat, $this->len],      // Length of original data
            ];

            $footer = ZipStream::packFields($fields);
            $this->zip->send($footer);
        } else {
            $footer = '';
        }
        $this->totalLength = $this->hlen->add($this->zlen)->add(Bigint::init(strlen($footer)));
        $this->zip->addToCdr($this);
    }

    public function processStream(StreamInterface $stream): void
    {
        $this->zlen = new Bigint();
        $this->len = new Bigint();

        if ($this->zip->opt->isZeroHeader()) {
            $this->processStreamWithZeroHeader($stream);
        } else {
            $this->processStreamWithComputedHeader($stream);
        }
    }

    /**
     * Send CDR record for specified file.
     *
     * @return string
     */
    public function getCdrFile(): string
    {
        $name = static::filterFilename($this->name);

        // get attributes
        $comment = $this->opt->getComment();

        // get dos timestamp
        $time = static::dosTime($this->opt->getTime()->getTimestamp());

        $footer = $this->buildZip64ExtraBlock();

        $fields = [
            ['V', ZipStream::CDR_FILE_SIGNATURE],   // Central file header signature
            ['v', ZipStream::ZIP_VERSION_MADE_BY],  // Made by version
            ['v', $this->version->getValue()],      // Extract by version
            ['v', $this->bits],                     // General purpose bit flags - data descriptor flag set
            ['v', $this->method->getValue()],       // Compression method
            ['V', $time],                           // Timestamp (DOS Format)
            ['V', $this->crc],                      // CRC32
            ['V', $this->zlen->getLowFF()],         // Compressed Data Length
            ['V', $this->len->getLowFF()],          // Original Data Length
            ['v', strlen($name)],                   // Length of filename
            ['v', strlen($footer)],                 // Extra data len (see above)
            ['v', strlen($comment)],                // Length of comment
            ['v', 0],                               // Disk number
            ['v', 0],                               // Internal File Attributes
            ['V', 32],                              // External File Attributes
            ['V', $this->ofs->getLowFF()],           // Relative offset of local header
        ];

        // pack fields, then append name and comment
        $header = ZipStream::packFields($fields);

        return $header . $name . $footer . $comment;
    }

    /**
     * @return Bigint
     */
    public function getTotalLength(): Bigint
    {
        return $this->totalLength;
    }

    /**
     * Convert a UNIX timestamp to a DOS timestamp.
     *
     * @param int $when
     * @return int DOS Timestamp
     */
    final protected static function dosTime(int $when): int
    {
        // get date array for timestamp
        $d = getdate($when);

        // set lower-bound on dates
        if ($d['year'] < 1980) {
            $d = [
                'year' => 1980,
                'mon' => 1,
                'mday' => 1,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
            ];
        }

        // remove extra years from 1980
        $d['year'] -= 1980;

        // return date string
        return
            ($d['year'] << 25) |
            ($d['mon'] << 21) |
            ($d['mday'] << 16) |
            ($d['hours'] << 11) |
            ($d['minutes'] << 5) |
            ($d['seconds'] >> 1);
    }

    protected function buildZip64ExtraBlock(bool $force = false): string
    {
        $fields = [];
        if ($this->len->isOver32($force)) {
            $fields[] = ['P', $this->len];          // Length of original data
        }

        if ($this->len->isOver32($force)) {
            $fields[] = ['P', $this->zlen];         // Length of compressed data
        }

        if ($this->ofs->isOver32()) {
            $fields[] = ['P', $this->ofs];          // Offset of local header record
        }

        if (!empty($fields)) {
            if (!$this->zip->opt->isEnableZip64()) {
                throw new OverflowException();
            }

            array_unshift(
                $fields,
                ['v', 0x0001],                      // 64 bit extension
                ['v', count($fields) * 8]             // Length of data block
            );
            $this->version = Version::ZIP64();
        }

        if ($this->bits & self::BIT_EFS_UTF8) {
            // Put the tricky entry to
            // force Linux unzip to lookup EFS flag.
            $fields[] = ['v', 0x5653];  // Choose 'ZS' for proprietary usage
            $fields[] = ['v', 0x0000];  // zero length
        }

        return ZipStream::packFields($fields);
    }

    protected function processStreamWithZeroHeader(StreamInterface $stream): void
    {
        $this->bits |= self::BIT_ZERO_HEADER;
        $this->addFileHeader();
        $this->readStream($stream, self::COMPUTE | self::SEND);
        $this->addFileFooter();
    }

    protected function readStream(StreamInterface $stream, ?int $options = null): void
    {
        $this->deflateInit();
        $total = 0;
        $size = $this->opt->getSize();
        while (!$stream->eof() && ($size === 0 || $total < $size)) {
            $data = $stream->read(self::CHUNKED_READ_BLOCK_SIZE);
            $total += strlen($data);
            if ($size > 0 && $total > $size) {
                $data = substr($data, 0, strlen($data)-($total - $size));
            }
            $this->deflateData($stream, $data, $options);
            if ($options & self::SEND) {
                $this->zip->send($data);
            }
        }
        $this->deflateFinish($options);
    }

    protected function deflateInit(): void
    {
        $hash = hash_init(self::HASH_ALGORITHM);
        $this->hash = $hash;
        if ($this->method->equals(Method::DEFLATE())) {
            $this->deflate = deflate_init(
                ZLIB_ENCODING_RAW,
                ['level' => $this->opt->getDeflateLevel()]
            );
        }
    }

    protected function deflateData(StreamInterface $stream, string &$data, ?int $options = null): void
    {
        if ($options & self::COMPUTE) {
            $this->len = $this->len->add(Bigint::init(strlen($data)));
            hash_update($this->hash, $data);
        }
        if ($this->deflate) {
            $data = deflate_add(
                $this->deflate,
                $data,
                $stream->eof()
                    ? ZLIB_FINISH
                    : ZLIB_NO_FLUSH
            );
        }
        if ($options & self::COMPUTE) {
            $this->zlen = $this->zlen->add(Bigint::init(strlen($data)));
        }
    }

    protected function deflateFinish(?int $options = null): void
    {
        if ($options & self::COMPUTE) {
            $this->crc = hexdec(hash_final($this->hash));
        }
    }

    protected function processStreamWithComputedHeader(StreamInterface $stream): void
    {
        $this->readStream($stream, self::COMPUTE);
        $stream->rewind();

        $this->addFileHeader();
        $this->readStream($stream, self::SEND);
        $this->addFileFooter();
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    }
}
