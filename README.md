Laravel Settings
================

**Laravel Settings** is PHP package for laravel for handling the generic settings of your application.

With *Laravel Settings* you can store any type of values in the database.

## Installation

```sh
composer require danielefavi/laravel-settings
```

## Usage

Once the package is installed you can get the `Setting` model instace from the app service provider like this `app('settings')` or just call `settings()` (that is wrapper around `app('settings')`).

### Setting a value

```php
settings()->set('code_langs', ['php', 'javascript', 'python']);

// this does the same of the previous line of code
app('settings')->set('max_connection', 100);
```

### Getting a value

```php
$codeLangs = settings()->get('code_langs');
// codeLangs = Array( [0] => php [1] => javascript [2] => python )

$maxConn = settings()->get('max_connection');
```

When getting a function you can specify a default value as well.

```php
// if the setting max_connection is not found then it returns 999
$maxConn = settings()->get('max_connection', 999);
```

### Increment a value

```php
settings()->set('counter', 10); // the counter is 10

settings()->inc('counter'); // incrementing the counter by 1, so the counter is 11
settings()->inc('counter'); // incrementing the counter by 1, so the counter is 12
settings()->inc('counter', 3); // incrementing the counter by 3, so the counter is 15

$counter = settings()->get('counter'); // counter == 15
```

### Decrementing a value

```php
settings()->set('counter', 10); // the counter is 10

settings()->dec('counter'); // decrementing the counter by 1, so the counter is 9
settings()->dec('counter', 4); // decrementing the counter by 5, so the counter is 5

$counter = settings()->get('counter'); // counter == 5
```

### Appending (or attaching) a value to a setting 

With the `attach` method you can add values to an existing array or string. If the array or string does not exist then it will be created.

Appending values to an array.

```php
settings()->attach('tags', ['tag-1', 'tag-2']); // attaching (or creating) the array
settings()->attach('tags', ['tag-3', 'tag-4']); // attaching an array to the array
settings()->attach('tags', 'tag-5'); // attaching a value to the array

$tags = settings()->get('tags');
// tags contains tag-1, tag-2, tag-3, tag-4, tag-5
```

Appending values to a string.

```php
settings()->set('names', 'John');
settings()->attach('names', ',Doe,Wan');
settings()->attach('names', ',Clare');

$names = settings()->get('names'); // John,Doe,Wan,Clare
```