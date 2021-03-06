<?php
namespace App\Services;

use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use Sentinel;

class Zones
{
    public function getZones()
    {
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter,'sub_zones.sub_elements'])->get();
        foreach ($zones as $zone){
            $zonesArray[$zone->id] = $zone->name;
        }
        return $zonesArray;
    }

    public function getTypeSensors()
    {
        $typeSensors = Sensor::get();
        foreach ($typeSensors as $sensor){
            $sensorTypeArray[$sensor->id] = $sensor->name;
        }
        return $sensorTypeArray;

    }

    public function getTypeCheckPoints()
    {
        $typeCheckPoints = CheckPointType::get();
        foreach ($typeCheckPoints as $checkPoint){
            $checkPointTypeArray[$checkPoint->id] = $checkPoint->name;
        }
        return $checkPointTypeArray;
    }

    public function getTypeAlarms()
    {
        $typeAlarms = SensorType::get();
        foreach ($typeAlarms as $typeAlarm){
            $typeAlarmArray[$typeAlarm->id] = $typeAlarm->name;
        }
        return $typeAlarmArray;
    }
}
