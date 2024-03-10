<?php

namespace Zete7\NumberLikeString;

/**
 * @author Stanislau Kviatkouski <7zete7@gmail.com>
 */
final class CharacterSet
{
    /**
     * @var string
     */
    private $numberChar;

    /**
     * @var string[]
     */
    private $numberLikeChars;

    /**
     * @param string $numberChar
     * @param string[] $numberLikeChars
     */
    public function __construct($numberChar, array $numberLikeChars)
    {
        $this->numberChar = $numberChar;
        $this->numberLikeChars = $numberLikeChars;
    }

    /**
     * @return string
     */
    public function getNumberChar()
    {
        return $this->numberChar;
    }

    /**
     * @return string[]
     */
    public function getNumberLikeChars()
    {
        return $this->numberLikeChars;
    }
}
