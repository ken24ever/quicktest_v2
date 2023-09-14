<?php

namespace PhpOffice\PhpSpreadsheet\RichText;

class TextElement implements ITextElement
{
    /**
     * Text.
     *
     * @var string
     */
    private $text;

    /**
     * Create a new TextElement instance.
     *
     * @param string $text Text
     */
    public function __construct($text = '')
    {
        // Initialise variables
        $this->text = $text;
    }

    /**
     * Get text.
     *
     * @return string Text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text.
     *
     * @param string $text Text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
<<<<<<< HEAD
     * Get font. For this class, the return value is always null.
=======
     * Get font.
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
     *
     * @return null|\PhpOffice\PhpSpreadsheet\Style\Font
     */
    public function getFont()
    {
        return null;
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode()
    {
        return md5(
            $this->text .
            __CLASS__
        );
    }
}
