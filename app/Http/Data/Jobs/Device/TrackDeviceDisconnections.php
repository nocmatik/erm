<?php

namespace App\Http\Data\Jobs\Device;

use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class TrackDeviceDisconnections implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $devices =  Device::with('report','last_dc')->where('from_bio',0)->get()->filter(function($device){
            return  optional($device->report)->state  === 0 ||
                    (
                        optional($device->last_disconnection->first())->start_date != ''
                        &&
                        optional($device->last_disconnection->first())->end_date == null
                    );
        });

        foreach($devices as  $device){

            $state = optional($device->report)->state ;

            if(optional($device->last_dc)->start_date != '' && optional($device->last_dc)->end_date == null) {
                if($state === 0) {
                    continue;
                } else {
                    $last = $device->last_dc;
                    $last->end_date = Carbon::now()->toDateTimeString();
                    $last->save();
                }
            } else {
                if($state === 0) {
                    $device->disconnections()->create([
                        'start_date' => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }
    }
}
