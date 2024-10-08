<?php

namespace App\Console\Commands;

use App\Mail\ReminderLSExpired;
use App\Mail\ReminderLSWillExpired;
use App\Models\AreaPart;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReminderExpiredLimitSample extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat ke Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //reminder dokumen limit sample yang sudah expired
        $areaParts = AreaPart::where('expired_date', '>' ,Carbon::now()->format('Y-m-d'))->with(['parts','modelPart','partArea'])->select('part_area_id','part_id','model_part_id','expired_date')->groupBy('part_area_id','part_id','model_part_id','expired_date')->get();
        if($areaParts->count() > 0)
        {
            Mail::to('mahsunmuh0@gmail.com')->send(new ReminderLSExpired($areaParts));
        }


        //reminder dokumen limit sample yang akan expired
        $areaParts = AreaPart::whereBetween('expired_date', [Carbon::now()->addDays(1)->format('Y-m-d'), Carbon::now()->addDays(1)->format('Y-m-d'), Carbon::now()->addDays(2)])
            ->with(['parts','modelPart','partArea'])
            ->select('part_area_id','part_id','model_part_id','expired_date')
            ->groupBy('part_area_id','part_id','model_part_id','expired_date')
            ->get();

        if($areaParts->count() > 0) {
            Mail::to('mahsunmuh0@gmail.com')->send(new ReminderLSWillExpired($areaParts));
        }

        return 0;
    }
}
