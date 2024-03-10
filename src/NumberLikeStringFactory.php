<?php

namespace Zete7\NumberLikeString;

/**
 * @author Stanislau Kviatkouski <7zete7@gmail.com>
 */
class NumberLikeStringFactory
{
    /**
     * @return string[]
     */
    public static function getDefaultConfigFiles()
    {
        $configDir = dirname(__DIR__).'/resources/configs';

        return array(
            $configDir.'/digit_0.php',
            $configDir.'/digit_1.php',
            $configDir.'/digit_2.php',
            $configDir.'/digit_3.php',
            $configDir.'/digit_5.php',
            $configDir.'/digit_6.php',
            $configDir.'/digit_7.php',
        );
    }

    /**
     * @param string[]|null $configFiles
     * @throws RuntimeException
     * @return CharacterSetRegistry
     */
    public static function createRegistry(array $configFiles = null)
    {
        if (null === $configFiles) {
            $configFiles = self::getDefaultConfigFiles();
        }

        /** @var CharacterSet[] $characterSets */
        $characterSets = array();

        foreach ($configFiles as $configFile) {
            if (!file_exists($configFile)) {
                throw new RuntimeException(sprintf('Configuration file %s does not exist', $configFile));
            }
            if (!is_file($configFile)) {
                throw new RuntimeException(sprintf('Configuration file %s is not a file', $configFile));
            }
            if (!is_readable($configFile)) {
                throw new RuntimeException(sprintf('Configuration file %s is not readable', $configFile));
            }

            $characterSets[] = require $configFile;
        }

        return new CharacterSetRegistry($characterSets);
    }

    /**
     * @param string[]|null $configFiles
     *
     * @return NumberLikeStringUtil
     * @throws RuntimeException
     */
    public static function createUtil(array $configFiles = null)
    {
        $registry = static::createRegistry($configFiles);

        return new NumberLikeStringUtil($registry);
    }
}
