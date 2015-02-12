Picnik
======

[![](https://api.travis-ci.org/alanly/picnik.svg)](https://travis-ci.org/alanly/picnik)

Picnik is a simple PHP client for the [Wordnik API](http://developer.wordnik.com/),
that is Composer and PSR-4 compatible.

Its only dependencies are the GuzzleHttp client and PHP >= 5.4.

API Coverage
------------

The initial goal is to support the `word` selection of methods.

Currently, the `/word.json/{word}` and `/word.json/{word}/definitions` API
methods are implemented.

Usage
-----

In order to use the client, you will first need to obtain an API key from 
[Wordnik](http://developer.wordnik.com/).

The client is pretty simple to use,

```php
$client = new Picnik\Client;
$client->setApiKey('foobar');

$definitions = $client->wordDefinitions('cat')
                      ->limit(1)
                      ->includeRelated(false)
                      ->useCanonical(true)
                      ->get();

var_dump( count($definitions) );
// int(1)

var_dump( $definitions[0]->text )
// string(189) "A small carnivorous mammal (Felis catus or F. domesticus)
// domesticated since early times as a catcher of rats and mice and as a pet
// and existing in several distinctive breeds and varieties."
```

License
------

This library is released under the MIT license. For details, you can refer to the [full license](LICENSE.md) document.