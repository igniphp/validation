# ![Igni logo](https://github.com/igniphp/common/blob/master/logo/full.svg)![Build Status](https://travis-ci.org/igniphp/validation.svg?branch=master)

## Igni Validation
Licensed under MIT License.

**Igni** validation is simple, lightweight and extensible validation library.

## Installation

```
composer install igniphp/validation
```

## Introduction

### Basic example

```php
<?php

use Igni\Validation\Assertion;

$numberValidator = Assertion::number($min = 0);

$numberValidator->validate(1);// true
$numberValidator->validate(-1);// false
$numberValidator->validate(1.0);// true
$numberValidator->validate('a'); // false
```

### Getting error information

Allows to validate complex arrays 

```php
<?php

use Igni\Validation\Assertion;
use Igni\Validation\Error;

$userValidator = Assertion::group([
    'name' => Assertion::alnum(),
    'age' => Assertion::number(1, 200),
    'email' => Assertion::email(),
    'address' => Assertion::text(),
]);

$userValidator->validate([
    'name' => 'John',
    'age' => 233,
    'email' => 'johnmail',
]);// false


$errors = $userValidator->getErrors();

$errors[0] instanceof Error\OutOfRangeError;// true
$errors[0]->getContext()->getName();//age

$errors[1] instanceof Error\EmptyValueError;// true
$errors[1]->getContext()->getName();//address

// Exception can also be factored out of failure instance
throw $errors[0]->toException();
```

## API

