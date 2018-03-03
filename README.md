# ![Igni logo](https://raw.githubusercontent.com/igniphp/common/master/logo/full.svg)![Build Status](https://travis-ci.org/igniphp/container.svg?branch=master)

## Igni Validation
Licensed under MIT License.

**Igni** validation is a package for data validation.

## Installation

```
composer install igniphp/validation
```

## Introduction

### Basic example

```php
<?php

use Igni\Validation\Constraint;

$numberValidator = Constraint::number($min = 0);

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

use Igni\Validation\Constraint;
use Igni\Validation\Failures;
use Igni\Validation\Exception\ValidationException;

$userValidator = Constraint::group([
    'name' => Constraint::alnum(),
    'age' => Constraint::number(1, 200),
    'email' => Constraint::email(),
    'address' => Constraint::text(),
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

### `Constraint::alnum(int $min = null, int $max = null)`

Creates validator that checks if passed value contains only digits and letters. 

#### Parameters
- `$min` defines minimum length 
- `$max` defines maximum length

### `Constraint::alpha(int $min = null, int $max = null)`

Creates validator that checks if passed value contains only letters.

#### Parameters
- `$min` defines minimum length 
- `$max` defines maximum length

### `Constraint::boolean()`

Creates validator that checks if passed value is valid boolean expression.

### `Constraint::chain(Rule ...$rules)`

Creates validator that uses other validators to perform multiple validations on passed value.

### `Constraint::date(string $format = null, $min = null, $max = null)`

Creates validator that checks if passed value is valid date. 

#### Parameters
 - `$format` restricts format of passed value
 - `$min` defines minimum date range 
 - `$max` defines maximum date range
     
### `Constraint::email()`

Creates validator that checks if passed value is valid email address.

### `Constraint::falsy()`

Creates validator that checks if passed value is valid falsy expression;
- `off`
- `no`
- `false`
- 0

### `Constraint::truthy()`

Creates validator that checks if passed value is valid truthy expression;
- `on`
- `true`
- 1
- `yes`

### `Constraint::in(...$values)`

Creates validator that checks if passed value exists in defined list of values.

### `Constraint::integer(int $min = null, int $max = null)`

Creates validator that checks if passed value is valid integer expression.

#### Parameters
 - `$min` defines minimum value
 - `$max` defines maximum value

### `Constraint::number(int $min = null, int $max = null)`

Creates validator that checks if passed value is valid number expression.

#### Parameters
 - `$min` defines minimum value
 - `$max` defines maximum value
 
### `Constraint::uuid()`

Creates validator that checks if passed value is valid uuid.

### `Constraint::text()`

Creates validator that accepts every non empty string.

### `Constraint::group(array $validators)`

Creates validator that validates passed value by group of defined validators.

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
