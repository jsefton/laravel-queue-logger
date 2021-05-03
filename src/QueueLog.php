<?php

namespace JSefton\QueueLogger;

use Illuminate\Database\Eloquent\Model;

class QueueLog extends Model
{
    protected $fillable = [
        'uuid',
        'connection',
        'task',
        'status',
        'processed',
        'command',
        'event',
        'failed',
        'error_message',
        'dispatched_at',
        'started_processing_at',
        'processed_at',
        'failed_at'
    ];
}
