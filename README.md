# PHP Performance

## Requirements

 * PHP 7.2+
 * MySQL

## Installation

Copy the distributed environment file to a local copy.

```
cp .env .env.local
```

Edit the local copy (`.env.local`) to setup your `DATABASE_URL`. Example:

```
DATABASE_URL=mysql://root:@127.0.0.1:3306/php_performance
```

Make sure your MySQL database is created.

```
composer install
```




## Tools

If you'd like to follow along, you'll want to make sure you have your Blackfire and/or Tideways accounts ready to go.

### Blackfire

* https://blackfire.io

If you'd like to play along using Blackfire, visit Blackfire and create an account. Then, start a **premium** trial subscription to get the full Profiler features.

### Tideways

* https://tideways.com

If you'd like to play along using Tideways, visit Tideways and create an account. Then, create an organization with a 7-day trial with full functionality.


## Manual Instrumentation

### Blackfire

```
if (class_exists('BlackfireProbe')) {
    \BlackfireProbe::getMainInstance()->enable();
}

if (class_exists('BlackfireProbe')) {
    \BlackfireProbe::getMainInstance()->enable();
}
```

### Tideways

```
if (class_exists('Tideways\Profiler')) {
    \Tideways\Profiler::start();
}

if (class_exists('Tideways\Profiler')) {
    \Tideways\Profiler::stop();
}
```