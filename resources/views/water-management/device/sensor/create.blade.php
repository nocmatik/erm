@extends('components.modals.form-modal')
@section('modal-title','Crear Sensor')
@section('modal-content')
    <form class="" role="form"  id="sensor-form">
        @csrf
        <input type="hidden" name="device_id" value="{{ $device_id }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo Registro</label>
            <select name="address_id" class="form-control">
                @foreach($addresses as $address)
                    <option value="{{ $address->id }}">{{ $address->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Direccion</label>
            <input type="text" class="form-control"  name="address_number">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Sensor</label>
            <select name="type_id" class="form-control">
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#sensor-form','/sensors', "tableReload(); closeModal();") !!}
@endsection
