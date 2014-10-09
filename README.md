# Garoevans Php Enum [![Build Status](https://travis-ci.org/garoevans/php-enum.png)](https://travis-ci.org/garoevans/php-enum)

This gives us a convenient way to always have an Enum object available and
utilise Spl Types if available. It does kick up a bit of a fuss in some IDEs
as it sees two classes with the same name, but we know this isn't an issue as
the code is fine and dandy :)

We also wrap the SplEnum class to stop IDEs thinking that the constructor
parameters are necessary. Force it to act like the documentation says it should.

The replacement is so closely tied to the expected usage of the Spl Enum that
you could just use the http://php.net/manual/en/class.splenum.php documentation;

```php
use Garoevans\PhpEnum\Enum;

class Fruit extends Enum
{
    // If no value is given during object construction this value is used
    const __default = self::APPLE;
    // Our enum values
    const APPLE     = 1;
    const ORANGE    = 2;
}

$myApple  = new Fruit();
$myOrange = new Fruit(Fruit::ORANGE);
$fail     = 1;

function eat(Fruit $aFruit)
{
    if ($aFruit->is(Fruit::APPLE)) {
        echo "Eating an apple.\n";
    } else if ($aFruit->is(Fruit::ORANGE)) {
        echo "Eating an orange.\n";
    }
}

// Eating an apple.
eat($myApple);
// Eating an orange.
eat($myOrange);

// PHP Catchable fatal error:  Argument 1 passed to eat() must be an
// instance of Fruit, integer given
eat($fail);
```

Apart from normalizing the Spl Enum construct there are additions including a
shorthand way of instantiating via a static method named the same as the desired
constant. Using the ```Fruit``` class from above we can do the following;

```php
// Eating an apple.
eat(Fruit::APPLE());
```

Also, the ```constantExists()``` method is available for use;

```php
$fruit = new Fruit();
if ($fruit->constantExists("apple")) {
    echo "Apple is available.\n";
}
```
