@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
    $roles=Session::get('ROLES');
    $role=explode(',',$roles);
    $count=count($role);
?>
@section('title',"Project Enquiry| $title")
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
    .dtr-title{
        font-weight: 600;
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
                           <h4 class="card-title mb-4">Project Enquiry</h4>
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
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#update_enquiry" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">ADD / Update</span> 
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
                                                <th scope="col" style="width: 100px">Project Head (Conceptual)</th>
                                                <th scope="col" style="width: 100px">Team Member (Conceptual) </th>
                                                <th scope="col" style="width: 100px">Supervisor</th>
                                                <th scope="col" style="width: 100px">Client Name </th>
                                                <th scope="col" style="width: 100px">Project Address</th>
                                                <th scope="col" style="width: 100px">Client Requirement</th>
                                                <th scope="col" style="width: 100px">Client Documents</th>
                                                <th scope="col" style="width: 100px">Client Phone No</th>
                                                <th scope="col" style="width: 100px">Project Enq Date</th>
                                                <th scope="col" style="width: 100px">Project Type</th>
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
                                                <th scope="col" style="width: 100px">Project Head (Conceptual)</th>
                                                <th scope="col" style="width: 100px">Team Member (Conceptual) </th>
                                                <th scope="col" style="width: 100px">Supervisor</th>
                                                <th scope="col" style="width: 100px">Client Name </th>
                                                <th scope="col" style="width: 100px">Project Address</th>
                                                <th scope="col" style="width: 100px">Client Requirement</th>
                                                <th scope="col" style="width: 100px">Client Documents</th>
                                                <th scope="col" style="width: 100px">Client Phone No</th>
                                                <th scope="col" style="width: 100px">Project Enq Date</th>
                                                <th scope="col" style="width: 100px">Project Type</th>
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
                                                <th scope="col" style="width: 100px">Project Head (Conceptual)</th>
                                                <th scope="col" style="width: 100px">Team Member (Conceptual) </th>
                                                <th scope="col" style="width: 100px">Supervisor</th>
                                                <th scope="col" style="width: 100px">Client Name </th>
                                                <th scope="col" style="width: 100px">Project Address</th>
                                                <th scope="col" style="width: 100px">Client Requirement</th>
                                                <th scope="col" style="width: 100px">Client Documents</th>
                                                <th scope="col" style="width: 100px">Client Phone No</th>
                                                <th scope="col" style="width: 100px">Project Enq Date</th>
                                                <th scope="col" style="width: 100px">Project Type</th>
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
                                                <th scope="col" style="width: 100px">Project Head (Conceptual)</th>
                                                <th scope="col" style="width: 100px">Team Member (Conceptual) </th>
                                                <th scope="col" style="width: 100px">Supervisor</th>
                                                <th scope="col" style="width: 100px">Client Name </th>
                                                <th scope="col" style="width: 100px">Project Address</th>
                                                <th scope="col" style="width: 100px">Client Requirement</th>
                                                <th scope="col" style="width: 100px">Client Documents</th>
                                                <th scope="col" style="width: 100px">Client Phone No</th>
                                                <th scope="col" style="width: 100px">Project Enq Date</th>
                                                <th scope="col" style="width: 100px">Project Type</th>
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
                                                <th scope="col" style="width: 100px">Project Head (Conceptual)</th>
                                                <th scope="col" style="width: 100px">Team Member (Conceptual) </th>
                                                <th scope="col" style="width: 100px">Supervisor</th>
                                                <th scope="col" style="width: 100px">Client Name </th>
                                                <th scope="col" style="width: 100px">Project Address</th>
                                                <th scope="col" style="width: 100px">Client Requirement</th>
                                                <th scope="col" style="width: 100px">Client Documents</th>
                                                <th scope="col" style="width: 100px">Client Phone No</th>
                                                <th scope="col" style="width: 100px">Project Enq Date</th>
                                                <th scope="col" style="width: 100px">Project Type</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ud_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="update_enquiry" role="tabpanel">
                                {!! Form::open(['class'=>"form-horizontal enq_form",'enctype'=>'multipart/form-data','files' => 'true','id'=>'postOAForm']) !!}

                                    <input type="hidden" name="edit_id" id="edit_id" value="">
                                    <input type="hidden" name="role" id="role" value="{{$roles}}">
                                    <!-- <input type="hidden" name="oa_type" id="oa_type" value="normal">   -->
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 col-lg-3">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="project_name" placeholder="Enter Project Name" name="project_name" required onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="50">
                                                <label for="project_name">Project Name<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="pnerror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-lg-3">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="client_name" placeholder="Enter Client Name" name="client_name" required onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="50">
                                                <label for="client_name">Client Name<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="cnerror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="cp_ph_no" placeholder="Enter CP Phone" name="cp_ph_no" required maxlength="10">
                                                <label for="cp_ph_no">Client Phone<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="cperror"></span>
                                            </div>
                                        </div>
                                        <?php $tdate=date("Y-m-d");?>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="enq_date" placeholder="Payment Date" name="enq_date" required max="{{$tdate}}" value="{{$tdate}}">
                                                <label for="enq_date">Enq Date<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="ederror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2" style="margin-top: -5px">
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
                                        
                                        <div class="col-md-12 col-sm-12 col-lg-12 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="client_req" required name="client_req" placeholder="Client Requirement" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="100"></textarea>
                                                <label for="client_req">Client Requirement<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="crerror"></span>

                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-12 col-lg-5 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="project_address" name="project_address" placeholder="Enter Address" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="100"></textarea>
                                                <label for="project_address">Project Address</label>
                                                <span class="text-danger error" id="paerror"></span>

                                            </div>
                                        </div>
                                       
                                        <div class="col-md-5 col-sm-12 col-lg-5 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="client_document" name="client_document" placeholder="Enter Address" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="100"></textarea>
                                                <label for="address">Client Documents</label>
                                                <span class="text-danger error" id="cderror"></span>

                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-group mb-3">
                                                <label for="pr_head_conceptual" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Project Head (Conceptual)</label>
                                                <select class="form-control select2" id="pr_head_conceptual" name="pr_head_conceptual">
                                                
                                                </select>
                                                <span class="text-danger error" id="phcerror"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-5 col-sm-12 col-lg-5">
                                            <div class="form-group mb-3">
                                                <label for="team_member_conceptual" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Team Members (Conceptual)</label>
                                                <select class="select2 form-control" multiple="multiple" data-placeholder="Choose ..." id="team_member_conceptual" name="team_member_conceptual[]" placeholder="Team Member">
                    
                                                </select>
                                                <span class="text-danger error" id="tmcerror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-12 col-lg-5">
                                            <div class="form-group mb-3">
                                                <label for="supervisor" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Site Supervisor</label>
                                                <select class="select2 form-control" multiple="multiple" data-placeholder="Choose ..." id="supervisor" name="supervisor[]" placeholder="Site Supervisor">
                    
                                                </select>
                                                <span class="text-danger error" id="sserror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2" style="margin-top: -5px">
                                            <div class="form-group mb-3">
                                                <label for="enq_status" class="form-label" style="font-size: 11px;margin-bottom: 2px;">Project Status<sup class="text-danger">*</sup></label>
                                                <select class="form-control select2" id="enq_status" required name="enq_status">
                                                    <option value="" disabled selected>Select</option>
                                                        <option value="Enquiry">Enquiry</option>
                                                        <option value="On Hold">On Hold</option>
                                                        <option value="Converted">Converted</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                </select>
                                                <span class="text-danger error" id="pserror"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="d-sm-flex flex-wrap">
                                        <h4 class="card-title mb-4"></h4>
                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-primary waves-effect waves-light" id="add_enq"><i class="bx font-size-16 align-middle me-2 add_enq"></i>Add</button>
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
        $('#project_type,#pr_head_conceptual,#team_member_conceptual,#supervisor,#enq_status').select2();
    });

    var $body = $("body");


    getEnq();
    function getEnq(){

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('get_enq')}}",
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
                content3 ="";
                content4 ="";
                var i=j=k=l=m=0;        
                     
                $.each(data.data,function(index,row){
                    if(row.enq_status != "Converted")
                    {
                        if(row.project_type == "Architecture")
                        {
                            content +="<tr>";
                            content +="<td>"+ ++i  +"</td>";
                            content +="<td>"+row.enquiry_no+"</td>";
                            
                                content +="<td>";
                                content +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Enquiry' data-id='"+row.id+"' data-project_name='"+row.project_name+"' data-client_name='"+row.client_name+"' data-pr_head_conceptual='"+row.pr_head_conceptual+"' data-team_member_conceptual='"+row.team_member_conceptual+"' data-site_supervisor='"+row.site_supervisor+"' data-pr_address='"+row.pr_address+"' data-client_requirement='"+row.client_requirement+"' data-client_document='"+row.client_document+"' data-client_ph_no='"+row.client_ph_no+"' data-enq_date='"+row.enq_date+"' data-project_type='"+row.project_type+"' data-enq_status='"+row.enq_status+"'><i class='far fa-edit'></i></a> <button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Enquiry' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                                
                                content += "</td>";
                        
                            if(row.enq_status == "Enquiry"){
                                content +="<td><span class='badge badge-soft-success'>"+row.enq_status+"</span></td>";
                            }
                            else if(row.enq_status == "On Hold"){
                                content +="<td><span class='badge badge-soft-warning'>"+row.enq_status+"</span></td>";
                            }
                            else if(row.enq_status == "Cancelled"){
                                content +="<td><span class='badge badge-soft-danger'>"+row.enq_status+"</span></td>";
                            }
                            content +="<td>"+row.project_name+"</td>";
                            content +="<td>"+row.pr_head_con_name+"</td>";
                            content +="<td>";
                                $.each(row.tm_obj,function(key,value){
                                    content +=value.name+", ";
                                });
                            content +="</td>";

                            content +="<td>";
                                $.each(row.ss_obj,function(key,value){
                                    content +=value.name+", ";
                                });
                            content +="</td>";
                            // content +="<td>"+row.team_member_conceptual+"</td>";
                            // content +="<td>"+row.site_supervisor+"</td>";
                            content +="<td>"+row.client_name+"</td>";
                            content +="<td>"+row.pr_address+"</td>";
                            content +="<td>"+row.client_requirement+"</td>";
                            content +="<td>"+row.client_document+"</td>";
                            content +="<td>"+row.client_ph_no+"</td>";
                            content +="<td>"+row.enq_date+"</td>";
                            content +="<td>"+row.project_type+"</td>";
                            content += "</tr>";
                        }

                        if(row.project_type == "Interior")
                        {
                            content1 +="<tr>";
                            content1 +="<td>"+ ++j  +"</td>";
                            content1 +="<td>"+row.enquiry_no+"</td>";
                            
                                content1 +="<td>";
                                content1 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Enquiry' data-id='"+row.id+"' data-project_name='"+row.project_name+"' data-client_name='"+row.client_name+"' data-pr_head_conceptual='"+row.pr_head_conceptual+"' data-team_member_conceptual='"+row.team_member_conceptual+"' data-site_supervisor='"+row.site_supervisor+"' data-pr_address='"+row.pr_address+"' data-client_requirement='"+row.client_requirement+"' data-client_document='"+row.client_document+"' data-client_ph_no='"+row.client_ph_no+"' data-enq_date='"+row.enq_date+"' data-project_type='"+row.project_type+"' data-enq_status='"+row.enq_status+"'><i class='far fa-edit'></i></a> <button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Enquiry' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                                
                                if(row.oth_status == 1){
                                    content1 += " <a class='btn btn-outline-secondary btn-sm removeTL'  rel='tooltip' data-bs-placement='top' title='Remove TL' data-oth_so_id='"+row.id+"' data-oth_id='"+row.oth_id+"' data-oth_status='"+row.oth_status+"'><i class='fas fa-ban'></i></a>";
                                }
                                content1 += "</td>";
                        
                            if(row.enq_status == "Enquiry"){
                                content1 +="<td><span class='badge badge-soft-success'>"+row.enq_status+"</span></td>";

                            }
                            else if(row.enq_status == "On Hold"){
                                content1 +="<td><span class='badge badge-soft-warning'>"+row.enq_status+"</span></td>";
                            }
                            else if(row.enq_status == "Cancelled"){
                                content1 +="<td><span class='badge badge-soft-danger'>"+row.enq_status+"</span></td>";
                            }
                            content1 +="<td>"+row.project_name+"</td>";
                            content1 +="<td>"+row.pr_head_con_name+"</td>";
                            content1 +="<td>";
                                $.each(row.tm_obj,function(key,value){
                                    content1 +=value.name+", ";
                                });
                            content1 +="</td>";

                            content1 +="<td>";
                                $.each(row.ss_obj,function(key,value){
                                    content1 +=value.name+", ";
                                });
                            content1 +="</td>";
                            // content1 +="<td>"+row.team_member_conceptual+"</td>";
                            // content1 +="<td>"+row.site_supervisor+"</td>";
                            content1 +="<td>"+row.client_name+"</td>";
                            content1 +="<td>"+row.pr_address+"</td>";
                            content1 +="<td>"+row.client_requirement+"</td>";
                            content1 +="<td>"+row.client_document+"</td>";
                            content1 +="<td>"+row.client_ph_no+"</td>";
                            content1 +="<td>"+row.enq_date+"</td>";
                            content1 +="<td>"+row.project_type+"</td>";
                            content1 += "</tr>";
                        }

                        if(row.project_type == "Landscape")
                        {
                            content2 +="<tr>";
                            content2 +="<td>"+ ++k  +"</td>";
                            content2 +="<td>"+row.enquiry_no+"</td>";
                            
                                content2 +="<td>";
                                content2 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Enquiry' data-id='"+row.id+"' data-project_name='"+row.project_name+"' data-client_name='"+row.client_name+"' data-pr_head_conceptual='"+row.pr_head_conceptual+"' data-team_member_conceptual='"+row.team_member_conceptual+"' data-site_supervisor='"+row.site_supervisor+"' data-pr_address='"+row.pr_address+"' data-client_requirement='"+row.client_requirement+"' data-client_document='"+row.client_document+"' data-client_ph_no='"+row.client_ph_no+"' data-enq_date='"+row.enq_date+"' data-project_type='"+row.project_type+"' data-enq_status='"+row.enq_status+"'><i class='far fa-edit'></i></a> <button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Enquiry' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                                
                                if(row.oth_status == 1){
                                    content2 += " <a class='btn btn-outline-secondary btn-sm removeTL'  rel='tooltip' data-bs-placement='top' title='Remove TL' data-oth_so_id='"+row.id+"' data-oth_id='"+row.oth_id+"' data-oth_status='"+row.oth_status+"'><i class='fas fa-ban'></i></a>";
                                }
                                content2 += "</td>";
                        
                            if(row.enq_status == "Enquiry"){
                                content2 +="<td><span class='badge badge-soft-success'>"+row.enq_status+"</span></td>";

                            }
                            else if(row.enq_status == "On Hold"){
                                content2 +="<td><span class='badge badge-soft-warning'>"+row.enq_status+"</span></td>";
                            }
                            else if(row.enq_status == "Cancelled"){
                                content2 +="<td><span class='badge badge-soft-danger'>"+row.enq_status+"</span></td>";
                            }
                            content2 +="<td>"+row.project_name+"</td>";
                            content2 +="<td>"+row.pr_head_con_name+"</td>";
                            content2 +="<td>";
                                $.each(row.tm_obj,function(key,value){
                                    content2 +=value.name+", ";
                                });
                            content2 +="</td>";

                            content2 +="<td>";
                                $.each(row.ss_obj,function(key,value){
                                    content2 +=value.name+", ";
                                });
                            content2 +="</td>";
                            // content2 +="<td>"+row.team_member_conceptual+"</td>";
                            // content2 +="<td>"+row.site_supervisor+"</td>";
                            content2 +="<td>"+row.client_name+"</td>";
                            content2 +="<td>"+row.pr_address+"</td>";
                            content2 +="<td>"+row.client_requirement+"</td>";
                            content2 +="<td>"+row.client_document+"</td>";
                            content2 +="<td>"+row.client_ph_no+"</td>";
                            content2 +="<td>"+row.enq_date+"</td>";
                            content2 +="<td>"+row.project_type+"</td>";
                            content2 += "</tr>";
                        }

                        if(row.project_type == "Sustainable")
                        {
                            content3 +="<tr>";
                            content3 +="<td>"+ ++l  +"</td>";
                            content3 +="<td>"+row.enquiry_no+"</td>";
                            
                                content3 +="<td>";
                                content3 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Enquiry' data-id='"+row.id+"' data-project_name='"+row.project_name+"' data-client_name='"+row.client_name+"' data-pr_head_conceptual='"+row.pr_head_conceptual+"' data-team_member_conceptual='"+row.team_member_conceptual+"' data-site_supervisor='"+row.site_supervisor+"' data-pr_address='"+row.pr_address+"' data-client_requirement='"+row.client_requirement+"' data-client_document='"+row.client_document+"' data-client_ph_no='"+row.client_ph_no+"' data-enq_date='"+row.enq_date+"' data-project_type='"+row.project_type+"' data-enq_status='"+row.enq_status+"'><i class='far fa-edit'></i></a> <button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Enquiry' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                                
                                if(row.oth_status == 1){
                                    content3 += " <a class='btn btn-outline-secondary btn-sm removeTL'  rel='tooltip' data-bs-placement='top' title='Remove TL' data-oth_so_id='"+row.id+"' data-oth_id='"+row.oth_id+"' data-oth_status='"+row.oth_status+"'><i class='fas fa-ban'></i></a>";
                                }
                                content3 += "</td>";
                        
                            if(row.enq_status == "Enquiry"){
                                content3 +="<td><span class='badge badge-soft-success'>"+row.enq_status+"</span></td>";

                            }
                            else if(row.enq_status == "On Hold"){
                                content3 +="<td><span class='badge badge-soft-warning'>"+row.enq_status+"</span></td>";
                            }
                            else if(row.enq_status == "Cancelled"){
                                content3 +="<td><span class='badge badge-soft-danger'>"+row.enq_status+"</span></td>";
                            }
                            content3 +="<td>"+row.project_name+"</td>";
                            content3 +="<td>"+row.pr_head_con_name+"</td>";
                            content3 +="<td>";
                                $.each(row.tm_obj,function(key,value){
                                    content3 +=value.name+", ";
                                });
                            content3 +="</td>";

                            content3 +="<td>";
                                $.each(row.ss_obj,function(key,value){
                                    content3 +=value.name+", ";
                                });
                            content3 +="</td>";
                            // content3 +="<td>"+row.team_member_conceptual+"</td>";
                            // content3 +="<td>"+row.site_supervisor+"</td>";
                            content3 +="<td>"+row.client_name+"</td>";
                            content3 +="<td>"+row.pr_address+"</td>";
                            content3 +="<td>"+row.client_requirement+"</td>";
                            content3 +="<td>"+row.client_document+"</td>";
                            content3 +="<td>"+row.client_ph_no+"</td>";
                            content3 +="<td>"+row.enq_date+"</td>";
                            content3 +="<td>"+row.project_type+"</td>";
                            content3 += "</tr>";
                        }

                        if(row.project_type == "Urban Design")
                        {
                            content4 +="<tr>";
                            content4 +="<td>"+ ++m  +"</td>";
                            content4 +="<td>"+row.enquiry_no+"</td>";
                            
                                content4 +="<td>";
                                content4 +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Enquiry' data-id='"+row.id+"' data-project_name='"+row.project_name+"' data-client_name='"+row.client_name+"' data-pr_head_conceptual='"+row.pr_head_conceptual+"' data-team_member_conceptual='"+row.team_member_conceptual+"' data-site_supervisor='"+row.site_supervisor+"' data-pr_address='"+row.pr_address+"' data-client_requirement='"+row.client_requirement+"' data-client_document='"+row.client_document+"' data-client_ph_no='"+row.client_ph_no+"' data-enq_date='"+row.enq_date+"' data-project_type='"+row.project_type+"' data-enq_status='"+row.enq_status+"'><i class='far fa-edit'></i></a> <button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Enquiry' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                                
                                if(row.oth_status == 1){
                                    content4 += " <a class='btn btn-outline-secondary btn-sm removeTL'  rel='tooltip' data-bs-placement='top' title='Remove TL' data-oth_so_id='"+row.id+"' data-oth_id='"+row.oth_id+"' data-oth_status='"+row.oth_status+"'><i class='fas fa-ban'></i></a>";
                                }
                                content4 += "</td>";
                        
                            if(row.enq_status == "Enquiry"){
                                content4 +="<td><span class='badge badge-soft-success'>"+row.enq_status+"</span></td>";

                            }
                            else if(row.enq_status == "On Hold"){
                                content4 +="<td><span class='badge badge-soft-warning'>"+row.enq_status+"</span></td>";
                            }
                            else if(row.enq_status == "Cancelled"){
                                content4 +="<td><span class='badge badge-soft-danger'>"+row.enq_status+"</span></td>";
                            }
                            content4 +="<td>"+row.project_name+"</td>";
                            content4 +="<td>"+row.pr_head_con_name+"</td>";
                            content4 +="<td>";
                                $.each(row.tm_obj,function(key,value){
                                    content4 +=value.name+", ";
                                });
                            content4 +="</td>";

                            content4 +="<td>";
                                $.each(row.ss_obj,function(key,value){
                                    content4 +=value.name+", ";
                                });
                            content4 +="</td>";
                            // content4 +="<td>"+row.team_member_conceptual+"</td>";
                            // content4 +="<td>"+row.site_supervisor+"</td>";
                            content4 +="<td>"+row.client_name+"</td>";
                            content4 +="<td>"+row.pr_address+"</td>";
                            content4 +="<td>"+row.client_requirement+"</td>";
                            content4 +="<td>"+row.client_document+"</td>";
                            content4 +="<td>"+row.client_ph_no+"</td>";
                            content4 +="<td>"+row.enq_date+"</td>";
                            content4 +="<td>"+row.project_type+"</td>";
                            content4 += "</tr>";
                        }
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
                
                //For Add pr_head_conceptual
                $('#pr_head_conceptual').append("<option value='' class='text-muted' selected disabled>"+'Select'+"</option>");
                // $('#labour').append("<option value='' class='text-muted' >"+'All'+"</option>");
                $.each(data.prhead_obj,function(index,row){
                    //For Add pr_head_conceptual
                    $('#pr_head_conceptual').append("<option value='"+row.id+"'>"+row.name+"</option>");
                   
                });

                //For Add team_member_conceptual
                $.each(data.employee_obj,function(index,row){
                    //For Add team_member_conceptual
                    $('#team_member_conceptual').append("<option value='"+row.id+"'>"+row.name+"</option>");
                });

                //For Add supervisor
                $.each(data.ssupervisor_obj,function(index,row){
                    //For Add supervisor
                    $('#supervisor').append("<option value='"+row.id+"'>"+row.name+"</option>");
                });
            }
        });
    }

   
    $('.nav-tabs a[href="#update_enquiry"]').click(function(){
       
       $('.enq_form')[0].reset();
       $('#edit_id').val('');               
       $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
       $("#enq_status").val("").trigger("change"); 
       $("#project_type").val("").trigger("change"); 
       getEnq();
       

   });

   //For set/unset select field
   $('.nav-tabs a[href="#ar_list"]').click(function()
   {
       $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
       $("#enq_status").val("").trigger("change"); 
       $("#project_type").val("").trigger("change"); 
       getEnq();
   });

   //For set/unset select field
   $('.nav-tabs a[href="#in_list"]').click(function()
   {
       $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
       $("#enq_status").val("").trigger("change"); 
       $("#project_type").val("").trigger("change"); 
       getEnq();
   });

   //For set/unset select field
   $('.nav-tabs a[href="#la_list"]').click(function()
   {
       $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
       $("#enq_status").val("").trigger("change"); 
       $("#project_type").val("").trigger("change"); 
       getEnq();
   });

   //For set/unset select field
   $('.nav-tabs a[href="#sa_list"]').click(function()
   {
       $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
       $("#enq_status").val("").trigger("change"); 
       $("#project_type").val("").trigger("change"); 
       getEnq();
   });

   //For set/unset select field
   $('.nav-tabs a[href="#ud_list"]').click(function()
   {
       $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
       $("#enq_status").val("").trigger("change"); 
       $("#project_type").val("").trigger("change"); 
       getEnq();
   });

    // Enq Form Validation
    var n =0;
    $("#add_enq").click(function(event) 
    {
        // alert('hi');
        var project_name= $('#project_name').val();
        var client_name = $('#client_name').val();
        var cp_ph_no= $('#cp_ph_no').val();
        var enq_date= $('#enq_date').val();
        var project_type = $('#project_type').val();
        var client_req = $('#client_req').val();
        var project_address = $('#project_address').val();
        var client_document = $('#client_document').val();
        var pr_head_conceptual = $('#pr_head_conceptual').val();
        var team_member_conceptual = $('#team_member_conceptual').val();
        var supervisor = $('#supervisor').val();
        var enq_status = $('#enq_status').val();
        
        n=0;    
        if( $.trim(project_name).length == 0 )
        {
            $('#pnerror').text('Please Enter Project Name.');
            event.preventDefault();
        }else{
            $('#pnerror').text('');
            ++n;
        }

        if( $.trim(client_name).length == 0 )
        {
            $('#cnerror').text('Please Enter Client Name.');
            event.preventDefault();
        }else{
            $('#cnerror').text('');
            ++n;
        }

        if( $.trim(cp_ph_no).length == 0 )
        {
            $('#cperror').text('Please Enter Phone No.');
            event.preventDefault();
        }else{
            $('#cperror').text('');
            ++n;
        }

        if( $.trim(enq_date).length == 0 )
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
       
        if( $.trim(client_req).length == 0 )
        {
            $('#crerror').text('Please Enter Client Requirement.');
            event.preventDefault();
        }else{
            $('#crerror').text('');
            ++n;
        }

        // if( $.trim(project_address).length == 0 )
        // {
        //     $('#paerror').text('Please Enter Project Address .');
        //     event.preventDefault();
        // }else{
        //     $('#paerror').text('');
        //     ++n;
        // }

        // if( $.trim(client_document).length == 0 )
        // {
        //     $('#cderror').text('Please Enter Client Document.');
        //     event.preventDefault();
        // }else{
        //     $('#cderror').text('');
        //     ++n;
        // }

        // if( $.trim(pr_head_conceptual).length == 0 )
        // {
        //     $('#phcerror').text('Please Select Pr Head Conceptual.');
        //     event.preventDefault();
        // }else{
        //     $('#phcerror').text('');
        //     ++n;
        // }

        // if( $.trim(team_member_conceptual).length == 0 )
        // {
        //     $('#tmcerror').text('Please Select Team Member Conceptual');
        //     event.preventDefault();
        // }else{
        //     $('#tmcerror').text('');
        //     ++n;
        // }
        
        // if( $.trim(supervisor).length == 0 )
        // {
        //     $('#sserror').text('Please Select Site Supervisor.');
        //     event.preventDefault();
        // }else{
        //     $('#sserror').text('');
        //     ++n;
        // }

        if( $.trim(enq_status).length == 0 )
        {
            $('#pserror').text('Please Select Status.');
            event.preventDefault();
        }else{
            $('#pserror').text('');
            ++n;
        }
    });

    // For Add Enq
    $(document).on("click",'#add_enq',function()
    {        
        // alert(n)   ;
        if(n==7)
        {        
           
            var edit_id= $('#edit_id').val();
            var project_name= $('#project_name').val();
            var client_name = $('#client_name').val();
            var cp_ph_no= $('#cp_ph_no').val();
            var enq_date= $('#enq_date').val();
            var project_type = $('#project_type').val();
            var client_req = $('#client_req').val();
            var project_address = $('#project_address').val();
            var client_document = $('#client_document').val();
            var pr_head_conceptual = $('#pr_head_conceptual').val();
            var team_member_conceptual = $('#team_member_conceptual').val();
            var supervisor = $('#supervisor').val();
            var enq_status = $('#enq_status').val();

            $(".add_enq").addClass("bx-loader bx-spin");
            $("#add_enq").prop('disabled', true);
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('post_enq')}}",
                type :'post',
                data : {edit_id:edit_id,project_name:project_name,client_name:client_name,cp_ph_no:cp_ph_no,enq_date:enq_date,project_type:project_type,client_req:client_req,project_address:project_address,client_document:client_document,pr_head_conceptual:pr_head_conceptual,team_member_conceptual:team_member_conceptual,supervisor:supervisor,enq_status:enq_status},
                async: false,
                cache: true,
                dataType: 'json',
                success:function(response){
                    console.log(response);

                    if (response.status==true) {  

                        $('.enq_form')[0].reset();
                        $('#pr_head_conceptual,#team_member_conceptual,#supervisor').empty();
                        $("#enq_status").val("").trigger("change"); 
                        $("#project_type").val("").trigger("change");           

                        getEnq();

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
                    $(".add_enq").removeClass("bx-loader bx-spin");
                    $("#add_enq").prop('disabled', false);
                   
                }
            });
        }
        
    });  

    // Edit Record
    $(document).on("click",'.editU',function()
    {
        var id = $(this).data('id');
        if(id !=""){
            var role= $('#role').val();
            var project_name = $(this).data('project_name');
            var client_name = $(this).data('client_name');
            var enq_status = $(this).data('enq_status');
            var pr_address = $(this).data('pr_address');
            var client_requirement = $(this).data('client_requirement');
            var client_document = $(this).data('client_document');
            var client_ph_no = $(this).data('client_ph_no');
            var enq_date = $(this).data('enq_date');
            var project_type = $(this).data('project_type');
            var pr_head_conceptual= $(this).data('pr_head_conceptual');
            var team_member_conceptual= $(this).data('team_member_conceptual');
            var site_supervisor= $(this).data('site_supervisor');

            // alert(lead_technician);
            var r=new Array();
            if (team_member_conceptual.toString().indexOf(',')>-1)
            { 
                var r=team_member_conceptual.split(',');
            }
            else
            {
                r[0]=team_member_conceptual.toString();
            }

            var r1=new Array();
            if (site_supervisor.toString().indexOf(',')>-1)
            { 
                var r1=site_supervisor.split(',');
            }
            else
            {
                r1[0]=site_supervisor.toString();
            }

            // ACTIVE PANE AND LINK
            $('.nav-tabs a[href="#update_enquiry"]').tab('show');

            $('#edit_id').val(id);   
            $('#project_name').val(project_name); 
            $('#client_name').val(client_name); 
            $('#cp_ph_no').val(client_ph_no); 
            $('#enq_date').val(enq_date); 
            $('#project_type').val(project_type); 
            $('#client_req').val(client_requirement);
            $('#project_address').val(pr_address); 
            $('#client_document').val(client_document);
            $('#pr_head_conceptual option[value='+pr_head_conceptual+']').attr('selected','selected').change();
            $("#enq_status").val(enq_status).trigger("change"); 
            $("#project_type").val(project_type).trigger("change"); 

            $.each(r,function(index,value)
            {
                $("#team_member_conceptual option[value='"+value+"']").attr('selected','selected').change();
            });

            $.each(r1,function(index,value)
            {
                $("#supervisor option[value='"+value+"']").attr('selected','selected').change();
            });
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
            url:"{{url('delete_enq')}}",
            type :'get',
            data : {id:id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  

                    $("#id").val('');
                    getEnq();
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