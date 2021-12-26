<?php


namespace App\Helpers;


class Logger
{
    public function send($log)
    {
        // sent the log to external services
        return 'sent!';
    }

    public function log($log)
    {
        return app(Logger::class)->send($log);
    }
}
