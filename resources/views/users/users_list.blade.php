@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
$roles=Session::get('ROLES');
?>
@if($roles == 0)
    @section('title',"User Management | $title")
@else
    @section('title',"Technician Management | $title")
@endif

@push('datatable_css')
{!! Html::style('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
<!-- App Css-->
{!! Html::style('assets/css/app.min.css') !!}
{!! Html::style('assets/libs/select2/css/select2.min.css') !!}
@endpush
@push('page_css')
<style>
    .form-floating>.form-control, .form-floating>.form-select {
        height: calc(2.8rem + 1px) !important;
        padding: 1rem .75rem;
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

    /* .loader {
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
    } */
</style>
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18"> </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users List</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="font-size-18">Users Master</h4>
                            <div class="ms-auto">
                                <!-- <button type="button" class="btn btn-primary btn-sm waves-effect waves-light w-sm " data-bs-toggle="modal" data-bs-target="#addUserModal" style="margin-left: 10px;">
                                <i class="mdi mdi-plus font-size-11"></i> Add User
                                </button> -->
                            </div>
                        </div>
                    
                        @include('common.alert')
                        <div id="alerts">
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Users</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Add / Edit User</span> 
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-nowrap align-middle table-borderless" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                
                                                <th scope="col" style="white-space: normal;">Full Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user_records">
                                            <?php $i=0; $roless=Session::get('ROLES'); ?>
                                            @foreach($u_obj as $u)
                                                <tr>
                                                    <td>{{++$i}}</td>
                                                    <td>
                                                        <h5 class="text-truncate font-size-14">{{$u->name}}<br>
                                                        <small class="text-muted mb-0" style="white-space: normal;">
                                                            (
                                                      
                                                                @if($u->role == 1)
                                                                   Project Head
                                                                @endif
                                                                @if($u->role == 2)
                                                                    Team Member
                                                                @endif
                                                                @if($u->role == 3)
                                                                    Site Supervisors/ Engineers
                                                                @endif
                                                            )
                                                        </small></h5>
                                                    </td>
                                                    <td>{{$u->email}}</td>
                                                    <td>{{$u->mobile}}</td>
                                                    <td>
                                                        <div class="form-check form-switch mb-3" dir="ltr">
                                                            @if($u->is_active==0)
                                                            <input class="form-check-input" type="checkbox" id="is_active" checked data-id="{{$u->id}}">
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="is_active" data-id="{{$u->id}}">
                                                            @endif
                                                            <label class="form-check-label" for="is_active"></label>
                                                        </div>

                                                        <button class='btn btn-outline-secondary btn-sm resPass' rel='tooltip' data-bs-placement='top' title='Reset Password' data-id="{{$u->id}}" data-name="{{$u->name}}" data-emp_number="{{$u->emp_number}}"><i class='fas fa-undo-alt'></i></button>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                            </a>
                                                            <div class="dropdown-menu" style="min-width: 6rem !important;">
                                                                <a class="dropdown-item editU" href="javascript:void(0);" data-id="{{$u->id}}" data-name="{{$u->name}}" data-mobile="{{$u->mobile}}" data-email="{{$u->email}}" data-status="{{$u->status}}" data-role="{{$u->role}}" data-pan_number="{{$u->pan_number}}" data-aadhar_number="{{$u->aadhar_number}}" data-pan_file="{{$u->pan_file}}" data-aadhar_file="{{$u->aadhar_file}}" data-photo_file="{{$u->photo_file}}">Edit</a>

                                                                <a class="dropdown-item delU" href="javascript:void(0);" data-id="{{$u->id}}">Delete</a>

                                                                <!-- <a class="dropdown-item resPass" href="javascript:void(0);" data-id="{{$u->id}}" data-name="{{$u->name}}" data-emp_number="{{$u->emp_number}}">Reset Password</a> -->
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile1" role="tabpanel">
                                {!! Form::open(['class'=>"form-horizontal user_form",'enctype'=>'multipart/form-data','files' => 'true' ,'method'=>"post",'url'=>'post_user','id'=>'postUserForm']) !!}
                                <div class="row">
                                    <input type="hidden" name="user_id" id="user_id">
                                    <div class="col-md-3 col-sm-12 col-lg-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="user_name" placeholder="Enter Name" required name="name" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);">
                                            <label for="user_name">Full Name<sup class="text-danger">*</sup></label>
                                            <span class="text-danger error" id="unerror"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile" required name="mobile" pattern="[789]\d{9}" maxlength="10">
                                            <label for="mobile">Mobile<sup class="text-danger">*</sup></label>
                                            <span class="text-danger error" id="merror"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-sm-12 col-lg-3">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" placeholder="Enter Email address" name="email">
                                            <label for="email">Email address</label>
                                        </div>
                                    </div>
                                    
                                    <?php $roles=Session::get('ROLES');?>
                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                        <div class="form-group mb-3">
                                            <label for="role" class="form-label" style="font-size: 11px;margin-bottom: 2px;">User Type<sup class="text-danger">*</sup></label>
                                            <select class="select2 form-control" id="role" required name="role">
                                                @if($roles==0)
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="0">Super Admin</option>
                                                    <option value="1">Project Head</option>
                                                    <option value="2">Team Member</option>
                                                    <option value="3">Site Supervisors</option>
                                                @endif
                                            </select>
                                            <span class="text-danger error" id="rerror"></span>

                                        </div>
                                    </div> 
                                    <?php $tdate=date("Y-m-d"); ?>
                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                        <div class="form-floating mb-3">
                                            <input type="date" max="{{$tdate}}" class="form-control" id="birth_date"  name="birth_date" required placeholder="dd-mm-yyyy" value="{{$tdate}}">
                                            <label for="birth_date">Birth Date <sup class="text-danger">*</sup></label>
                                            <small><span class="text-danger" id="bderror" style="font-size: 11px !important;"></span></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="photo_file" placeholder="photo File" name="photo_file">
                                            <label for="photo_file">User Photo</label>
                                            <a href="" id="photo_file1" target="_blank"><i class="fa fa-eye"></i> View Previous File</a>
                                            <span class="text-danger error" id="uperror"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="pan_number" placeholder="Enter PAN Number" maxlength="10" minlength="10" name="pan_number" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="10">
                                            <label for="pan_number">PAN Number</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="pan_file" placeholder="PAN File" name="pan_file">
                                            <label for="pan_file">PAN File</label>
                                            <a href="" id="pan_file1" target="_blank"><i class="fa fa-eye"></i> View Previous File</a>
                                            <span class="text-danger error" id="perror"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-12 col-lg-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="aadhar_number" placeholder="Enter AADHAR Number" name="aadhar_number" maxlength="12">
                                            <label for="aadhar_number">AADHAR Number<sup class="text-danger">*</sup></label>
                                            <span class="text-danger error" id="aerror"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="aadhar_file" placeholder="AADHAR File" name="aadhar_file">
                                            <label for="aadhar_file">AADHAR File</label>
                                            <a href="" id="aadhar_file1" target="_blank"><i class="fa fa-eye"></i> View Previous File</a>
                                            <span class="text-danger error" id="aferror"></span>
                                        </div>
                                    </div>
                                                                   
                                </div>

                                <div class="d-sm-flex flex-wrap">
                                    <h4 class="card-title mb-4"></h4>
                                    <div class="ms-auto">
                                        <input type="submit" class="btn btn-primary btn-sm waves-effect waves-light mb-2 submit_btn"  value="Save" />
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@include('common.delete_modal')
@stop
@push('datatable_js')
       {!! Html::script('assets/libs/datatables.net/js/jquery.dataTables.min.js') !!}
       {!! Html::script('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}
       {!! Html::script('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') !!}
       {!! Html::script('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') !!}
{!! Html::script('assets/libs/select2/js/select2.min.js') !!}

       <script>
           $(document).ready(function(){
                $('#datatable').dataTable();
                // $('#showbtn').hide();
                // $('#subform').attr('disabled','disabled');
                $('#role').select2();
                
           });
       </script>

@endpush
@push('page_js')
<script>
    $('#postUserForm').submit(function(e){
        
        var ext1 = $('#photo_file').val().split('.').pop().toLowerCase();
        if($.inArray(ext1, ['png','jpg','jpeg']) == -1 && ext1 != '')
        {
            $('#pferror').html('Only .jpg, .jpeg, .png allowed').css('color','red');
            e.preventDefault();
             return false;
        }

        var ext2 = $('#pan_file').val().split('.').pop().toLowerCase();
        if($.inArray(ext2, ['png','jpg','jpeg','pdf']) == -1 && ext2 != '')
        {
            $('#perror').html('Only .jpg, .jpeg, .png , .pdf allowed').css('color','red');
            e.preventDefault();
             return false;
        }

        var ext3 = $('#aadhar_file').val().split('.').pop().toLowerCase();
        if($.inArray(ext3, ['png','jpg','jpeg','pdf']) == -1 && ext3 != '')
        {
            $('#aferror').html('Only .jpg, .jpeg, .png , .pdf allowed').css('color','red');
            e.preventDefault();
             return false;
        }
    });
</script>

<script>
  // From SO Validation
  var n =0;
$("#postUserForm").submit(function(event) 
{
    // alert('hi');
    var user_name = $('#user_name').val();
    var mobile= $('#mobile').val();
    var role= $('#role').val();
    var aadhar_number = $('#aadhar_number').val();

    n=0;    
    if( $.trim(user_name).length == 0 )
    {
        $('#unerror').text('Please Enter User Name.');
        event.preventDefault();
    }else{
        $('#unerror').text('');
        ++n;
    }

    if( $.trim(mobile).length == 0 )
    {
        $('#merror').text('Please enter 10 digits mobile number');
        event.preventDefault();
    }else{
        $('#merror').text('');
        ++n;
    }
    
    if( $.trim(role).length == 0 )
    {
        $('#rerror').text('Please Select User Type.');
        event.preventDefault();
    }else{
        $('#rerror').text('');
        ++n;
    }

    if( $.trim(aadhar_number).length != 12 )
    {
        $('#aerror').text('Please Enter Valid Aadhar No.');
        event.preventDefault();
    }else{
        $('#aerror').text('');
        ++n;
    }

});

// add Aadhar no validation
$("#aadhar_number").keypress(function (e) {
    var aadhar_number = $('#aadhar_number').val();
    
        //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        if( $.trim(aadhar_number).length != 12 )
        {
            //display error message
            $("#aerror").text('12 Digits Only');
                return false;
        }        
    }else{
        
        $("#aerror").text('');
    }
});

// add mobile no validation
$("#mobile").keypress(function (e) {
    var mobile= $('#mobile').val();
    
        //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        if( $.trim(mobile).length != 12 )
        {
            //display error message
            $("#merror").text('10 Digits Only');
                return false;
        }        
    }else{
        
        $("#merror").text('');
    }
});

$(document).on("click",'.delU',function()
{
    var id = $(this).data('id');
    $('#id').val(id);
    // $('#delete_record_modal form').attr("action","user_del/"+id);
    $('#delete_record_modal').modal('show');
});

$('.nav-tabs a[href="#profile1"]').click(function(){
    $('.user_form')[0].reset()
    $('#user_id').val('');

    $('#pan_file1').hide();
    $('#aadhar_file1').hide();
    $('#photo_file1').hide();
});

 

$(document).on("click",'.editU',function()
{

    var id = $(this).data('id');
    var name = $(this).data('name');
    var mobile_no = $(this).data('mobile');
    var email = $(this).data('email');
    var role = $(this).data('role');
    var pan_number = $(this).data('pan_number');
    var aadhar_number = $(this).data('aadhar_number');
    var pan_file = $(this).data('pan_file');
    var aadhar_file = $(this).data('aadhar_file');
    var photo_file = $(this).data('photo_file');

    if(pan_file != ""){
        $('#pan_file1').show();
    }
    if(aadhar_file != ""){
        $('#aadhar_file1').show();
    }
    if(photo_file != ""){
        $('#photo_file1').show();
    }
    // alert(pan_file);
    var  pan_file="files/user/"+pan_file;
    var  aadhar_file="files/user/"+aadhar_file;
    var  photo_file="files/user/"+photo_file;
    $('#user_id').val(id);
    $('#user_name').val(name);
    $('#mobile').val(mobile_no);
    $('#email').val(email);
    $('#pan_number').val(pan_number);
    $('#aadhar_number').val(aadhar_number);
    $("#role").val(role).trigger("change");
    
    // <!-- $("#role").find("option[value='"+role+"']").prop("selected", "selected"); -->
    $('#pan_file1').attr("href",pan_file);
    $('#aadhar_file1').attr("href",aadhar_file);
    $('#photo_file1').attr("href",photo_file);
    $('.nav-tabs a[href="#profile1"]').tab('show');
});
</script> 
<script>
  
$(document).on("click",'.resPass',function()
{
        var id = $(this).data('id');
        var name = $(this).data('name');
        var emp_number = $(this).data('emp_number');

        $('#rp_id').val(id);
        $('#name').val(name);
        $('#emp_number').val(emp_number);
        $("#u_name").html(name);
        $("#u_emp_number").html(emp_number);

        // $('#delete_record_modal form').attr("action","user_del/"+id);
        $('#pass_reset_modal').modal('show');
});

// For delete user
$(document).on("click",'#pass_res',function()
{           
        var rp_id= $('#rp_id').val();
        // alert(rp_id);

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('res_pass')}}",
            type :'get',
            data : {rp_id:rp_id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  
                    $("#pass_reset_modal").modal("hide");

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

// For delete user
$(document).on("click",'#del_rec',function()
{           
        var id= $('#id').val();
        // alert(id);

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('user_del')}}",
            type :'get',
            data : {id:id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  

                    $("#id").val('');

                    $("#datatable").DataTable().destroy();
                    content ="";
                    var i = 0;                
                    $.each(response.data,function(index,row){
                        if(response.role==0){
                            
                            content +="<tr>";
                            content +="<td>"+ ++i  +"</td>";
                           
                            content +="<td><h5 class='text-truncate font-size-14'>"+row.name+"";
                                    if(row.role== 0){
                                        content +="<small class='text-muted mb-0' style='white-space: normal;'>(SUPER ADMIN)</small></h5>"
                                    }
                                    if(row.role== 1){
                                        content +="<small class='text-muted mb-0' style='white-space: normal;'>(Project Head)</small></h5>"
                                    }
                                    if(row.role== 2){
                                        content +="<small class='text-muted mb-0' style='white-space: normal;'>(Team Member)</small></h5>"
                                    }
                                    if(row.role== 3){
                                        content +="<small class='text-muted mb-0' style='white-space: normal;'>(Site Supervisors/ Engineers)</small></h5>"

                                    }
                            content += "</td>";
                            content +="<td>"+row.email+"</td>";
                            content +="<td>"+row.mobile+"</td>";
                            content +="<td><div class='form-check form-switch mb-3' dir='ltr'>";
                                if(row.is_active==0){
                                    content +="<input class='form-check-input' type='checkbox' id='is_active' checked data-id='"+row.id+"'><label class='form-check-label' for='is_active'></label> </div>"
                                }else{
                                    content += "<input class='form-check-input' type='checkbox' id='is_active' data-id='"+row.id+"'><label class='form-check-label' for='is_active'></label></div> "
                                }
                            content += "<button class='btn btn-outline-secondary btn-sm resPass' rel='tooltip' data-bs-placement='top' title='Reset Password' data-id='"+row.id+"' data-name='"+row.name+"'><i class='fas fa-undo-alt'></i></button> </td>";

                            content +="<td> <div class='dropdown'><a href='#' class='dropdown-toggle card-drop' data-bs-toggle='dropdown' aria-expanded='false'><i class='mdi mdi-dots-horizontal font-size-18'></i></a><div class='dropdown-menu' style='min-width: 6rem !important;'><a class='dropdown-item editU' href='javascript:void(0);' data-id='"+row.id+"' data-name='"+row.name+"' data-mobile='"+row.mobile+"' data-email='"+row.email+"' data-status='"+row.status+"' data-role='"+row.role+"' data-pan_number='"+row.pan_number+"' data-aadhar_number='"+row.aadhar_number+"' data-pan_file='"+row.pan_file+"' data-aadhar_file='"+row.aadhar_file+"' data-photo_file='"+row.photo_file+"'>Edit</a><a class='dropdown-item delU'  href='javascript:void(0);' data-id='"+row.id+"'>Delete</a> </div></div></td>";
                            content += "</tr>";
                        }
                    });
                    
                    $("#user_records").html(content); //For append html data
                    $('#datatable').dataTable();

                    $('#is_active').click(function(){
                        var id=$(this).data('id');
                        $.ajax({
                            url:'change_status/'+id,
                            type:'get',
                            data:{
                            },
                            cache: false,
                            dataType: 'json',
                            success:function(dt)
                            {
                                console.log(dt);
                                if(dt.data==true)
                                {
                                    $('.alert-success').fadeIn();
                                    $('#alerts').html('<div class="alert alert-success alert-dismissable"><strong>'+dt.msg+'</strong></div>');
                                    $('.alert-success').fadeOut(3000);
                                }
                                else
                                {
                                    $('.alert-danger').fadeIn();
                                    $('#alerts').html('<div class="alert alert-danger alert-dismissable"><strong>'+dt.msg+'</strong></div>');
                                    $('.alert-danger').fadeOut(3000);
                                }
                            }
                            });
                    });

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

$('#is_active').click(function(){
    var id=$(this).data('id');
    $.ajax({
        url:'change_status/'+id,
        type:'get',
        data:{
        },
        cache: false,
        dataType: 'json',
        success:function(dt)
        {
            console.log(dt);
            if(dt.data==true)
            {
                $('.alert-success').fadeIn();
                $('#alerts').html('<div class="alert alert-success alert-dismissable"><strong>'+dt.msg+'</strong></div>');
                $('.alert-success').fadeOut(3000);
            }
            else
            {
                $('.alert-danger').fadeIn();
                $('#alerts').html('<div class="alert alert-danger alert-dismissable"><strong>'+dt.msg+'</strong></div>');
                $('.alert-danger').fadeOut(3000);
            }
        }
        });
});
</script>
@endpush