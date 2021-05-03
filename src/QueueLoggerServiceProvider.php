<?php

namespace JSefton\QueueLogger;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class QueueLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (is_dir(__DIR__.'/../migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        }

        Queue::before(function (JobProcessing $event) {
            $payload = $event->job->payload();
            $data = [
                'uuid' => $payload['uuid'],
                'connection' => $event->connectionName,
                'task' => $payload['displayName'],
                'status' => 'processing',
                'processed' => 0,
                'command' => $payload['data']['command'],
                'started_processing_at' => (new \DateTime())->format('Y-m-d H:i:s.u')
            ];

            QueueLog::updateOrCreate(['uuid' => $data['uuid']], $data);
        });

        Queue::after(function (JobProcessed $event) {
            $payload = $event->job->payload();
            $data = [
                'uuid' => $payload['uuid'],
                'connection' => $event->connectionName,
                'task' => $payload['displayName'],
                'status' => 'processed',
                'processed' => 1,
                'command' => $payload['data']['command'],
                'processed_at' => (new \DateTime())->format('Y-m-d H:i:s.u')
            ];
            QueueLog::updateOrCreate(['uuid' => $data['uuid']], $data);
        });

        Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            $payload = $event->job->payload();
            $data = [
                'uuid' => $payload['uuid'],
                'connection' => $event->connectionName,
                'task' => $payload['displayName'],
                'status' => 'failed',
                'processed' => 0,
                'command' => $payload['data']['command'],
                'failed_at' => (new \DateTime())->format('Y-m-d H:i:s.u'),
                'failed' => 1,
                'error_message' => $event->exception->getMessage()
            ];
            QueueLog::updateOrCreate(['uuid' => $data['uuid']], $data);
        });
    }
}
