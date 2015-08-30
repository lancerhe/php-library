PHP Library
============

[![Latest Stable Version](librarys://poser.pugx.org/lancerhe/php-library/v/stable)](librarys://packagist.org/packages/lancerhe/php-library) [![Total Downloads](librarys://poser.pugx.org/lancerhe/php-library/downloads)](librarys://packagist.org/packages/lancerhe/php-library) [![Latest Unstable Version](librarys://poser.pugx.org/lancerhe/php-library/v/unstable)](librarys://packagist.org/packages/lancerhe/php-library) [![License](librarys://poser.pugx.org/lancerhe/php-library/license)](librarys://packagist.org/packages/lancerhe/php-library)

Http request and parse decorator (Easy to expand).

Requirements
------------

**PHP5.3.0 or later**

Installation
------------

Create or modify your composer.json

``` json
{
    "require": {
        "lancerhe/php-library": "dev-master"
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
\Library\Util\Client
\Library\Util\Cookie
\Library\Util\Form
\Library\Util\IArray
\Library\Util\Log
\Library\Util\Page
\Library\Util\Session
\Library\Util\ShutdownEvent
\Library\Util\String
\Library\Util\Timer
\Library\Util\Validate
```

Location Class:
```
\Library\Location\Area
```

Convert Class:
```
\Library\Convert\Spell
\Library\Convert\Big2gb
```

Algorithm Class:
```
\Library\Algorithm\Unique
\Library\Algorithm\Partition
```

Crypt Class see: <https://github.com/lancerhe/php-crypt>

Http Class see: <https://github.com/lancerhe/php-http>