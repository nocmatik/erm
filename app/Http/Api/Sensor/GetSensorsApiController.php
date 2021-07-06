<?php

namespace App\Http\Api\Sensor;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Api\ApiKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class GetSensorsApiController extends Controller
{
    use HasAnalogousData;

    public function index(Request $request)
    {
        if(!$request->hasHeader('api-key')) {
            return response(['No posee permisos para ingresar al recurso.'],401);
        }

        if(!$api = ApiKey::with('sensors')->where('key',$request->header('api-key'))->first()) {
            return response(['Llave no encontrada.'],404);
        }

        $data = array();
        foreach($api->sensors as $sensor) {
            $s = $this->getSensorById($sensor->sensor_id);
            $analogous_data = $this->getAnalogousValue($s);

            array_push($data,[
                'name' => $s->device->check_point->name,
                'value' => $analogous_data['value'],
                'unit' => $analogous_data['unit'],
                'date' => Carbon::now()->toDateTimeString()
            ]);
        }
        $api->last_access = Carbon::now()->toDateTimeString();
        $api->save();
        return $data;
    }

}
