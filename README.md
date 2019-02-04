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

use Igni\Validation\Rule;

$numberValidator = Rule::number($min = 0);

$numberValidator(1);// true
$numberValidator(-1);// false
$numberValidator->validate(1);// true, same as above
$numberValidator(1.0);// true
$numberValidator->validate('a'); // false
```

### Getting error information

Allows to validate complex arrays 

```php
<?php

use Igni\Validation\Rule;
use Igni\Validation\Failures;
use Igni\Validation\Exception\ValidationException;

$userValidator = Rule::group([
    'name' => Rule::alnum(),
    'age' => Rule::number(1, 200),
    'email' => Rule::email(),
    'address' => Rule::text(),
]);

$userValidator([
    'name' => 'John',
    'age' => 233,
    'email' => 'johnmail',
]);// false


$validationFailures = $userValidator->getFailures();

$validationFailures[0] instanceof Failures\OutOfRangeFailure;// true
$validationFailures[0]->getContext()->getName();//age

$validationFailures[1] instanceof Failures\EmptyValueFailure;// true
$validationFailures[1]->getContext()->getName();//address

// Exception can also be factored out of failure instance
throw ValidationException::forValidationFailure($validationFailures[0]);
```

## API

### Validation list
 - [alnum](#rulealnumint-min--null-int-max--null)
 - [alpha](#rulealphaint-min--null-int-max--null)
 - [boolean](#ruleboolean)
 - [chain](#rulechainrule-rules)
 - [contains](#rulecontainsstring-value)
 - [date](#ruledatestring-format--null-min--null-max--null)
 - [email](#ruleemail)
 - [falsy](#rulefalsy)
 - [group](#rulegrouparray-validatorshash)
 - [in](#ruleinvalues)
 - [integer](#ruleintegerint-min--null-int-max--null)
 - [ip](#ruleip)
 - [ipv4](#ruleipv4)
 - [ipv6](#ruleipv6)
 - [number](#rulenumberint-min--null-int-max--null)
 - [regex](#ruleregexstring-pattern)
 - [text](#ruletextint-minlength--null-int-maxlength--null)
 - [truthy](#ruletruthy)
 - [uri](#ruleuri)
 - [url](#ruleurl)
 - [uuid](#ruleuuid)

### `Rule::alnum(int $min = null, int $max = null)`

Creates validator that checks if passed value contains only digits and letters. 

#### Parameters
- `$min` defines minimum length 
- `$max` defines maximum length

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::alnum($minLength = 2);
var_dump($validator('a1')); // true
```

### `Rule::alpha(int $min = null, int $max = null)`

Creates validator that checks if passed value contains only letters.

#### Parameters
- `$min` defines minimum length 
- `$max` defines maximum length

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::alpha($minLength = 2);
var_dump($validator('aaa')); // true
```

### `Rule::boolean()`

Creates validator that checks if passed value is valid boolean expression.

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::boolean();
var_dump($validator(false)); // true
```

### `Rule::chain(Rule ...$rules)`

Creates validator that uses other validators to perform multiple validations on passed value.

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::chain(Rule::text(), Rule::date());
var_dump($validator('2018-09-10')); // true
```

### `Rule::contains(string $value)`

Creates validator that checks if passed string is contained in the validated string.

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::contains('example');
var_dump($validator('Test example')); // true
```

### `Rule::date(string $format = null, $min = null, $max = null)`

Creates validator that checks if passed value is valid date. 

#### Parameters
 - `$format` restricts format of passed value
 - `$min` defines minimum date range 
 - `$max` defines maximum date range
 
#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::date('Y-m-d');
var_dump($validator('2018-09-10')); // true
 ```
     
### `Rule::email()`

Creates validator that checks if passed value is valid email address.

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::email();
var_dump($validator('test@test.com')); // true
 ```

### `Rule::falsy()`

Creates validator that checks if passed value is valid falsy expression;
- `off`
- `no`
- `false`
- 0

#### Example
```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::falsy();
var_dump($validator('no')); // true
```

### `Rule::group(array $validatorsHash)`

Creates validator with key/value hash that validates other hashes.

#### Example
```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::group([
    'email' => Rule::email(),
    'password' => Rule::text(),
    'date_of_birth' => Rule::date('Y-m-d'),
]);
var_dump($validator([
    'email' => 'test@domain.com',
    'password' => 'secret',
    'date_of_birth' => '2019-01-01',
])); // true
```

### `Rule::regex(string $pattern)`

Creates validator that checks if passed string matches the pattern.

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::regex('^-[a-z]+$');
var_dump($validator('-aa')); // true
```

### `Rule::truthy()`

Creates validator that checks if passed value is valid truthy expression;
- `on`
- `true`
- 1
- `yes`

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::truthy();
var_dump($validator('yes')); // true
 ```

### `Rule::text(int $minLength = null, int $maxLength = null)`

Creates validator that checks if passed value is string.

#### Parameters
- `$minLength` defines minimum length 
- `$maxLength` defines maximum length

#### Example
```php
<?php
use Igni\Validation\Rule;

$validator = Rule::text($minLength = 2);
var_dump($validator('aaa')); // true
```

### `Rule::in(...$values)`

Creates validator that checks if passed value exists in defined list of values.

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::in('no', 'yes', 'test');
var_dump($validator('no')); // true
 ```

### `Rule::integer(int $min = null, int $max = null)`

Creates validator that checks if passed value is valid integer expression.

#### Parameters
 - `$min` defines minimum value
 - `$max` defines maximum value

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::integer(10, 100);
var_dump($validator(11)); // true
 ```

### `Rule::ip()`

Creates validator that checks if passed value is valid ip address.

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::ip();
var_dump($validator('123.123.123.123')); // true
```

### `Rule::ipv4()`

Creates validator that checks if passed value is valid ip v4 address.

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::ipv4();
var_dump($validator('123.123.123.123')); // true
```

### `Rule::ipv6()`

Creates validator that checks if passed value is valid ip v6 address.

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::ipv6();
var_dump($validator('2001:0db8:85a3:0000:0000:8a2e:0370:7334')); // true
```
 

### `Rule::number(int $min = null, int $max = null)`

Creates validator that checks if passed value is valid number expression.

#### Parameters
 - `$min` defines minimum value
 - `$max` defines maximum value

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::number(10, 100);
var_dump($validator('11.2')); // true
 ```
 
### `Rule::uuid()`

Creates validator that checks if passed value is valid uuid.

#### Example
```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::uuid();
var_dump($validator('1ff60619-81cc-4d8e-88ac-a3ae36a97dce')); // true
```

### `Rule::uri()`

Creates validator that checks if passed value is valid uri string.

#### Example
```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::uri();
var_dump($validator('/some/uri')); // true
```

### `Rule::url()`

Creates validator that checks if passed value is valid url string.

#### Example
```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::uri();
var_dump($validator('http://domain.com/some/uri')); // true
```

### `Rule::text()`

Creates validator that accepts every non empty string.

### `Rule::group(array $validators)`

Creates validator that validates passed value by group of defined validators.

#### Example
 ```php
<?php
use Igni\Validation\Rule;
 
$validator = Rule::group([
    'name' => Rule::text(),
    'age' => Rule::integer(1, 200),
    'email' => Rule::email(),
]);
var_dump($validator(['name' => 'John Doe', 'age' => 29, 'email' => 'john@gmail.com'])); // true
 ```

## Creating custom validator

To create custom validator we have to simply extend `\Igni\Validation\Rule` class, please consider following example:

```php
<?php declare(strict_types=1);

use Igni\Validation\Rule;

class ValidateIn extends Rule
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
