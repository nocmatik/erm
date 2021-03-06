<?php

namespace App\Http\WaterManagement\Device\Sensor\Type\Controllers;


use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use App\Http\WaterManagement\Device\Sensor\Type\Requests\SensorTypeRequest;
use Illuminate\Support\Str;

class SensorTypeController extends Controller
{
    public function index()
    {
        return view('water-management.device.sensor.type.index');
    }

    public function create()
    {
        return view('water-management.device.sensor.type.create');
    }

    public function store(SensorTypeRequest $request)
    {
        if (SensorType::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (SensorType::create([
                'slug' => $request->name,
                'name' => $request->name,
                'interval' => $request->interval,
                'min_value' => $request->min_value,
                'max_value' => $request->max_value,
                'is_exportable' => ($request->has('is_exportable'))?1:0,
                'is_dga' => ($request->has('is_dga'))?1:0,
                'sensor_type' => $request->sensor_type
            ])) {
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $type = SensorType::findOrFail($id);
        return view('water-management.device.sensor.type.edit',compact('type'));
    }

    public function update(SensorTypeRequest $request,$id)
    {
        $record = SensorType::findOrFail($id);
        if(SensorType::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($record->update([
                'slug' => $request->name,
                'name' => $request->name,
                'interval' => $request->interval,
                'min_value' => $request->min_value,
                'max_value' => $request->max_value,
                'is_exportable' => ($request->has('is_exportable'))?1:0,
                'is_dga' => ($request->has('is_dga'))?1:0,
                'sensor_type' => $request->sensor_type
            ])) {

                if($request->has('apply_to_sensors')) {
                    $sensors = Sensor::where('type_id',$record->id)->get();

                    foreach ($sensors as $sensor) {
                        $sensor->fix_min_value = $request->min_value;
                        $sensor->fix_max_value = $request->max_value;
                        $sensor->fix_values = ($request->min_value != '' && $request->max_value != '')?1:0;
                        $sensor->save();
                    }
                }
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $record = SensorType::findOrFail($id);
        if ($record->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
