@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
    $roles=Session::get('ROLES');
    $role=explode(',',$roles);
    $count=count($role);
?>
@section('title',"Site Visit Report | $title")
@push('datatable_css')
{!! Html::style('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
@endpush
@push('page_css')
{!! Html::style('assets/libs/select2/css/select2.min.css') !!}
<style>
    .form-floating>.form-control, .form-floating>.form-select {
        height: calc(2.8rem + 1px) !important;
        padding: 1rem .75rem;
    }
    .form-floating>.textuti {
        height: calc(2.8rem + 30px) !important;
    }
    .select2
     {
            width: 100% !important;
     }
     .amsify-suggestags-list{
        z-index: 1 !important;
        width: 100% !important;
     }
     textarea,
    .textarea {
      min-height: inherit;
      height: auto;
    }
    .form-check
    {
        display: inline-block;
    }

    /** SPINNER CREATION **/

    .loader {
    position: relative;
    text-align: center;
    margin: 15px auto 35px auto;
    z-index: 9999;
    display: block;
    width: 80px;
    height: 80px;
    border: 10px solid rgba(0, 0, 0, .3);
    border-radius: 50%;
    border-top-color: #000;
    animation: spin 1s ease-in-out infinite;
    -webkit-animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
    to {
        -webkit-transform: rotate(360deg);
    }
    }

    @-webkit-keyframes spin {
    to {
        -webkit-transform: rotate(360deg);
    }
    }
</style>
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">     
                           <h4 class="card-title mb-4">Site Visit Reports</h4>
                           <div class="ms-auto">
                                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light w-sm" data-bs-toggle="modal" data-bs-target="#addModal" style="margin-left: 10px;">
                                <i class="mdi mdi-plus font-size-11"></i> Add Site Visit
                                </button> 
                            </div>
                        </div>
             
                        @include('common.alert')
                        <div id="alerts">
                        </div>
                       
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#ar_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Architecture</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#in_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Interior</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#la_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Landscape</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#sa_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Sustainable</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ud_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Urban Design</span> 
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="ar_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 table table-striped" id="ar_datatable"> 
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 20px;">Sr.No</th>
                                                <th scope="col" style="width: 100px">Visit Date</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="white-space: normal;">Visit By</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Contractor</th>
                                                <th scope="col" style="width: 100px">Stage of Construction</th>
                                                <th scope="col" style="width: 100px">Attendees</th>

                                            </tr>
                                        </thead>
                                        <tbody id="ar_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="in_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 table table-striped" id="in_datatable"> 
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 20px;">Sr.No</th>
                                                <th scope="col" style="width: 100px">Visit Date</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="white-space: normal;">Visit By</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Contractor</th>
                                                <th scope="col" style="width: 100px">Stage of Construction</th>
                                                <th scope="col" style="width: 100px">Attendees</th>
                                            </tr>
                                        </thead>
                                        <tbody id="in_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="la_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 table table-striped" id="la_datatable"> 
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 20px;">Sr.No</th>
                                                <th scope="col" style="width: 100px">Visit Date</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="white-space: normal;">Visit By</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Contractor</th>
                                                <th scope="col" style="width: 100px">Stage of Construction</th>
                                                <th scope="col" style="width: 100px">Attendees</th>

                                            </tr>
                                        </thead>
                                        <tbody id="la_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="sa_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 table table-striped" id="sa_datatable"> 
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 20px;">Sr.No</th>
                                                <th scope="col" style="width: 100px">Visit Date</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="white-space: normal;">Visit By</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Contractor</th>
                                                <th scope="col" style="width: 100px">Stage of Construction</th>
                                                <th scope="col" style="width: 100px">Attendees</th>

                                            </tr>
                                        </thead>
                                        <tbody id="sa_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="ud_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 table table-striped" id="ud_datatable"> 
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 20px;">Sr.No</th>
                                                <th scope="col" style="width: 100px">Visit Date</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="white-space: normal;">Visit By</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Contractor</th>
                                                <th scope="col" style="width: 100px">Stage of Construction</th>
                                                <th scope="col" style="width: 100px">Attendees</th>

                                            </tr>
                                        </thead>
                                        <tbody id="ud_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   

<!-- sample modal content -->
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Site Visit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['class'=>"form-horizontal",'method'=>"post",'url'=>'post_visit_report']) !!}
            <div class="modal-body">
                <div class="row"> 
                    <?php $tdate=date("Y-m-d");?>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="visit_date" placeholder="Task Date" name="visit_date" required max="{{$tdate}}" value="{{$tdate}}">
                            <label for="visit_date">Visit Date<sup class="text-danger">*</sup></label>
                            <span class="text-danger error" id="vderror"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6" style="margin-top: -5px">
                        <div class="form-group mb-3">
                            <label for="project_type" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Project Type<sup class="text-danger">*</sup></label>
                            <select class="form-control select2" id="project_type" required name="project_type">
                                <option value="" disabled selected>Select</option>
                                    <option value="Architecture">Architecture</option>
                                    <option value="Interior">Interior</option>
                                    <option value="Landscape">Landscape</option>
                                    <option value="Sustainable">Sustainable</option>
                                    <option value="Urban Design">Urban Design</option>
                            </select>
                            <span class="text-danger error" id="pterror"></span>
                        </div>
                    </div>
                  
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="form-group mb-3">
                            <label for="pr_id" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Select Project</label>
                            <select class="form-control select2" id="pr_id" name="pr_id">
                            
                            </select>
                            <span class="text-danger error" id="vpiperror"></span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="stage_contr" placeholder="Enter Stage of Construction" name="stage_contr" required onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="50">
                            <label for="stage_contr">Stage of Construction<sup class="text-danger">*</sup></label>
                            <span class="text-danger error" id="scerror"></span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="attendees" placeholder="Enter Attendees" name="attendees" required onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="50">
                            <label for="attendees">Attendees</label>
                            <span class="text-danger error" id="aterror"></span>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@include('common.delete_modal')    
