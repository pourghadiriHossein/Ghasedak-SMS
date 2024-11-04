<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMSRequest;
use App\Models\Message;
use App\Models\Receptor;
use App\Modules\Convertor;
use App\Modules\Excel;
use App\Modules\Ghasedak;
use Illuminate\Database\Eloquent\Builder;

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
        if ($request->hasFile('list')) {
            $phones = Excel::read($request->file('list'));
            $message = Message::create([
                'API_key' => $request->input('API_key'),
                'template' => $request->input('template'),
                'param' => $request->input( 'param'),
            ]);
            foreach ($phones as $item) {
                $receptor = Receptor::create([
                    'message_id' => $message->id,
                    'row' => $item->row,
                    'phone' => $item->phone,
                ]);
                $flag = true;
                $counter = 0;
                while ($flag) {
                    if($counter > 9) {
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
                sleep(1);
            }
        }
        return redirect(route('index'));
    }
}
