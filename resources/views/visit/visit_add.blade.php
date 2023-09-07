@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
    $roles=Session::get('ROLES');
    $role=explode(',',$roles);
    $count=count($role);
?>
@section('title',"Visit Instructions Details | $title")
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
                    <h4 class="mb-sm-0 font-size-18">Generate Visit Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('visit_manage.page')}}">Site Visits List</a></li>
                            <li class="breadcrumb-item active">Generate Visit Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @include('common.alert')
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Visit Instructions Details</h4>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-primary waves-effect btn-sm waves-light mb-2 float-right" data-bs-toggle="modal" data-bs-target="#addInstructions" style="" id="add_inst_btn">
                                <i class="mdi mdi-plus font-size-11"></i>Add Instruction
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 table table-striped">
                            <!-- <table class="table align-middle table-bordered dt-responsive nowrap w-100 table table-striped" >   --> 
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Instructions</th>
                                        <th class="align-middle">Action Required From</th>
                                        <th class="align-middle">Instructions Provided by</th>
                                        <th class="align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="instru_records">
                                           
                                </tbody>
                            </table>
                        </div>
                       
                        <div class="mt-3 icountpdf">
                            {!! Form::open(['class'=>"form-horizontal",'method'=>"post",'url'=>"generate_visit_pdf/$visit_id",'id'=>'generate_visit_form']) !!}
                            <div class="row">                               

                            </div>
                                <div class="ms-auto">

                                    <button type="submit" class="btn btn-primary waves-effect btn-sm waves-light mb-2 float-right">
                                    <i class="mdi mdi-printer font-size-11" style="margin-right: 5px;"></i>Generate PDF

                                </div>
                                
                                <!-- <small class="text-info">Please Click on Generate PO button before you leave this page.</small> -->
                            {!! Form::close() !!}
                        </div>
                     
                    </div>
                    <div class="card-footer">
                        <div class="text-muted">
                            @foreach($sv_obj as $sv)
                            <small>
                                <strong>Site Visit Details : </strong>{{$sv->project_name}},{{$sv->contractor}} <a href="tel:"></a> , <a href="mailto:"></a>
                            </small>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- end row -->
</div> <!-- container-fluid -->

<!-- ADD Istruction -->
<div id="addInstructions" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {!! Form::open(['class'=>"form-horizontal",'id'=>'add_instr_form']) !!}
            <div class="modal-body">
                
                <div class="row">
                    <input type="hidden" name="edit_id" id="edit_id" value="">
                    <input type="hidden" name="visit_id" id="visit_id" value="{{$visit_id}}">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="form-group mb-3">
                            <label for="instructions">Instructions</label>
                            <textarea class="form-control " id="instructions" name="instructions" rows="2" placeholder="Enter Instruction" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);"></textarea>
                            <span class="text-danger error" id="ierror"></span>
                        </div>  
                    </div>
                    <?php $tdate=date("Y-m-d");?>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="instr_date" placeholder="Task Date" name="instr_date" required max="{{$tdate}}" value="{{$tdate}}">
                            <label for="instr_date">Instruction Date<sup class="text-danger">*</sup></label>
                            <span class="text-danger error" id="iderror"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="act_req_form" placeholder="Action Required From" name="act_req_form" maxlength="100" onkeyup="var start = this.selectionStart;var end = this.selectionEnd;this.value = this.value.toUpperCase();this.setSelectionRange(start, end);">
                            <label for="act_req_form">Action Required From</label>
                            <span class="text-danger error" id="aerror"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="add_instruc"><i class="bx font-size-16 align-middle me-2 add_instruc"></i>Save</button>
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
 
   $(document).ready(function() {
        var table = $('#datatable').removeAttr('width').DataTable( {
            scrollY:        "300px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            fixedColumns: true
        } );
        
    } );
</script>
@endpush
@push('page_js')
{!! Html::script('assets/libs/select2/js/select2.min.js') !!}

