<?php

namespace Zete7\NumberLikeString;

/**
 * @author Stanislau Kviatkouski <7zete7@gmail.com>
 */
class NumberLikeStringUtil
{
    /**
     * @var CharacterSetRegistry
     */
    private $registry;

    /**
     * @var array<string, string>
     */
    private $numberLikePatterns = array();

    public function __construct(CharacterSetRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isValidNumberString($value)
    {
        $pattern = $this->getNumberLikePattern();

        $result = !preg_match('~'.$pattern.'~', $value);

        if (PREG_NO_ERROR !== $pregErrorCode = preg_last_error()) {
            throw new RuntimeException(sprintf('Failed to validate number string: PREG %d', $pregErrorCode));
        }

        return $result;
    }

    /**
     * @param string $value
     * @return string
     */
    public function normalizeNumberString($value)
    {
        $result = $value;

        foreach ($this->registry->findNumberCharacters() as $numberCharacter) {
            if (null !== $pattern = $this->getNumberLikePattern($numberCharacter)) {
                $result = preg_replace('~'.$pattern.'~', $numberCharacter, $result);
            }
        }

        return $result;
    }

    /**
     * @param string|null $numberCharacter
     * @return string|null
     */
    protected function getNumberLikePattern($numberCharacter = null)
    {
        $key = null !== $numberCharacter ? $numberCharacter : '';

        if (isset($this->numberLikePatterns[$key]) || array_key_exists($key, $this->numberLikePatterns)) {
            return $this->numberLikePatterns[$key];
        }

        if ($numberLikeCharacters = $this->registry->findNumberLikeCharacters($numberCharacter)) {
            $pattern = implode('|', array_map(function ($c) { return preg_quote($c, '~'); }, $numberLikeCharacters));
        } else {
            $pattern = null;
        }

        $this->numberLikePatterns[$key] = $pattern;

        return $pattern;
    }
}
