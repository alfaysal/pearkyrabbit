@extends('back-end.master')

@section('title')
  <title>Perkyrabbit Search Insert</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('/') }}/asset/plugins/toastr/toastr.min.css">
  
@endsection


@section('bread_crumb')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0  text-center">Search Employee Designation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endsection


@section('content')
  
    <div class="row">
           <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="input-group">
                        <input type="search" id="designation_search" name="designation"  class="form-control form-control-lg" placeholder="Type designation here">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>

      <div class="row mt-3">
          <div class="col-md-8 offset-md-2">
             <div class="card card-dark">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Search Result</h3>
              </div>
                <div class="card-body table-responsive p-0" style="height: 250px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Designation</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="search_result">

                  </tbody>
                </table>
              </div>
            </div>
           </div>
      </div>

      <div class="row mt-3" id="table_two">
          <div class="col-md-8 offset-md-2">
             <div class="card card-dark">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Appear Table</h3>
              </div>
                <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Designation</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="table_two_append">

                  </tbody>
                </table>
              </div>
            </div>
           </div>
      </div>


@endsection

@section('scripts')

<script>


        var adminUrl = '{{ url('Search_Insert') }}';

        $.ajaxSetup({
          headers: {'X-CSRF-Token': '{{ csrf_token() }}'}
        });

        $('body').on('keyup','#designation_search',function() {
              var designation = $('input[name="designation"]').val()
              $.ajax({
                    method: 'POST',
                    url: adminUrl + '/employee/search',
                    data: {'designation':designation},
                    dataType: 'JSON',
                    success: function (data) {
                      var table_row = '';

                      $('#search_result').html('');

                      $.each(data,function(index,value){

                          table_row = '<tr>'+
                                        '<td>'+value.name+'</td>'+
                                        '<td>'+value.designation+'</td>'+
                                        '<td><a href="#" class="btn btn-sm btn-primary" id="selected_row" data-id="'+value.id+'"> select </a></td>'+
                                        '</tr>'

                      $('#search_result').append(table_row);

                      })


                    },
                   error: function (error) {
                        console.log(error);
                    }
                })
        })


        $(document).on('click','#selected_row',function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                method: 'POST',
                url: adminUrl + '/individualAppend/data',
                data: {'id':id},
                dataType: 'JSON',
                success: function (data) {
                    
                  var table_two_row = '';

                    table_two_row = '<tr>'+
                                  '<td>'+data.name+'</td>'+
                                  '<td>'+data.designation+'</td>'+
                                  '<td>'+data.address+'</td>'+
                                  '<td>'+data.phone+'</td>'+
                                  '<td><a href="#" class="btn btn-sm btn-danger" id="remove_row" data-id="'+data.id+'"> remove </a></td>'+
                                  '</tr>'

                $('#table_two_append').append(table_two_row);

                },
               error: function (error) {
                    console.log(error);
                }
            })
        })

        $("#table_two").on("click", "#remove_row", function (event) {
              $(this).closest("tr").remove();
          });

       

          
        
   
</script>

@endsection