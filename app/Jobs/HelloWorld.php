<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class HelloWorld implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $source = 'manual') {}

    public function handle(): void
    {
        $line = sprintf('[%s] Hello World from %s (worker pid %d)', now()->toDateTimeString(), $this->source, getmypid());

        fwrite(STDOUT, $line.PHP_EOL);
        Log::info($line);

        Redis::lpush('hello:log', $line);
        Redis::ltrim('hello:log', 0, 49);
    }
}
