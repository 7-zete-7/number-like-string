# Number like string

## Installation

```shell
composer require 7-zete-7/number-like-string
```

## Usage

### Number string validation

```php
use Zete7\NumberLikeString\NumberLikeStringFactory;

$util = NumberLikeStringFactory::createUtil();
$util->isValidNumberString('1069'); // => true
```

### Number string normalizing

```php

use Zete7\NumberLikeString\NumberLikeStringFactory;

$util = NumberLikeStringFactory::createUtil();
$util->normalizeNumberString('3Յ75'); // => "3375"
```
