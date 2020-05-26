<?php

namespace App\Http\WaterManagement\Device\Sensor\Type\Controllers;


use App\App\Controllers\Controller;
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
            if ($new = SensorType::create([
                'slug' => $request->name,
                'name' => $request->name,
                'interval' => $request->interval
            ])) {
                addChangeLog('Tipo Sensor Creado','sensor_types',null,convertColumns($new));

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
        $type = SensorType::findOrFail($id);
        $old = convertColumns($type);
        if(SensorType::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($type->update([
                'slug' => $request->name,
                'name' => $request->name,
                'interval' => $request->interval
            ])) {
                addChangeLog('Tipo sensor Modificado','sensor_types',$old,convertColumns($type));

                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $type = SensorType::findOrFail($id);
        if ($type->delete()) {
            addChangeLog('Tipo Sensor Eliminado','sensor_types',convertColumns($type));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
