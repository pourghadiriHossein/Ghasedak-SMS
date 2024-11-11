<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Ghasedak;
use App\Models\Message;
use App\Models\Receptor;

class BulkSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bulk:sms {API_key} {template} {param} {phones*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send bulk sms';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $API_key = $this->argument('API_key');
        $template = $this->argument('template');
        $param = $this->argument('param');
        $phones = $this->argument('phones');
        echo "Start Command:\n";
        $message = Message::create([
            'API_key' => $API_key,
            'template' => $template,
            'param' => $param,
        ]);

        foreach ($phones as $phone) {
            echo "SMS Sending To: $phone :";
            $receptor = Receptor::create([
                'message_id' => $message->id,
                'phone' => $phone,
            ]);

            $flag = true;
            $counter = 0;
            while ($flag) {
                if ($counter > 9) {
                    break;
                }
                if (Ghasedak::sendOTP(
                    $message->API_key,
                    $message->template,
                    $message->param,
                    $receptor->phone,
                )) {
                    $receptor->status = 1;
                    $receptor->save();
                    $flag = false;
                }
                $counter++;
                sleep(1);
            }
            if ($flag) {
                echo "Not Done \n";
            } else {
                echo "Done \n";
            }
            sleep(1);
        }
    }
}
