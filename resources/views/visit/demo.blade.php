@extends('common.master')
<?php $title=config('constants.PROJECT_NAME'); 
    $roles=Session::get('ROLES');
    $role=explode(',',$roles);
    $count=count($role);
?>
<?php use App\Http\Controllers\CommonController as Common; ?>
@section('title',"Specification Management | $title")

@push('page_css')

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
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
                            {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
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
                           <h4 class="card-title mb-4">Product Management</h4>
                           <div class="ms-auto">
                            <h4 class="card-title mb-4">Technical Management</h4>
                            </div>
                        </div>
                        @include('common.alert')
                        <div id="alerts">
                        </div>
                        {!! Form::open(['class'=>"form-horizontal",'method'=>"post",'url'=>'add_specification','id'=>'product_from']) !!}
                        <div class="row">
                            <input type="hidden" name="id" id="id">
                            <div class="col-md-6 col-sm-12 mb-2">   
                                <textarea  id="summernote" name="product_description"></textarea>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2">   
                                <textarea  id="summernote1" name="tech_description"></textarea>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            </div>
                        </div> 
                        {!! Form::close() !!}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('common.delete_modal')    
@stop
@push('page_js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
      placeholder: '',
      tabsize: 2,
      height: 1000,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
    $('#summernote1').summernote({
      placeholder: '',
      tabsize: 2,
      height: 1000,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });

    $(document).ready(function(){
       	//for user Bookmarks modal
        $.ajax({		            
            url:"{{url('get-specification')}}",
            type :'get',
            data : {},
            cache: false,
            dataType: 'json',
            success: function(data) 
            {
                console.log(data.data);
                  
                $.each(data.data,function(index,row){
                    // $('#editorCopy').val(response.description);
                    $('#id').val(row.id);
                    $("#summernote").summernote("code", row.product_description);
                    $("#summernote1").summernote("code", row.tech_description);
                });
            }
        });
    });
    

</script>
@endpush