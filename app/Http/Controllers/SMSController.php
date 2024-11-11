<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMSRequest;
use App\Jobs\BulkSMSJob;
use App\Models\Receptor;
use App\Modules\Convertor;
use App\Modules\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;

class SMSController extends Controller
{
    public function index()
    {
        $date = request()->input('date') ?? null;
        $receptors = Receptor::whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->when($date, function (Builder $limit, $date) {
                $limit->whereDate('created_at', Convertor::date_jalaliToGregorian($date));
            })
            ->simplePaginate(20);
        return view('welcome', compact('receptors', 'date'));
    }
    public function send(SMSRequest $request)
    {
        // if ($request->hasFile('list')) {
        //     $phones = Excel::read($request->file('list'));
        //     $API_key = $request->input('API_key');
        //     $template = $request->input('template');
        //     $param = $request->input('param');

        //     Artisan::call('bulk:sms', [
        //         'API_key' => $API_key,
        //         'template' => $template,
        //         'param' => $param,
        //         'phones' => $phones,
        //     ]);
        // }
        // return redirect(route('index'));

        if ($request->hasFile('list')) {
            $phones = Excel::read($request->file('list'));
            $API_key = $request->input('API_key');
            $template = $request->input('template');
            $param = $request->input('param');

            BulkSMSJob::dispatch($API_key, $template, $param, $phones);
        }

        return redirect(route('index'));

        // if ($request->hasFile('list')) {
        //     $phones = Excel::read($request->file('list'));
        //     $API_key = $request->input('API_key');
        //     $template = $request->input('template');
        //     $param = $request->input('param');

        //     $command = "php artisan bulk:sms $API_key $template $param " . implode(' ', $phones) . " > /dev/null 2>&1 &";
        //     exec($command);
        // }

        // return redirect(route('index'));
    }
}
