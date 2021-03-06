# Laravel-Flasher

A simple flash-message handler for the [Laravel](http://laravel.com) framework.


## Installation

Install the bundle with artisan:

```
php artisan bundle::install flasher
```

Update your `application/bundles.php` file:

```php
'flasher' => array( 'auto' => true ),
```

And add an alias to `application/config/application.php` for ease-of-use:

```php
	...
	'aliases' => array(
		...
		'Flasher'     => 'Flasher\\Flasher',
		...
	),
	...
```


## Sample Usage

In your controllers, flash the message before your redirect.

```php
public function post_login()
{

	$credentials = Input::all();

	if ( Auth::attempt($credentials) ) {

		Flasher::success('Welcome back!');
		return Redirect::to('home');

	}

	Flasher::error('Login failed');

	return Redirect::back();

}
```

In your views, all you need to see the flashed messages is:

```php
@render('flasher::flashes')
```

Or render them directly with:

```php
{{ Flasher::showall() }}
```



## Customizing

The output format of the flash is stored in a configuration file.  Simply copy the `bundles/flasher/config/flasher.php` to `application/config/flasher.php` and adjust it as required.

Alternatively, you can copy the view from `bundles/flasher/views/flashes.php` into your application's views and `@render()` that instead.  See [Working with Messages] for details.



## API

### Adding Messages

To add a flash message of a certain type:

```php
Flasher::add( $message, $type = null )
```

This adds a message to the flash array.  A more common way to do this would be to use a magic method:

```
Flasher::error('Something has gone wrong!');
Flasher::success('You did it!');
Flasher::info('File size is '.$size);
```

Any value can be used for `$type` (or for a magic method), except for the retrieval methods below.


### Retrieve Messages

To retrieve all messages (returns an array of `Flasher\Message` objects):

```php
Flasher::all()
```

Retrieve all messages of type "error":

```php
Flasher::all('error')
```

Retrieve first (or last) message (returns a single `Flasher\Message` object):

```php
Flasher::first()
Flasher::last()
```

Retrieve first (or last) message of a type:

```php
Flasher::first('error')
Flasher::last('success')
```

Check if there are any error messages (returns boolean):

```php
if ( Flasher::has('error') ) {
	...
}
```

Check if there are __any__ messages:

```php
if ( Flasher::has() ) {
	...
}
```


### Displaying Messages

The `Flasher\Message` objects have `type` and `message` attributes at your disposal. You can use these directly in views, for example.

```php
@foreach( Flasher::get() as $msg )
<div class="flash-{{ $msg->type }}">
	{{ $msg->message }}
</div>
@endforeach
```

`Flasher\Message` objects also have a `format()` method which takes a string, similar to Laravel's `Messages` class.  You can pass a string with embedded `:type` and `:message` strings, and they will be replaced with the appropriate values:

```php
echo $msg->format('<p class="alert alert-:type">:message</p>');
```

Calling the `format()` method without an argument will use whatever is defined by the `format` key in `application/config/flasher.php`, falling back to the key defined in `bundles/flasher/config/flasher.php` (which is the same as the above example).

Finally, the `Flasher\Message` object has a magic `__toString()` which just calls `format()` with no arguments (i.e. use the configuration format).

We've added a quick way to display all the formatted messages (optionally filtering on type):

```php
echo Flasher::showall($type);
```

This is pretty much equivalent to:

```php
foreach( Flasher::all($type) as $message ) {
	echo $message->format();
}
```


## Bugs and Suggestions

Use the [Github Issues](https://github.com/cviebrock/laravel-flasher/issues) sysyem to report bugs or suggest improvements.  Even better, fork this repository and submit a pull request.



## Todos

- Convert to Laravel 4 composer package
