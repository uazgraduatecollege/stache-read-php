# StacheReader for PHP

A simple PHP package for querying items stored in Stache

## Requirements

Use of StacheReader assumes [PHP ](https://php.net/) and [Composer](https://getcomposer.org/) in the environment.
StacheReader has been tested successfully with PHP versions 5.5.9+ and 7.0+

## Installation

### Direct installation from Git
1. Clone the git repository
2. Install dependencies

```sh
$ git clone <git-repo-url> <output-dir>
$ cd <output-dir>
$ composer install
```

### Installation as an Composer Package Dependency

At minimum, the following should be in to your `composer.json` file:
```json
{
    "require": {
        "uagradcoll/stache-reader": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@bitbucket.org:uazgraduatecollege/stache-reader.git"
        }
    ]
}
```

## Usage

StacheReader implements the following methods:

### StacheReader::read($params)

```php
// What you do here may depend on how you do autoloading.
// If installed w/Composer, this should be sufficient.
use Uagc\StacheReader;

$mySr = new StacheReader([
    'domain' => getenv('STACHE_TEST_DOMAIN')// 'som.domain.edu',
]);

try {
    $myStuff = $mySr->read(
        getenv('STACHE_TEST_ITEM'),// '12345',
        getenv('STACHE_TEST_ITEMKEY')// 'bd669ec9812ae89ada7cbf2920df895f7824545918dc14fc7c956b659d90a338'
    );

    print_r($myStuff);

} catch (Exception $e) {
    echo $e->getMessage();
}
```

### StacheR::fetch()

A Promise-based query. Not yet implemented.


## About

StacheReader for PHP is a port of [StacheRead JS](https://bitbucket.org/uazgraduatecollege/stacheread-js).


## License

Copyright (c) 2018 Arizona Board of Regents on behalf of the University of Arizona, all rights reserved


## Status

A work in-progress, may be `unstable`. Contributors welcome if you bring us a shrubbery.
