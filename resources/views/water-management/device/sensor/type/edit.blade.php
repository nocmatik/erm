@extends('components.modals.form-modal')
@section('modal-title','Modificar Tipo de Sensor')
@section('modal-content')
    <form class="" role="form"  id="type-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $type->name }}">
        </div>

        <div class="form-group">
            <label class="form-label">Intervalo</label>
            <select name="interval" class="form-control">
                @switch($type->interval)
                    @case(1)
                    <option value="1" selected>Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    @break
                    @case(5)

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5" selected>Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    @break
                    @case(10)

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10" selected>Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    @break
                    @case(15)

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15" selected>Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    @break
                    @case(30)

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30" selected>Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    @break
                    @case(60)

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60" selected>Cada 60 Minutos</option>
                    @break
                @endswitch
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valor Mínimo</label>
            <input type="text" class="form-control" id="min_value" name="min_value" value="{{ $type->min_value }}">
        </div>
        <div class="form-group">
            <label class="form-label">Valor máximo</label>
            <input type="text" class="form-control" id="max_value" name="max_value" value="{{ $type->max_value }}">
        </div>
        <label class="custom-control custom-checkbox">
            <input type="checkbox"  class="custom-control-input" value="1" name="apply_to_sensors">
            <span class="custom-control-label">Aplicar los valores a todos los sensores</span>
        </label>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#type-form','/sensor-types/'.$type->id, "tableReload(); closeModal();") !!}
@endsection
