# Laravel Queue Logger

Creates a log of all queue jobs in a database table to help with auditing jobs.

Able to store and provide:

- Job
- Queue Connection
- Started Processing DateTime
- Processed DateTime
- Status
- Failed DateTime
- Failed Error Message


## Installation


```bash
composer require jsefton/laravel-queue-logger
```

Run migrations to create 'queue_logs' table:
```bash
php artisan migrate
```

This package will automatically register the event listeners and data will be inserted within the 'queue_logs' table.

An eloquent model exists if you wish to query the data back out as: `JSefton\QueueLogger\QueueLog`

Please note currently for Laravel 7+ until tested and verified in lower versions.