### Validation list
 - [alnum](#assertionalnumint-min--null-int-max--null)
 - [alpha](#assertionalphaint-min--null-int-max--null)
 - [boolean](#assertionboolean)
 - [chain](#assertionchainrule-rules)
 - [contains](#assertioncontainsstring-value)
 - [date](#assertiondatestring-format--null-min--null-max--null)
 - [email](#assertionemail)
 - [falsy](#assertionfalsy)
 - [group](#assertiongrouparray-validatorshash)
 - [in](#assertioninvalues)
 - [integer](#assertionintegerint-min--null-int-max--null)
 - [ip](#assertionip)
 - [ipv4](#assertionipv4)
 - [ipv6](#assertionipv6)
 - [number](#assertionnumberint-min--null-int-max--null)
 - [regex](#assertionregexstring-pattern)
 - [text](#assertiontextint-minlength--null-int-maxlength--null)
 - [truthy](#assertiontruthy)
 - [uri](#assertionuri)
 - [url](#assertionurl)
 - [uuid](#assertionuuid)

### `Assertion::alnum(int $min = null, int $max = null)`

Creates validator that checks if passed value contains only digits and letters. 

#### Parameters
- `$min` defines minimum length 
- `$max` defines maximum length

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::alnum($minLength = 2);
var_dump($validator->validate('a1')); // true
```

### `Assertion::alpha(int $min = null, int $max = null)`

Creates validator that checks if passed value contains only letters.

#### Parameters
- `$min` defines minimum length 
- `$max` defines maximum length

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::alpha($minLength = 2);
var_dump($validator->validate('aaa')); // true
```

### `Assertion::boolean()`

Creates validator that checks if passed value is valid boolean expression.

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::boolean();
var_dump($validator->validate(false)); // true
```

### `Assertion::chain(Rule ...$rules)`

Creates validator that uses other validators to perform multiple validations on passed value.

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::chain(Assertion::text(), Assertion::date());
var_dump($validator->validate('2018-09-10')); // true
```

### `Assertion::contains(string $value)`

Creates validator that checks if passed string is contained in the validated string.

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::contains('example');
var_dump($validator->validate('Test example')); // true
```

### `Assertion::date(string $format = null, $min = null, $max = null)`

Creates validator that checks if passed value is valid date. 

#### Parameters
 - `$format` restricts format of passed value
 - `$min` defines minimum date range 
 - `$max` defines maximum date range
 
#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::date('Y-m-d');
var_dump($validator->validate('2018-09-10')); // true
```
     
### `Assertion::email()`

Creates validator that checks if passed value is valid email address.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::email();
var_dump($validator->validate('test@test.com')); // true
```

### `Assertion::falsy()`

Creates validator that checks if passed value is valid falsy expression;
- `off`
- `no`
- `false`
- 0

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::falsy();
var_dump($validator->validate('no')); // true
```

### `Assertion::group(array $validatorsHash)`

Creates validator with key/value hash that validates other hashes.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::group([
    'email' => Assertion::email(),
    'password' => Assertion::text(),
    'date_of_birth' => Assertion::date('Y-m-d'),
]);
var_dump($validator->validate([
    'email' => 'test@domain.com',
    'password' => 'secret',
    'date_of_birth' => '2019-01-01',
])); // true
```

### `Assertion::regex(string $pattern)`

Creates validator that checks if passed string matches the pattern.

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::regex('^-[a-z]+$');
var_dump($validator->validate('-aa')); // true
```

### `Assertion::truthy()`

Creates validator that checks if passed value is valid truthy expression;
- `on`
- `true`
- 1
- `yes`

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::truthy();
var_dump($validator->validate('yes')); // true
```

### `Assertion::text(int $minLength = null, int $maxLength = null)`

Creates validator that checks if passed value is string.

#### Parameters
- `$minLength` defines minimum length 
- `$maxLength` defines maximum length

#### Example
```php
<?php
use Igni\Validation\Assertion;

$validator = Assertion::text($minLength = 2);
var_dump($validator->validate('aaa')); // true
```

### `Assertion::in(...$values)`

Creates validator that checks if passed value exists in defined list of values.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::in('no', 'yes', 'test');
var_dump($validator->validate('no')); // true
```

### `Assertion::integer(int $min = null, int $max = null)`

Creates validator that checks if passed value is valid integer expression.

#### Parameters
 - `$min` defines minimum value
 - `$max` defines maximum value

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::integer(10, 100);
var_dump($validator->validate(11)); // true
 ```

### `Assertion::ip()`

Creates validator that checks if passed value is valid ip address.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::ip();
var_dump($validator->validate('123.123.123.123')); // true
```

### `Assertion::ipv4()`

Creates validator that checks if passed value is valid ip v4 address.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::ipv4();
var_dump($validator->validate('123.123.123.123')); // true
```

### `Assertion::ipv6()`

Creates validator that checks if passed value is valid ip v6 address.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::ipv6();
var_dump($validator->validate('2001:0db8:85a3:0000:0000:8a2e:0370:7334')); // true
```
 

### `Assertion::number(int $min = null, int $max = null)`

Creates validator that checks if passed value is valid number expression.

#### Parameters
 - `$min` defines minimum value
 - `$max` defines maximum value

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::number(10, 100);
var_dump($validator->validate('11.2')); // true
```
 
### `Assertion::uuid()`

Creates validator that checks if passed value is valid uuid.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::uuid();
var_dump($validator->validate('1ff60619-81cc-4d8e-88ac-a3ae36a97dce')); // true
```

### `Assertion::uri()`

Creates validator that checks if passed value is valid uri string.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::uri();
var_dump($validator->validate('/some/uri')); // true
```

### `Assertion::url()`

Creates validator that checks if passed value is valid url string.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::uri();
var_dump($validator->validate('http://domain.com/some/uri')); // true
```

### `Assertion::text()`

Creates validator that accepts every non empty string.

### `Assertion::group(array $validators)`

Creates validator that validates passed value by group of defined validators.

#### Example
```php
<?php
use Igni\Validation\Assertion;
 
$validator = Assertion::group([
    'name' => Assertion::text(),
    'age' => Assertion::integer(1, 200),
    'email' => Assertion::email(),
]);
var_dump($validator->validate(['name' => 'John Doe', 'age' => 29, 'email' => 'john@gmail.com'])); // true
```

## Creating custom validator

To create custom validator we have to simply extend `\Igni\Validation\Assertion` class, please consider following example:

```php
<?php declare(strict_types=1);

use Igni\Validation\Assertion;

class ValidateIn extends Assertion
{
    public function __construct(...$values)
    {
        $this->attributes['valid_values'] = $values;
    }

    protected function assert($input): bool
    {
        return in_array($input, $this->attributes['valid_values'], $strict = true);
    }
}

```

That's all folks!
