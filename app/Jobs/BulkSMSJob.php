<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class BulkSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $API_key;
    protected $template;
    protected $param;
    protected $phones;

    public function __construct($API_key, $template, $param, $phones)
    {
        $this->API_key = $API_key;
        $this->template = $template;
        $this->param = $param;
        $this->phones = $phones;
    }

    public function handle()
    {
        Artisan::call('bulk:sms', [
            'API_key' => $this->API_key,
            'template' => $this->template,
            'param' => $this->param,
            'phones' => $this->phones,
        ]);
    }
}
