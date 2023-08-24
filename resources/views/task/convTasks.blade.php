@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
    $roles=Session::get('ROLES');
    $role=explode(',',$roles);
    $count=count($role);
?>
@section('title',"Converted Project Task | $title")
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
                           <h4 class="card-title mb-4">Converted Project Taskssss</h4>
                           <div class="ms-auto">
                                <!-- <button type="button" class="btn btn-primary btn-sm waves-effect waves-light w-sm" data-bs-toggle="modal" data-bs-target="#addModal" style="margin-left: 10px;">
                                <i class="mdi mdi-plus font-size-11"></i> Add OA
                                </button>  -->
                            </div>
                        </div>
             
                        @include('common.alert')
                        <div id="alerts">
                        </div>
                       
                      
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#ar_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Architecture List</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#in_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Interior List</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#la_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Landscape List</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#sa_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Sustainable List</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ud_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Urban Design List</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#update_task" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">ADD / Update Task</span> 
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
                                                <th scope="col" style="width: 100px">Enquiry No</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="width: 100px">Status</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Task Date</th>
                                                <th scope="col" style="width: 100px">End Date</th>
                                                <th scope="col" style="width: 100px">Task Remark</th>
                                                <th scope="col" style="width: 100px">Who Assigned</th>
                                                <th scope="col" style="width: 100px">Team Member</th>
                                                <th scope="col" style="width: 100px">Team Member Remark</th>
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
                                                <th scope="col" style="width: 100px">Enquiry No</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="width: 100px">Status</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Task Date</th>
                                                <th scope="col" style="width: 100px">End Date</th>
                                                <th scope="col" style="width: 100px">Task Remark</th>
                                                <th scope="col" style="width: 100px">Who Assigned</th>
                                                <th scope="col" style="width: 100px">Team Member</th>
                                                <th scope="col" style="width: 100px">Team Member Remark</th>
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
                                                <th scope="col" style="width: 100px">Enquiry No</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="width: 100px">Status</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Task Date</th>
                                                <th scope="col" style="width: 100px">End Date</th>
                                                <th scope="col" style="width: 100px">Task Remark</th>
                                                <th scope="col" style="width: 100px">Who Assigned</th>
                                                <th scope="col" style="width: 100px">Team Member</th>
                                                <th scope="col" style="width: 100px">Team Member Remark</th>
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
                                                <th scope="col" style="width: 100px">Enquiry No</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="width: 100px">Status</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Task Date</th>
                                                <th scope="col" style="width: 100px">End Date</th>
                                                <th scope="col" style="width: 100px">Task Remark</th>
                                                <th scope="col" style="width: 100px">Who Assigned</th>
                                                <th scope="col" style="width: 100px">Team Member</th>
                                                <th scope="col" style="width: 100px">Team Member Remark</th>
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
                                                <th scope="col" style="width: 100px">Enquiry No</th>
                                                <th scope="col">Action</th>
                                                <th scope="col" style="width: 100px">Status</th>
                                                <th scope="col" style="white-space: normal;">Project Name</th>
                                                <th scope="col" style="width: 100px">Task Date</th>
                                                <th scope="col" style="width: 100px">End Date</th>
                                                <th scope="col" style="width: 100px">Task Remark</th>
                                                <th scope="col" style="width: 100px">Who Assigned</th>
                                                <th scope="col" style="width: 100px">Team Member</th>
                                                <th scope="col" style="width: 100px">Team Member Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ud_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="update_task" role="tabpanel">
                                {!! Form::open(['class'=>"form-horizontal enq_form",'enctype'=>'multipart/form-data','files' => 'true','id'=>'postOAForm']) !!}

                                    <input type="hidden" name="edit_id" id="edit_id" value="">
                                    <input type="hidden" name="role" id="role" value="{{$roles}}">
                                    <!-- <input type="hidden" name="oa_type" id="oa_type" value="normal">   -->
                                    <div class="row role_wise">
                                        <div class="col-md-2 col-sm-12 col-lg-2" style="margin-top: -5px">
                                            <div class="form-group mb-3">
                                                <label for="project_type" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Project Type<sup class="text-danger">*</sup></label>
                                                <select class="form-control select2" id="project_type" required name="project_type">
                                                    <option value="" disabled selected>Select</option>
                                                        <option value="Architecture">Architecture</option>
                                                        <option value="Interior">Interior</option>
                                                        <option value="Landscape">Landscape</option>
                                                        <option value="Sustainable">Sustainable</option>
                                                </select>
                                                <span class="text-danger error" id="pterror"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-5 col-sm-12 col-lg-5 task_project">
                                            <div class="form-group mb-3">
                                                <label for="task_project" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Select Project</label>
                                                <select class="form-control select2" id="task_project" name="task_project">
                                                
                                                </select>
                                                <span class="text-danger error" id="tperror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-lg-3 project_name">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="project_name" placeholder="Enter Project Name" name="project_name" required onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="50" disabled>
                                                <label for="project_name">Enq No - Project Name<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="pnerror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-12 col-lg-3">
                                            <div class="form-group mb-3">
                                                <label for="team_member" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Select Team Member</label>
                                                <select class="form-control select2" id="team_member" name="team_member">
                                                
                                                </select>
                                                <span class="text-danger error" id="tmerror"></span>
                                            </div>
                                        </div>
                                        
                                        <?php $tdate=date("Y-m-d");?>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="task_date" placeholder="Task Date" name="task_date" required max="{{$tdate}}" value="{{$tdate}}">
                                                <label for="task_date">Task Date<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="tderror"></span>
                                            </div>
                                        </div>

                                        <?php $tdate=date("Y-m-d");?>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="end_date" placeholder="Task End Date" name="end_date" required max="{{$tdate}}" value="{{$tdate}}">
                                                <label for="end_date">Task End Date<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="ederror"></span>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-5 col-sm-12 col-lg-5">
                                            <div class="form-group mb-3">
                                                <label for="task_remark">Task Remark</label>
                                                <textarea class="form-control " id="task_remark" name="task_remark" rows="2" placeholder="Enter Task Remark" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);"></textarea>
                                                <span class="text-danger error" id="trerror"></span>
                                            </div>  
                                        </div>

                                        <div class="col-md-5 col-sm-12 col-lg-5 emp_remark">
                                            <div class="form-group mb-3">
                                                <label for="emp_remark">Team Member Remark</label>
                                                <textarea class="form-control " id="emp_remark" name="emp_remark" rows="2" placeholder="Enter Remark" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);"></textarea>
                                                <span class="text-danger error" id="ererror"></span>
                                            </div>  
                                        </div>

                                        <div class="col-md-2 col-sm-12 col-lg-2" style="margin-top: -5px">
                                            <div class="form-group mb-3">
                                                <label for="task_status" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Project Status<sup class="text-danger">*</sup></label>
                                                <select class="form-control select2" id="task_status" required name="task_status">
                                                    <option value="" disabled selected>Select</option>
                                                 
                                                        <option value="Alloted">Alloted</option>
                                                        @if($roles != 0)
                                                            <option value="In Process">In Process</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Completed">Completed</option>
                                                        @endif
                                                </select>
                                                <span class="text-danger error" id="tserror"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="d-sm-flex flex-wrap">
                                        <h4 class="card-title mb-4"></h4>
                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-primary waves-effect waves-light submit_btn" id="add_task"><i class="bx font-size-16 align-middle me-2 add_task"></i>Add</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    

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
        $('#project_type,#task_project,#team_member,#task_status').select2();
    });

    var $body = $("body");

    $('.nav-tabs a[href="#update_task"]').click(function(){
       
        $('.enq_form')[0].reset();
        $('#edit_id').val('');               
        $('#task_project,#team_member').empty();
        $("#task_status").val("").trigger("change"); 
        $("#project_type").val("").trigger("change");   
        $('.task_project').show();
        $('.project_name').hide();
        $('.emp_remark').hide();
        // $('.role_wise').hide();

        $('#project_type,#team_member').prop('disabled', false);
        getTask();
        

    });

    //For set/unset select field
    $('.nav-tabs a[href="#ar_list"]').click(function()
    {
        $('#task_project,#team_member').empty();
        $("#task_status").val("").trigger("change"); 
        $("#project_type").val("").trigger("change");   
        $('.task_project').show();
        $('.project_name').hide();
        $('#project_type,#team_member').prop('disabled', false);

        getTask();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#in_list"]').click(function()
    {
        $('#task_project,#team_member').empty();
        $("#task_status").val("").trigger("change"); 
        $("#project_type").val("").trigger("change");  
        $('.task_project').show();
        $('.project_name').hide(); 
        $('#project_type,#team_member').prop('disabled', false);

        getTask();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#la_list"]').click(function()
    {
        $('#task_project,#team_member').empty();
        $("#task_status").val("").trigger("change"); 
        $("#project_type").val("").trigger("change");
        $('.task_project').show();
        $('.project_name').hide();   
        $('#project_type,#team_member').prop('disabled', false);

        getTask();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#sa_list"]').click(function()
    {
        $('#task_project,#team_member').empty();
        $("#task_status").val("").trigger("change"); 
        $("#project_type").val("").trigger("change");  
        $('.task_project').show();
        $('.project_name').hide();
        $('#project_type,#team_member').prop('disabled', false);

        getTask();
    });

    //For set/unset select field
    $('.nav-tabs a[href="#ud_list"]').click(function()
    {
        $('#pr_head_conceptual,#team_member_conceptual,#pr_head_working,#team_member_working,#supervisor').empty();
        $("#enq_status").val("").trigger("change"); 
        $("#project_type").val("").trigger("change"); 
        $('.project_fields').hide();
        $('.task_project').show();
        $('.project_name').hide();
        $('#project_type,#team_member').prop('disabled', false);

        getTask();
    });

    getTask();
    function getTask(){

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('get-conv-tasks')}}",
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
             
                    if(row.project_type == "Architecture")
                    {
                        content +="<tr>";
                        content +="<td>"+ ++i  +"</td>";
                        content +="<td>"+row.enquiry_no+"</td>";
                        
                        content +="<td>";
                            content +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-project_type='"+row.project_type+"' data-enq_pr_id='"+row.enq_pr_id+"' data-team_member='"+row.team_member+"' data-task_date='"+row.task_date+"' data-end_date='"+row.end_date+"' data-task_remark='"+row.task_remark+"' data-employee_remark='"+row.employee_remark+"' data-task_status='"+row.task_status+"' data-enquiry_no='"+row.enquiry_no+"' data-project_name='"+row.project_name+"' data-et_aid='"+row.et_aid+"'  data-uid='"+row.uid+"' data-au_id='"+data.au_id+"' data-assign_id='"+row.assign_id+"'><i class='far fa-edit'></i></a> ";

                            if(data.roles == 0)
                            {
                                content +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                            
                        content += "</td>";
                    
                        if(row.task_status == "Alloted"){
                            content +="<td><span class='badge badge-soft-primary'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "In Process"){
                            content +="<td><span class='badge badge-soft-warning'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Pending"){
                            content +="<td><span class='badge badge-soft-danger'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Completed"){
                            content +="<td><span class='badge badge-soft-success'>"+row.task_status+"</span></td>";
                        }
                        content +="<td>"+row.project_name+"</td>";
                        content +="<td>"+row.task_date+"</td>";
                        content +="<td>"+row.end_date+"</td>";
                        content +="<td>"+row.task_remark+"</td>";
                        content +="<td>"+row.assign_name+"</td>";
                        content +="<td>"+row.name+"</td>";
                        if(row.employee_remark != null){
                            content +="<td>"+row.employee_remark+"</td>";
                        }else{
                            content +="<td> - </td>";
                        }
                        content += "</tr>";

                    }

                    if(row.project_type == "Interior")
                    {
                        content1 +="<tr>";
                        content1 +="<td>"+ ++j  +"</td>";
                        content1 +="<td>"+row.enquiry_no+"</td>";
                        
                        content1 +="<td>";
                            content1 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-project_type='"+row.project_type+"' data-enq_pr_id='"+row.enq_pr_id+"' data-team_member='"+row.team_member+"' data-task_date='"+row.task_date+"' data-end_date='"+row.end_date+"' data-task_remark='"+row.task_remark+"' data-task_status='"+row.task_status+"' data-enquiry_no='"+row.enquiry_no+"' data-project_name='"+row.project_name+"' data-et_aid='"+row.et_aid+"' data-uid='"+row.uid+"' data-assign_id='"+row.assign_id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content1 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                            
                        conten1 += "</td>";
                    
                        if(row.task_status == "Alloted"){
                            content1 +="<td><span class='badge badge-soft-primary'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "In Process"){
                            content1 +="<td><span class='badge badge-soft-warning'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Pending"){
                            content1 +="<td><span class='badge badge-soft-danger'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Completed"){
                            content1 +="<td><span class='badge badge-soft-success'>"+row.task_status+"</span></td>";
                        }
                        content1 +="<td>"+row.project_name+"</td>";
                        content1 +="<td>"+row.task_date+"</td>";
                        content1 +="<td>"+row.end_date+"</td>";
                        content1 +="<td>"+row.task_remark+"</td>";
                        content1 +="<td>"+row.assign_name+"</td>";
                        content1 +="<td>"+row.name+"</td>";
                        if(row.employee_remark != null){
                            content1 +="<td>"+row.employee_remark+"</td>";
                        }else{
                            content1 +="<td> - </td>";
                        }
                        content1 += "</tr>";
                        
                    }

                    if(row.project_type == "Landscape")
                    {
                        content2 +="<tr>";
                        content2 +="<td>"+ ++k  +"</td>";
                        content2 +="<td>"+row.enquiry_no+"</td>";
                        
                        content2 +="<td>";
                            content2 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-project_type='"+row.project_type+"' data-enq_pr_id='"+row.enq_pr_id+"' data-team_member='"+row.team_member+"' data-task_date='"+row.task_date+"' data-end_date='"+row.end_date+"' data-task_remark='"+row.task_remark+"' data-task_status='"+row.task_status+"' data-enquiry_no='"+row.enquiry_no+"' data-project_name='"+row.project_name+"' data-et_aid='"+row.et_aid+"' data-uid='"+row.uid+"' data-assign_id='"+row.assign_id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content2 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                            
                        content2 += "</td>";
                    
                        if(row.task_status == "Alloted"){
                            content2 +="<td><span class='badge badge-soft-primary'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "In Process"){
                            content2 +="<td><span class='badge badge-soft-warning'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Pending"){
                            content2 +="<td><span class='badge badge-soft-danger'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Completed"){
                            content2 +="<td><span class='badge badge-soft-success'>"+row.task_status+"</span></td>";
                        }
                        content2 +="<td>"+row.project_name+"</td>";
                        content2 +="<td>"+row.task_date+"</td>";
                        content2 +="<td>"+row.end_date+"</td>";
                        content2 +="<td>"+row.task_remark+"</td>";
                        content2 +="<td>"+row.assign_name+"</td>";
                        content2 +="<td>"+row.name+"</td>";
                        if(row.employee_remark != null){
                            content2 +="<td>"+row.employee_remark+"</td>";
                        }else{
                            content2 +="<td> - </td>";
                        }
                        content2 += "</tr>";
                        
                    }
                    
                    if(row.project_type == "Sustainable")
                    {
                        content3 +="<tr>";
                        content3 +="<td>"+ ++l  +"</td>";
                        content3 +="<td>"+row.enquiry_no+"</td>";
                        
                        content3 +="<td>";
                            content3 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-project_type='"+row.project_type+"' data-enq_pr_id='"+row.enq_pr_id+"' data-team_member='"+row.team_member+"' data-task_date='"+row.task_date+"' data-end_date='"+row.end_date+"' data-task_remark='"+row.task_remark+"' data-task_status='"+row.task_status+"' data-enquiry_no='"+row.enquiry_no+"' data-project_name='"+row.project_name+"' data-et_aid='"+row.et_aid+"' data-uid='"+row.uid+"' data-assign_id='"+row.assign_id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content3 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                            
                        content3 += "</td>";
                    
                        if(row.task_status == "Alloted"){
                            content3 +="<td><span class='badge badge-soft-primary'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "In Process"){
                            content3 +="<td><span class='badge badge-soft-warning'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Pending"){
                            content3 +="<td><span class='badge badge-soft-danger'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Completed"){
                            content3 +="<td><span class='badge badge-soft-success'>"+row.task_status+"</span></td>";
                        }
                        content3 +="<td>"+row.project_name+"</td>";
                        content3 +="<td>"+row.task_date+"</td>";
                        content3 +="<td>"+row.end_date+"</td>";
                        content3 +="<td>"+row.task_remark+"</td>";
                        content3 +="<td>"+row.assign_name+"</td>";
                        content3 +="<td>"+row.name+"</td>";
                        if(row.employee_remark != null){
                            content3 +="<td>"+row.employee_remark+"</td>";
                        }else{
                            content3 +="<td> - </td>";
                        }
                        content3 += "</tr>";
                        
                    }

                    if(row.project_type == "Urban Design")
                    {
                        content4 +="<tr>";
                        content4 +="<td>"+ ++m  +"</td>";
                        content4 +="<td>"+row.enquiry_no+"</td>";
                        
                        content4 +="<td>";
                            content4 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Task' data-id='"+row.id+"' data-project_type='"+row.project_type+"' data-enq_pr_id='"+row.enq_pr_id+"' data-team_member='"+row.team_member+"' data-task_date='"+row.task_date+"' data-end_date='"+row.end_date+"' data-task_remark='"+row.task_remark+"' data-task_status='"+row.task_status+"' data-enquiry_no='"+row.enquiry_no+"' data-project_name='"+row.project_name+"' data-et_aid='"+row.et_aid+"' data-uid='"+row.uid+"' data-assign_id='"+row.assign_id+"'><i class='far fa-edit'></i></a> ";
                            if(data.roles == 0){
                                content4 +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Task' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                            }
                           
                            
                        content4 += "</td>";
                    
                        if(row.task_status == "Alloted"){
                            content4 +="<td><span class='badge badge-soft-primary'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "In Process"){
                            content4 +="<td><span class='badge badge-soft-warning'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Pending"){
                            content4 +="<td><span class='badge badge-soft-danger'>"+row.task_status+"</span></td>";
                        }
                        else if(row.task_status == "Completed"){
                            content4 +="<td><span class='badge badge-soft-success'>"+row.task_status+"</span></td>";
                        }
                        content4 +="<td>"+row.project_name+"</td>";
                        content4 +="<td>"+row.task_date+"</td>";
                        content4 +="<td>"+row.end_date+"</td>";
                        content4 +="<td>"+row.task_remark+"</td>";
                        content4 +="<td>"+row.assign_name+"</td>";
                        content4 +="<td>"+row.name+"</td>";
                        if(row.employee_remark != null){
                            content4 +="<td>"+row.employee_remark+"</td>";
                        }else{
                            content4 +="<td> - </td>";
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
                
                //For Add enquiry
                $('#team_member').append("<option value='' class='text-muted' selected disabled>"+'Select'+"</option>");
                // $('#labour').append("<option value='' class='text-muted' >"+'All'+"</option>");

                $.each(data.u_obj,function(index,row){
                    //For Add enquiry
                    $('#team_member').append("<option value='"+row.id+"'>"+row.name+"</option>");
                   
                });

                $('#task_remark,#task_date,#end_date').prop('readonly', false);
                if(data.roles == 2 || data.roles == 3)
                {
                    $('.role_wise').hide();
                    $('.emp_remark').show();
                    $('#project_type,#team_member,#task_date,#end_date,#task_remark').prop('disabled', true);
                }
            }
        });
    }

    // Task Form Validation
    var n =0;
    $("#add_task").click(function(event) 
    {
        // alert('hi');
        var project_type = $('#project_type').val();
        var task_project= $('#task_project').val();
        var team_member = $('#team_member').val();

        var task_date= $('#task_date').val();
        var end_date= $('#end_date').val();
        
        var task_remark = $('#task_remark').val();
        var emp_remark = $('#emp_remark').val();
        var task_status = $('#task_status').val();
       
        
        n=0;    
        if( $.trim(task_project).length == 0 )
        {
            $('#tperror').text('Please Select Project Name.');
            event.preventDefault();
        }else{
            $('#tperror').text('');
            ++n;
        }

        if( $.trim(team_member).length == 0 )
        {
            $('#tmerror').text('Please Select Team Member.');
            event.preventDefault();
        }else{
            $('#tmerror').text('');
            ++n;
        }

        if( $.trim(task_date).length == 0 )
        {
            $('#tderror').text('Please Select Date.');
            event.preventDefault();
        }else{
            $('#tderror').text('');
            ++n;
        }

        if( $.trim(end_date).length == 0 )
        {
            $('#ederror').text('Please Select Date');
            event.preventDefault();
        }else{
            $('#ederror').text('');
            ++n;
        }

        if( $.trim(project_type).length == 0 )
        {
            $('#pterror').text('Please Select Project Type.');
            event.preventDefault();
        }else{
            $('#pterror').text('');
            ++n;
        }
       
        if( $.trim(task_remark).length == 0 )
        {
            $('#trerror').text('Please Enter Reamrk.');
            event.preventDefault();
        }else{
            $('#trerror').text('');
            ++n;
        }
      
        if( $.trim(emp_remark).length == 0 )
        {
            $('#ererror').text('Please Enter Reamrk.');
            event.preventDefault();
        }else{
            $('#ererror').text('');
            ++n;
        }
       
        if( $.trim(task_status).length == 0 )
        {
            $('#tserror').text('Please Select Status.');
            event.preventDefault();
        }else{
            $('#tserror').text('');
            ++n;
        }
    });

    // For Add Task
    $(document).on("click",'#add_task',function()
    {      
        var edit_id= $('#edit_id').val();
        var role= $('#role').val();
        var emp_remark = $('#emp_remark').val();

        if(edit_id != ""){
            if(role == 2 || role == 3 || role == 1)
            {
                if(emp_remark == "")
                {
                    m = 6;
                }else{
                    m = 7;
                }
            }else{
                m = 6;
            }
        }
        else{
            m = 7;
        }
        // alert(n);
        if(n == m)
        {                   
            var project_type = $('#project_type').val();
            var task_project= $('#task_project').val();
            var team_member = $('#team_member').val();

            var task_date= $('#task_date').val();
            var end_date= $('#end_date').val();
            
            var task_remark = $('#task_remark').val();
            var emp_remark = $('#emp_remark').val();
            var task_status = $('#task_status').val();

            $(".add_task").addClass("bx-loader bx-spin");
            $("#add_task").prop('disabled', true);
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('post_conv_task')}}",
                type :'post',
                data : {edit_id:edit_id,project_type:project_type,task_project:task_project,team_member:team_member,task_date:task_date,end_date:end_date,task_remark:task_remark,task_status:task_status,emp_remark:emp_remark},
                async: false,
                cache: true,
                dataType: 'json',
                success:function(response){
                    console.log(response);

                    if (response.status==true) {  

                        $('.enq_form')[0].reset();
                        $('#task_project,#team_member').empty();
                        $("#task_status").val("").trigger("change"); 
                        $("#project_type").val("").trigger("change");           
                        $('.task_project').show();
                        $('.project_name').hide();
                        $('#project_type,#team_member').prop('disabled', false);

                        getTask();

                        // ACTIVE PANE AND LINK
                        $('.nav-tabs a[href="#ar_list"]').tab('show');
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
                },
                complete:function(data){
                    // Hide image container
                    $(".add_task").removeClass("bx-loader bx-spin");
                    $("#add_task").prop('disabled', false);
                   
                }
            });
        }
        
    });  


    // get projects from project type wise
    $('#project_type').change(function(e)
    {
        var project_type = $(this).val(); 
        // alert(project_type);
        $("#task_project").empty();
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
                $('#task_project').append("<option value='all' class='text-muted' selected disabled>"+'Select'+"</option>");

                $.each(response.data,function(index,row){

                    //get project type wise project records
                    $('#task_project').append("<option value='"+row.id+"'>"+row.enquiry_no+" ("+row.project_name+")</option>");
                                    
                });
            },
            complete:function(response){
                // For Button Loader
                // $("#att_records").prop('disabled', false); 
                // $("#labours").prop('disabled', false);
                
            }
        });

    });

    function getMember(task_project){

        $("#team_member").empty();

        $.ajax({    
            url:"{{url('get-convteam-member')}}",
            type :'get',
            data : {task_project:task_project},
            async: true,
            cache: true,
            dataType: 'json',
            success: function(response) 
            {
                console.log(response);

                //get project type wise project records
                $('#team_member').append("<option value='all' class='text-muted' selected disabled>"+'Select'+"</option>");

                $.each(response.u_id,function(index,row){

                    //get project type wise project records
                    $('#team_member').append("<option value='"+row.id+"'>"+row.name+"</option>");
                                    
                });
            },
            complete:function(response){
                // For Button Loader
                // $("#att_records").prop('disabled', false); 
                // $("#labours").prop('disabled', false);
                
            }
        });
    }

    // get team member project wise 
    $('#task_project').change(function(e)
    {
        var task_project = $(this).val(); 
        // alert(project_type);
       
        // $("#att_records").prop('disabled', true);
        getMember(task_project);

    });

    // Edit Record
    $(document).on("click",'.editU',function()
    {
        var id = $(this).data('id');
        var au_id = $(this).data('au_id');
        var assign_id = $(this).data('assign_id');
        var role= $('#role').val();
        $('#add_task').show();

        if(au_id == assign_id){
            $('.emp_remark').hide();
            $('#task_remark,#task_date,#end_date').prop('readonly', false);
        }else{
        
            $('.emp_remark').show();

            if(role == 0){
                $('#task_remark,#task_date,#end_date,#emp_remark').prop('readonly', true);
                $('#add_task').hide();
            }else{
                $('#task_remark,#task_date,#end_date').prop('readonly', true);

            }
           
        }
        // $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
        // getTask();
        if(id !=""){
            $('.task_project').hide();  
            $('.project_name').show(); 
            $('.role_wise').show();
            $('#project_type').prop('disabled', true);
            $('#team_member').prop('disabled', true);

            $('.enq_form')[0].reset();
            // getTask();
            var role= $('#role').val();

            var project_type = $(this).data('project_type');
            var employee_remark = $(this).data('employee_remark');
            var enq_pr_id = $(this).data('enq_pr_id');
            var team_member = $(this).data('team_member');
            var task_date = $(this).data('task_date');
            var end_date = $(this).data('end_date');
            var task_remark = $(this).data('task_remark');
            var task_status = $(this).data('task_status');

            var enquiry_no = $(this).data('enquiry_no');
            var project_name = $(this).data('project_name');
            var enqNo_name = enquiry_no+"   ("+project_name+")";

            // getMember(enq_pr_id);
            // ACTIVE PANE AND LINK
            $('.nav-tabs a[href="#update_task"]').tab('show');

            $('#edit_id').val(id);   
            $('#task_date').val(task_date); 
            $('#end_date').val(end_date); 
            $('#task_remark').val(task_remark);
            $('#emp_remark').val(employee_remark); 
            $('#project_name').val(enqNo_name); 
            $("#project_type").val(project_type).trigger("change");             
            $('#team_member option[value='+team_member+']').attr('selected','selected').change();
            $("#task_status").val(task_status).trigger("change"); 
            $('#task_project option[value='+enq_pr_id+']').attr('selected','selected').change();
        }

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
            url:"{{url('delete-conv-task')}}",
            type :'get',
            data : {id:id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  

                    $("#id").val('');
                    getTask();
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