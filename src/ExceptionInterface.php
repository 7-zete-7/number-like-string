<?php

namespace Zete7\NumberLikeString;

if (PHP_VERSION_ID >= 70000) {
    /**
     * @author Stanislau Kviatkouski <7zete7@gmail.com>
     */
    interface ExceptionInterface extends \Throwable
    {
    }
} else {
    /**
     * @author Stanislau Kviatkouski <7zete7@gmail.com>
     */
    interface ExceptionInterface
    {
    }
}
