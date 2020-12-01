@extends('layouts.app')
@section('page-title')
    {{ 'Dashboard : '.$subZone->name }} <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
@endsection
@section('page-icon','bolt')
@section('page-content')
    <input type="hidden" id="sub_zone" value="{{ $subZone->id }}">
    <input type="hidden" id="zone" value="{{ $subZone->zone_id }}">
    {!! includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css') !!}
    <style>
        @media (max-width: 576px) {
            .main-box-number {
                font-size: 1.3em;
            }
            .box-label {
                font-size: 0.7em;
            }
            .main-box-icon {
                visibility: hidden;
            }
        }
    </style>
    <div class="card border">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#consumption-container">Energía</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#energy-container">Variables eléctricas</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="consumption-container" role="tabpanel">
                <div class="card-body">
                    @include('water-management.dashboard.energy.sections.consumption')
                </div>
            </div>
            <div class="tab-pane fade" id="energy-container" role="tabpanel">
                <div class="card-body">
                    @include('water-management.dashboard.energy.sections.energy')
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="tension-options" value="average">
    <input type="hidden" id="tension-type" value="LL">
    <input type="hidden" id="power-options" value="PL">
@endsection
@section('more-scripts')
    {!! includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]) !!}
@endsection
@section('page-extra-scripts')
    {!! includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js') !!}
    @include('water-management.dashboard.energy.charts.consumption')
    <script>
        $('.btn-alarm').hide();

        $('.tension-ln').hide();
        $('.power-data').hide();

        function getVarData(name,fn,sensor_name = null,bg = 'bg-primary',mb = ''){
            $.ajax({
                url     : '/energy/get-var-data',
                type    : 'GET',
                data    : {
                    name : name,
                    sub_zone : $('#sub_zone').val(),
                    func : fn,
                    bg : bg,
                    mb : mb,
                    sensor_name : sensor_name
                },
                success : function ( data )
                {
                    if(sensor_name != null) {
                        $('#'+name+'-'+sensor_name+'-container').html(data);
                    } else {
                        $('#'+name+'-container').html(data);
                    }
                },
                error   : function ( response )
                {
                    console.log(response);
                }
            });
        }

        function getConsumptionData()
        {
            getVarData('ee-e-activa','sum',null,'bg-success-300');
            getVarData('ee-e-reactiva','sum',null,'bg-success-300');
            getVarData('ee-e-aparente','sum',null,'bg-success-300');
        }

        function getStreamData()
        {
            getVarData('ee-corriente','avg','L1','bg-warning-600','mb-1');
            getVarData('ee-corriente','avg','L2','bg-warning-600','mb-1');
            getVarData('ee-corriente','avg','L3','bg-warning-600','mb-1');
        }

        function getTensionData()
        {
            getVarData('ee-tension-l-l','avg','L1-L2','bg-primary-300','mb-1');
            getVarData('ee-tension-l-l','avg','L2-L3','bg-primary-300','mb-1');
            getVarData('ee-tension-l-l','avg','L3-L1','bg-primary-300','mb-1');


            getVarData('ee-tension-l-n','avg','L1-N','bg-primary-300','mb-1');
            getVarData('ee-tension-l-n','avg','L2-N','bg-primary-300','mb-1');
            getVarData('ee-tension-l-n','avg','L3-N','bg-primary-300','mb-1');
        }

        function getPowerData()
        {
            getVarData('ee-p-act-u','avg','P1','bg-danger-300','mb-1');
            getVarData('ee-p-act-u','avg','P2','bg-danger-300','mb-1');
            getVarData('ee-p-act-u','avg','P3','bg-danger-300','mb-1');


            getVarData('ee-p-activa','avg',null,'bg-danger-300','mb-1');
            getVarData('ee-p-reactiva','avg',null,'bg-danger-300','mb-1');
            getVarData('ee-p-aparente','avg',null,'bg-danger-300','mb-1');
        }

        function tensionOptions(options)
        {
            $('#tension-options').val(options);
        }

        function tensionType(type){
            $('#tension-type').val(type);
            if(type == 'LL') {
                $('.tension-ll').show();
                $('.tension-ln').hide();
            } else {
                $('.tension-ll').hide();
                $('.tension-ln').show();
            }
        }

        function streamOptions(options)
        {
            $('#stream-options').val(options);
        }

        function powerOptions(type){
            $('#power-options').val(type);
            if(type == 'PL') {
                $('.opt-pl').show();
                $('.power-data').hide();
            } else {
                $('.opt-pl').hide();
                $('.power-data').show();
            }
        }

        function getConsumption(start = false, end = false,container = 'consumption') {
            let start_date,end_date;
            if(start != false) {
                start_date = start;
            } else {
                start_date = moment().startOf('month').format('YYYY-MM-DD');
            }

            if(end != false) {
                end_date = end;
            } else {
                end_date = moment().endOf('month').format('YYYY-MM-DD');
            }


            $.ajax({
                url     : '/energy/get-consumption-data',
                type    : 'GET',
                data    : {
                    sub_zone : $('#sub_zone').val(),
                    start_date : start_date,
                    end_date : end_date,
                },
                success : function ( data )
                {
                    $('#'+container).html(data);
                },
                error   : function ( response )
                {
                    console.log(response);
                }
            });
        }

        function getZoneConsumption(start = false, end = false,container = 'zone-consumption') {
            let start_date,end_date;
            if(start != false) {
                start_date = start;
            } else {
                start_date = moment().startOf('month').format('YYYY-MM-DD');
            }

            if(end != false) {
                end_date = end;
            } else {
                end_date = moment().endOf('month').format('YYYY-MM-DD');
            }

            $.ajax({
                url     : '/energy/get-zone-consumption-data',
                type    : 'GET',
                data    : {
                    zone : $('#zone').val(),
                    start_date : start_date,
                    end_date : end_date,
                },
                success : function ( data )
                {
                    $('#'+container).html(data);
                },
                error   : function ( response )
                {
                    console.log(response);
                }
            });
        }

        getConsumption();
        getConsumption(moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD'),moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD'),'last-month-consumption');
        getZoneConsumption();
        getZoneConsumption(moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD'),moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD'),'last-month-zone-consumption');

        getConsumptionData();
        getStreamData();
        getTensionData();
        getPowerData();

        $(document).ready(function(){
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

            $('.date-filter').daterangepicker(
                {
                    opens: 'right',
                    templates: controls,
                    maxDate : moment(),
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    "showDropdowns": true,
                    "showWeekNumbers": true,
                    "showISOWeekNumbers": true,
                    "timePicker": false,
                    "timePicker24Hour": false,
                    "timePickerSeconds": false,
                    "autoApply": false,
                    ranges:
                        {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                            'Esta Semana': [moment().startOf('week'), moment().endOf('week')],
                            'Semana Pasada': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                    "alwaysShowCalendars": true,
                    "applyButtonClasses": "btn-default shadow-0",
                    "cancelClass": "btn-success shadow-0"
                }, function(start, end, label)
                {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });

            $('.consumption-date').daterangepicker(
                {
                    opens: 'right',
                    templates: controls,
                    maxDate : moment(),
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    "showDropdowns": true,
                    "showWeekNumbers": true,
                    "showISOWeekNumbers": true,
                    "timePicker": false,
                    "timePicker24Hour": false,
                    "timePickerSeconds": false,
                    "autoApply": false,
                    startDate : moment().startOf('month'),
                    endDate: moment().endOf('month'),
                    ranges:
                        {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                            'Esta Semana': [moment().startOf('week'), moment().endOf('week')],
                            'Semana Pasada': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                    "alwaysShowCalendars": true,
                    "applyButtonClasses": "btn-default shadow-0",
                    "cancelClass": "btn-success shadow-0"
                }, function(start, end, label)
                {
                    if(moment().startOf('month').isSame(start) && moment().endOf('month').isSame(end)) {
                        $('.consumption-box').removeClass('col-xl-6 col-lg-6 col-md-6',200).addClass('col-xl-3 col-lg-3 col-md-3',200);
                        setTimeout(function(){
                            $('#last-month-consumption').show('slideDown');
                            $('#last-month-zone-consumption').show('slideDown');
                        },400);

                        $('#consumption .box-label').html('Consumo mes actual');
                        $('#zone-consumption .box-label').html('Consumo Pocillas mes actual');
                    } else {
                        $('#last-month-consumption').hide();
                        $('#last-month-zone-consumption').hide();
                        $('.consumption-box').removeClass('col-xl-3 col-lg-3 col-md-3',200).addClass('col-xl-6 col-lg-6 col-md-6',200);
                        $('#consumption .box-label').html('Consumo total');
                        $('#zone-consumption .box-label').html('Pocillas consumo total');
                    }
                    getConsumption(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
                    getZoneConsumption(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
                    getConsumptionChart();
                }
            );

        });


    </script>
@endsection