<script>
     $(document).ready(function(){
        var $body = $("body");
        $('.icountpdf').hide();
    });

    var $body = $("body");

    getInstructions();
    function getInstructions(){
        var visit_id = $('#visit_id').val();
        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('get-istructions')}}",
            type :'get',
            data : {visit_id:visit_id},
            cache: false,
            dataType: 'json',                 
            success:function(data){
                console.log(data);
                $("#datatable").DataTable().destroy();

                content ="";
                var i=0;        
                $.each(data.data,function(index,row){
                    
                    // date convert into dd/mm/yyyy
                    function formatDate (input) {
                        var datePart = input.match(/\d+/g),
                        year = datePart[0].substring(0), // get only two digits
                        month = datePart[1], day = datePart[2];
                        return day+'-'+month+'-'+year;
                    }
                
                    var instr_date = formatDate (row.instr_date); // "18/01/10"

                    content +="<tr>";
                    content +="<td>"+ ++i  +"</td>";
                    content +="<td>"+instr_date+"</td>";
                    content +="<td>"+row.instructions+"</td>";
                    content +="<td>"+row.act_req_form+"</td>";
                    content +="<td>"+row.name+"</td>";
                    content +="<td>";
                        content +="<a class='btn btn-outline-secondary btn-sm editU' rel='tooltip' data-bs-placement='top' title='Edit Instruction' data-id='"+row.id+"' data-instr_date='"+row.instr_date+"' data-instructions='"+row.instructions+"' data-act_req_form='"+row.act_req_form+"'><i class='far fa-edit'></i></a> ";

                        if(data.roles == 0)
                        {
                            content +="<button class='btn btn-outline-secondary btn-sm delI' rel='tooltip' data-bs-placement='top' title='Delete Instruction' data-id='"+row.id+"'><i class='fas fa-trash-alt'></i></button>";
                        }
                        
                        
                    content += "</td>";
                
                    content += "</tr>";
                 
                });
                
                $("#instru_records").html(content); //For append html data
                // $('#ar_datatable').dataTable();
                var table = $('#datatable').removeAttr('width').DataTable( {
                    scrollY:        "300px",
                    scrollX:        true,
                    scrollCollapse: true,
                    paging:         false,
                    fixedColumns: true
                } );
               
                if(data.icount != 0)
                {
                    $('.icountpdf').show();
                    
                }else{
                    $('.icountpdf').hide();
                }
            }
        });
    }

    $("#add_inst_btn").click(function(event) 
    {
      
        $('#edit_id').val('');   
        $('#instructions').val(''); 
        $('#act_req_form').val('');
    });

    // Instruction Form Validation
    var n =0;
    $("#add_instruc").click(function(event) 
    {
        // alert('hi');
        var instructions = $('#instructions').val();
        var act_req_form= $('#act_req_form').val();       
        
        n=0;    
        if( $.trim(instructions).length == 0 )
        {
            $('#ierror').text('Enter Instruction.');
            event.preventDefault();
        }else{
            $('#ierror').text('');
            ++n;
        }

        if( $.trim(act_req_form).length == 0 )
        {
            $('#aerror').text('Enter Action Req Form.');
            event.preventDefault();
        }else{
            $('#aerror').text('');
            ++n;
        }


    });

    // For Add Task
    $(document).on("click",'#add_instruc',function()
    {      

        if(n == 2)
        {     
            $(".add_instruc").addClass("bx-loader bx-spin");
            $("#add_instruc").prop('disabled', true);

            var edit_id = $('#edit_id').val();
            var visit_id = $('#visit_id').val();
            var instructions = $('#instructions').val();
            var act_req_form= $('#act_req_form').val();  
            var instr_date= $('#instr_date').val();  

            // alert(n);
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('post_instruction')}}",
                type :'post',
                data : {edit_id:edit_id,visit_id:visit_id,instructions:instructions,act_req_form:act_req_form,instr_date:instr_date},
                async: false,
                cache: true,
                dataType: 'json',
                success:function(response){
                    console.log(response);

                    if (response.status==true) {  

                        // $('#add_instr_form')[0].reset();
                              
                        getInstructions();
                        // ACTIVE PANE AND LINK
                        // $('.nav-tabs a[href="#ar_list"]').tab('show');
                        $('#addInstructions').modal('hide');
                        $('#edit_id').val('');   
                        $('#instructions').val(''); 
                        $('#act_req_form').val('');

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
                    $(".add_instruc").removeClass("bx-loader bx-spin");
                    $("#add_instruc").prop('disabled', false);
                   
                }
            });
        }
        
    }); 

    // Edit Record
    $(document).on("click",'.editU',function()
    {
        var id = $(this).data('id');
        
        if(id !=""){

            var instr_date = $(this).data('instr_date');
            var instructions = $(this).data('instructions');
            var act_req_form = $(this).data('act_req_form');
           
            // ACTIVE PANE AND LINK
            // $('.nav-tabs a[href="#update_task"]').tab('show');
            $('#addInstructions').modal('show');
            $('#edit_id').val(id);   
            $('#instr_date').val(instr_date); 
            $('#instructions').val(instructions); 
            $('#act_req_form').val(act_req_form);

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
            url:"{{url('delete-instruc')}}",
            type :'get',
            data : {id:id},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);

                if (response.status==true) {  

                    $("#id").val('');
                    getInstructions();
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