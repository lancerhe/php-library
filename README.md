PHP Library
============

[![Latest Stable Version](https://poser.pugx.org/lancerhe/php-library/v/stable)](https://packagist.org/packages/lancerhe/php-library) [![Total Downloads](https://poser.pugx.org/lancerhe/php-library/downloads)](https://packagist.org/packages/lancerhe/php-library) [![Latest Unstable Version](https://poser.pugx.org/lancerhe/php-library/v/unstable)](https://packagist.org/packages/lancerhe/php-library) [![License](https://poser.pugx.org/lancerhe/php-library/license)](https://packagist.org/packages/lancerhe/php-library)

Http request and parse decorator (Easy to expand).

Requirements
------------

**PHP5.4.0 or later**

Installation
------------

Create or modify your composer.json

``` json
{
    "require": {
        "lancerhe/php-library": "1.1.0"
    }
}
```

And run

``` sh
$ php composer.phar install
```

Introduction
-----

Util Class:

```
\LancerHe\Library\Util\Client
\LancerHe\Library\Util\Cookie
\LancerHe\Library\Util\Form
\LancerHe\Library\Util\IArray
\LancerHe\Library\Util\Log
\LancerHe\Library\Util\Page
\LancerHe\Library\Util\Session
\LancerHe\Library\Util\ShutdownEvent
\LancerHe\Library\Util\String
\LancerHe\Library\Util\Timer
\LancerHe\Library\Util\Validate
```

Location Class:
```
\LancerHe\Library\Location\Area
```

Convert Class:
```
\LancerHe\Library\Convert\Spell
\LancerHe\Library\Convert\Big2gb
```

Algorithm Class:
```
\LancerHe\Library\Algorithm\Unique
\LancerHe\Library\Algorithm\Partition
```

Crypt Class see: <https://github.com/lancerhe/php-crypt>

Http Class see: <https://github.com/lancerhe/php-http>