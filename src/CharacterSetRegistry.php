<?php

namespace Zete7\NumberLikeString;

/**
 * @author Stanislau Kviatkouski <7zete7@gmail.com>
 */
class CharacterSetRegistry
{
    /**
     * @var CharacterSet[]
     */
    private $characterSets;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var string[]
     */
    private $numberCharacterSet = array();

    /**
     * @var array<string, string[]>
     */
    private $byNumberCharacterMap = array();

    /**
     * @var string[]
     */
    private $numberLikeCharacterSet = array();

    /**
     * @var array<string, string[]>
     */
    private $byNumberLikeCharacterMap = array();

    /**
     * @param iterable<CharacterSet> $sets
     */
    public function __construct($sets = array())
    {
        $this->characterSets = $sets instanceof \Traversable ? iterator_to_array($sets, false) : $sets;
    }

    /**
     * @throws BadMethodCallException
     * @return void
     */
    public function addCharacterSet(CharacterSet $set)
    {
        if ($this->initialized) {
            throw new BadMethodCallException('Character registry already initialized');
        }

        $this->characterSets[] = $set;
    }

    /**
     * @param string|null $numberLikeCharacter
     * @return string[]
     */
    public function findNumberCharacters($numberLikeCharacter = null)
    {
        $this->initialize();

        if (null === $numberLikeCharacter) {
            return $this->numberCharacterSet;
        }

        if (isset($this->byNumberLikeCharacterMap[$numberLikeCharacter])) {
            return $this->byNumberLikeCharacterMap[$numberLikeCharacter];
        }

        return array();
    }

    /**
     * @param string|null $numberCharacter
     * @return string[]
     */
    public function findNumberLikeCharacters($numberCharacter = null)
    {
        $this->initialize();

        if (null === $numberCharacter) {
            return $this->numberLikeCharacterSet;
        }

        if (isset($this->byNumberCharacterMap[$numberCharacter])) {
            return $this->byNumberCharacterMap[$numberCharacter];
        }

        return array();
    }

    /**
     * @return void
     */
    protected function initialize()
    {
        if ($this->initialized) {
            return;
        }

        $this->initialized = true;

        $byNumberCharacterMap = array();
        $byNumberLikeCharacterMap = array();

        foreach ($this->characterSets as $characterSet) {
            $numberChar = $characterSet->getNumberChar();
            $numberLikeChars = $characterSet->getNumberLikeChars();

            if (!isset($byNumberCharacterMap[$numberChar])) {
                $byNumberCharacterMap[$numberChar] = array();
            }

            foreach ($numberLikeChars as $numberLikeChar) {
                if (!isset($byNumberLikeCharacterMap[$numberLikeChar])) {
                    $byNumberLikeCharacterMap[$numberLikeChar] = array();
                }

                $byNumberCharacterMap[$numberChar][] = $numberLikeChar;
                $byNumberLikeCharacterMap[$numberLikeChar][] = $numberChar;
            }
        }

        $this->numberCharacterSet = array_keys($byNumberCharacterMap);
        $this->byNumberCharacterMap = $byNumberCharacterMap;
        $this->numberLikeCharacterSet = array_keys($byNumberLikeCharacterMap);
        $this->byNumberLikeCharacterMap = $byNumberLikeCharacterMap;
    }
}