@stop
@push('datatable_js')
    {!! Html::script('assets/libs/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') !!}
    {!! Html::script('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') !!}
    <script>
        $(document).ready(function(){
            $('#ar_datatable').dataTable();     
            $('#in_datatable').dataTable();  
            $('#la_datatable').dataTable();  
            $('#sa_datatable').dataTable();  
            $('#ud_datatable').dataTable();  

        });
    </script>
@endpush

@push('page_js')
{!! Html::script('assets/libs/select2/js/select2.min.js') !!}

<script>
    $(document).ready(function(){
        var $body = $("body");
        // $('#project_type,#task_project,#team_member,#task_status').select2();

        $('#project_type,#pr_id').select2({
            dropdownParent: $('#addModal')
        });
    });

    var $body = $("body");

   

    getVisits();
    function getVisits(){

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('get_visits')}}",
            type :'get',
            data : {},
            cache: false,
            dataType: 'json',                 
            success:function(data){
                console.log(data);
                $("#ar_datatable").DataTable().destroy();
                $("#in_datatable").DataTable().destroy();
                $("#la_datatable").DataTable().destroy();
                $("#sa_datatable").DataTable().destroy();
                $("#ud_datatable").DataTable().destroy();

                content ="";
                content1 ="";
                content2 ="";
                content3="";
                content4="";

                var i=j=k=l=m=0;        
                     
                $.each(data.data,function(index,row){
                    //date convert into dd/mm/yyyy
                    function formatDate (input) {
                        var datePart = input.match(/\d+/g),
                        year = datePart[0].substring(0), // get only two digits
                        month = datePart[1], day = datePart[2];
                        return day+'-'+month+'-'+year;
                    }

                    if(row.visit_date != null){
                        var visit_date = formatDate (row.visit_date); // "18/01/10"
                    }else{
                        var visit_date = " - "
                    }
             
                    if(row.project_type == "Architecture")
                    {
                        content +="<tr>";
                        content +="<td>"+ ++i  +"</td>";
                        content +="<td>"+visit_date+"</td>";
                        
                        content +="<td>";
                            content +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-visit_date='"+row.visit_date+"' data-pr_id='"+row.pr_id+"' data-project_type='"+row.project_type+"' data-stage_contr='"+row.stage_contr+"' href='edit_visit/"+row.id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                        content += "</td>";
                        content +="<td>"+row.name+"</td>";
                        content +="<td>"+row.project_name+"</td>";
                        if(row.contractor != null){
                            content +="<td>"+row.contractor+"</td>";
                        }else{
                            content +="<td>-</td>";
                        }

                        content +="<td>"+row.stage_contr+"</td>";
                        if(row.attendees != null){
                            content +="<td>"+row.attendees+"</td>";
                        }else{
                            content +="<td>-</td>";
                        }

                        content += "</tr>";

                    }

                    if(row.project_type == "Interior")
                    {
                        content1 +="<tr>";
                        content1 +="<td>"+ ++i  +"</td>";
                        content1 +="<td>"+visit_date+"</td>";
                        
                        content1 +="<td>";
                            content1 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-visit_date='"+row.visit_date+"' data-pr_id='"+row.pr_id+"' data-project_type='"+row.project_type+"' data-stage_contr='"+row.stage_contr+"' href='edit_visit/"+row.id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content1 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                        content1 += "</td>";
                        content1 +="<td>"+row.name+"</td>";
                        content1 +="<td>"+row.project_name+"</td>";
                        if(row.contractor != null){
                            content1 +="<td>"+row.contractor+"</td>";
                        }else{
                            content1 +="<td>-</td>";
                        }
                        content1 +="<td>"+row.stage_contr+"</td>";
                        if(row.attendees != null){
                            content1 +="<td>"+row.attendees+"</td>";
                        }else{
                            content1 +="<td>-</td>";
                        }
                        content1 += "</tr>";

                        
                    }
                    
                    if(row.project_type == "Landscape")
                    {
                        content2 +="<tr>";
                        content2 +="<td>"+ ++i  +"</td>";
                        content2 +="<td>"+visit_date+"</td>";
                        
                        content2 +="<td>";
                            content2 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-visit_date='"+row.visit_date+"' data-pr_id='"+row.pr_id+"' data-project_type='"+row.project_type+"' data-stage_contr='"+row.stage_contr+"' href='edit_visit/"+row.id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content2 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                        content2 += "</td>";
                        content2 +="<td>"+row.name+"</td>";
                        content2 +="<td>"+row.project_name+"</td>";
                        if(row.contractor != null){
                            content2 +="<td>"+row.contractor+"</td>";
                        }else{
                            content2 +="<td>-</td>";
                        }
                        content2 +="<td>"+row.stage_contr+"</td>";
                        if(row.attendees != null){
                            content2 +="<td>"+row.attendees+"</td>";
                        }else{
                            content2 +="<td>-</td>";
                        }
               
                        content2 += "</tr>";

                        
                    }

                    if(row.project_type == "Sustainable")
                    {
                        content3 +="<tr>";
                        content3 +="<td>"+ ++i  +"</td>";
                        content3 +="<td>"+visit_date+"</td>";
                        
                        content3 +="<td>";
                            content3 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-visit_date='"+row.visit_date+"' data-pr_id='"+row.pr_id+"' data-project_type='"+row.project_type+"' data-stage_contr='"+row.stage_contr+"' href='edit_visit/"+row.id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content3 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                        content3 += "</td>";
                        content3 +="<td>"+row.name+"</td>";
                        content3 +="<td>"+row.project_name+"</td>";
                        if(row.contractor != null){
                            content3 +="<td>"+row.contractor+"</td>";
                        }else{
                            content3 +="<td>-</td>";
                        }
                        content3 +="<td>"+row.stage_contr+"</td>";
                        if(row.attendees != null){
                            content3 +="<td>"+row.attendees+"</td>";
                        }else{
                            content3 +="<td>-</td>";
                        }
                        content3 += "</tr>";

                        
                    }

                    if(row.project_type == "Urban Design")
                    {
                        content4 +="<tr>";
                        content4 +="<td>"+ ++i  +"</td>";
                        content4 +="<td>"+visit_date+"</td>";
                        
                        content4 +="<td>";
                            content4 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-visit_date='"+row.visit_date+"' data-pr_id='"+row.pr_id+"' data-project_type='"+row.project_type+"' data-stage_contr='"+row.stage_contr+"' href='edit_visit/"+row.id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content4 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                        content4 += "</td>";
                        content4 +="<td>"+row.name+"</td>";
                        content4 +="<td>"+row.project_name+"</td>";
                        if(row.contractor != null){
                            content4 +="<td>"+row.contractor+"</td>";
                        }else{
                            content4 +="<td>-</td>";
                        }
                        content4 +="<td>"+row.stage_contr+"</td>";
                        if(row.attendees != null){
                            content4 +="<td>"+row.attendees+"</td>";
                        }else{
                            content4 +="<td>-</td>";
                        }
                        content4 += "</tr>";

                        
                    }
                 
                });
                
                $("#ar_records").html(content); //For append html data
                $('#ar_datatable').dataTable();

                $("#in_records").html(content1); //For append html data
                $('#in_datatable').dataTable();

                $("#la_records").html(content2); //For append html data
                $('#la_datatable').dataTable();

                $("#sa_records").html(content3); //For append html data
                $('#sa_datatable').dataTable();

                $("#ud_records").html(content4); //For append html data
                $('#ud_datatable').dataTable();

            }
        });
    }

    //For set/unset select field
    $('.nav-tabs a[href="#ar_list"]').click(function()
    {
        getVisits();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#in_list"]').click(function()
    {
        getVisits();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#la_list"]').click(function()
    {
        getVisits();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#sa_list"]').click(function()
    {
        getVisits();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#ud_list"]').click(function()
    {
        getVisits();
    });

    // get projects from project type wise
    $('#project_type').change(function(e)
    {
        var project_type = $(this).val(); 
        // alert(project_type);
        $("#pr_id").empty();
        // $("#att_records").prop('disabled', true);
        $.ajax({    
            url:"{{url('get-conv-project')}}",
            type :'get',
            data : {project_type:project_type},
            async: true,
            cache: true,
            dataType: 'json',
            success: function(response) 
            {
                console.log(response);

                //get project type wise project records
                $('#pr_id').append("<option value='all' class='text-muted' selected disabled>"+'Select'+"</option>");

                $.each(response.data,function(index,row){

                    //get project type wise project records
                    $('#pr_id').append("<option value='"+row.id+"'>"+row.converted_no+" ("+row.project_name+")</option>");
                                    
                });
            },
            complete:function(response){
                // For Button Loader
                // $("#att_records").prop('disabled', false); 
                // $("#labours").prop('disabled', false);
                
            }
        });

    });

    // Record delete Confirmation Modal 
    $(document).on("click",'.delI',function()
    {
        var id = $(this).data('id');
        $('#id').val(id);
        // $('#delete_record_modal form').attr("action","delete_so/"+id);
        $('#delete_record_modal').modal('show');
    });

    // For delete Record
    $(document).on("click",'#del_rec',function()
    {           
        var id= $('#id').val();
        // alert(id);

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('delete-task')}}",
            type :'get',
            data : {id:id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  

                    $("#id").val('');
                    getVisits();
                    $("#delete_record_modal").modal("hide");

                    //For Notification
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.showEasing= 'swing';
                    toastr.options.hideEasing= 'linear';
                    toastr.options.showMethod= 'fadeIn';
                    toastr.options.hideMethod= 'fadeOut';
                    toastr.options.closeButton= true;
                    toastr.success(response.message);
        
                }else{

                    //For Notification
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.showEasing= 'swing';
                    toastr.options.hideEasing= 'linear';
                    toastr.options.showMethod= 'fadeIn';
                    toastr.options.hideMethod= 'fadeOut';
                    toastr.options.closeButton= true;
                    toastr.error(response.message);
                }
            }
        });
        
        
    });

</script>
@endpush