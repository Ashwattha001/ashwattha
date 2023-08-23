@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
    $roles=Session::get('ROLES');
    $role=explode(',',$roles);
    $count=count($role);
?>
@section('title',"Consultant Management | $title")
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
                           <h4 class="card-title mb-4">Consultant Management</h4>
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#consultant_list" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Consultant List</span> 
                                </a>
                            </li>
                            @if($roles==0)
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#update_consultant" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">ADD / Update Consultant</span> 
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="consultant_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 table table-striped" id="datatable"> 
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 20px;">Sr.No</th>
                                                <th scope="col" style="white-space: normal;">Consultant Name</th>
                                                <th scope="col" style="white-space: normal;">color</th>
                                                @if($roles==0)
                                                    <th scope="col">Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody id="status_records">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
         
                            <div class="tab-pane" id="update_consultant" role="tabpanel">
                                {!! Form::open(['class'=>"form-horizontal department_form",'enctype'=>'multipart/form-data','files' => 'true','id'=>'postdepForm']) !!}

                                    <input type="hidden" name="edit_id" id="edit_id" value="">
                                    <input type="hidden" name="role" id="role" value="{{$roles}}">

                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="consultant_name" placeholder="Enter Consultant Name" name="consultant_name" required onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);" maxlength="20">
                                                <label for="consultant_name">Consultant Name<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="derror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <div class="form-floating mb-3">
                                                <input type="color" class="form-control" id="color" placeholder="Select Color" name="color" required maxlength="20">
                                                <label for="color">Color<sup class="text-danger">*</sup></label>
                                                <span class="text-danger error" id="cerror"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2 mt-2">
                                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light mb-2 submit_btn" id="add_dep"  value="Save"> Save </button>
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
            $('#datatable').dataTable();    
           
           
        });
    </script>
@endpush

@push('page_js')
{!! Html::script('assets/libs/select2/js/select2.min.js') !!}

<script>
    $(document).ready(function(){
        var $body = $("body");
    });
    var $body = $("body");

    $( function(){
        $( "#addModal" ).draggable();
    });
    
    // $('#labour').select2({
    //     dropdownParent: $('#addModal')
    // });

    $('.nav-tabs a[href="#update_consultant"]').click(function(){
       
        $('.department_form')[0].reset()
        $('#edit_id').val('');
        $('#color').val('');
        getConsultant();
    
    });

    //For set/unset select field
    $('.nav-tabs a[href="#consultant_list"]').click(function()
    {
        getConsultant();
    });

    getConsultant();
    function getConsultant(){

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('get_consultant')}}",
            type :'get',
            data : {},
            cache: false,
            dataType: 'json',                 
            success:function(data){
                console.log(data.data);
                $("#datatable").DataTable().destroy();
                content ="";
                var i = 0;                
                $.each(data.data,function(index,row){

                        content +="<tr>";
                        content +="<td>"+ ++i  +"</td>";
                        content +="<td>"+row.consultant_name+"</td>";
                        content +="<td><div class='btn btn-outline-secondary btn-sm' style='background-color:"+row.color+"'> </div></td>";
                        if(data.roles == 0){
                            content +="<td><a class='btn btn-outline-secondary btn-sm editU' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit Deaprtment' data-id='"+row.id+"' data-consultant_name='"+row.consultant_name+"' data-color='"+row.color+"' data-bs-toggle='modal'><i class='far fa-edit'></i></a> <button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Deaprtment' data-bs-toggle='modal' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button></td>"
                        }
                        content += "</tr>";
                });
                
                $("#status_records").html(content); //For append html data
                $('#datatable').dataTable();
               
            }
        });
    }



    $(document).on("click",'.editU',function()
    {
        var id = $(this).data('id');
       
        if(id !=""){
    
            var consultant_name = $(this).data('consultant_name');
            var color = $(this).data('color');
            
            $('.nav-tabs a[href="#update_consultant"]').tab('show');

            $('#edit_id').val(id);   
            $('#consultant_name').val(consultant_name); 
            $('#color').val(color); 

        }

    });

    // For Status Validation
    var n =0;
    $("#add_dep").click(function(event) 
    {
        // alert('hi');
        var consultant_name= $('#consultant_name').val();
        var color= $('#color').val();
        
        n=0;    

        if( $.trim(consultant_name).length == 0 )
        {
            $('#derror').text('Please Enter Consultant Name');
            event.preventDefault();
        }else{
            $('#derror').text('');
            ++n;
        }

        if( $.trim(color).length == 0 )
        {
            $('#cerror').text('Select Color');
            event.preventDefault();
        }else{
            $('#cerror').text('');
            ++n;
        }

    });

    // For Add Status
    $(document).on("click",'#add_dep',function()
    {        
        // alert(n)   ;
        if(n==2)
        {        
            var edit_id= $('#edit_id').val();
            var consultant_name= $('#consultant_name').val();
            var color= $('#color').val();

            $.ajax({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('post_consultant')}}",
                type :'post',
                data : {consultant_name:consultant_name,edit_id:edit_id,color:color},
                async: false,
                cache: true,
                dataType: 'json',
                success:function(response){
                    console.log(response);

                    if (response.status==true) {  

                        $("#consultant_name").val('');
                            

                        // $("#addModal").modal("hide");
                        getConsultant();

                        // ACTIVE PANE AND LINK
                        $('.nav-tabs a[href="#consultant_list"]').tab('show');
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
        }
        
    });  

    // delete Status
    $(document).on("click",'.delI',function()
    {
        var id = $(this).data('id');
        $('#id').val(id);
        // $('#delete_record_modal form').attr("action","delete_so/"+id);
        $('#delete_record_modal').modal('show');
    });

    // For delete Status
    $(document).on("click",'#del_rec',function()
    {           
        var id= $('#id').val();
        // alert(id);

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('delete_consultant')}}",
            type :'get',
            data : {id:id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  

                    $("#id").val('');
                    getConsultant();
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