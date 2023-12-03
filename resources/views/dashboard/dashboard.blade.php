@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); ?>
@section('title',"Dashboard | $title")
@push('page_css')
    <link rel="stylesheet" type="text/css" href="assets/customCalendar/calendar.css" />
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <!-- <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div> -->
                    
                   
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <!-- <div class="col-lg-12">
                <div class="card">
                    <div class="card-body"> -->

                        <span id="menu-navi" class="d-sm-flex flex-wrap text-center text-sm-start justify-content-sm-between mb-2">
                            <div class="d-sm-flex flex-wrap gap-1">
                                <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary move-day" data-action="move-prev">
                                        <i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left"
                                            data-action="move-prev"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary move-day" data-action="move-next">
                                        <i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right"
                                            data-action="move-next"></i>
                                    </button>
                                </div>
                                <button type="button" class="btn btn-primary move-today mb-2"data-action="move-today">Today</button>
                            </div>

                            <h4 id="renderRange" class="render-range fw-bold pt-1 mx-3"></h4>
                            <div class="dropdown align-self-start mt-3 mt-sm-0 mb-2"> </div>

                        </span>
                        <div id="calendarList" class="lnb-calendars-d1 mt-4 mt-sm-0 me-sm-0 mt-5">
                            <div class="lnb-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="1" checked=""><span style="border-color: #50a5f1; background-color: #50a5f1;"></span><span>Meetting</span></label></div>

                            <div class="lnb-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="2" checked=""><span style="border-color: #ff5583; background-color: #ff5583;"></span><span>Training</span></label></div>

                            <div class="lnb-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""><span style="border-color: #ffbb3b; background-color: #ffbb3b;"></span><span>Presentation</span></label></div>

                            <div class="lnb-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="4" checked=""><span style="border-color: #03bd9e; background-color: #03bd9e;"></span><span>Site Visit</span></label></div>

                            <div class="lnb-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="5" checked=""><span style="border-color: #bbdc00; background-color: #bbdc00;"></span><span>Internal Design Discussion</span></label></div>
                        </div>
                        
                        <div id="calendar" style="height: 800px;margin-top: -35px;"></div>
                    <!-- </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
            
@stop
@push('page_js')
<script>
    const createScheduleUrl = "{{url('create_schedule') }}";
    const getScheduleUrls = "{{url('get_schedules') }}";
    const deleteScheduleUrl = "{{url('delete_schedules') }}";
</script>
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
    <script src="https://uicdn.toast.com/tui.dom/v3.0.0/tui-dom.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="assets/customCalendar/calendar.js"></script>

@endpush