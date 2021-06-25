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
          <div class="col-md-12">
            <form id="post-form">
             <div class="card card-dark">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Appear Table</h3>
              </div>
                <div class="card-body table-responsive p-0" style="height: 250px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Designation</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="table_two_append">

                  </tbody>
                </table>
              </div>

              <div class="card-footer">
                  <input type="submit" onclick="finalSubmitForm()" class="btn btn-success float-right">
              </div>
            </div>
            </form>
           </div>
      </div>


@endsection

@section('scripts')

  <script src="{{ asset('/') }}/asset/plugins/toastr/toastr.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


<script>

        if ($("#post-form").length > 0) {
      
            $("#post-form").validate({
            rules: {
              'address[]': {
                required: true,
              },
              'phone[]': {
                required: true,
                number: true
              },
              'email[]': {
                required: true
              }
            },
            //this message will appear when validation error occurs
            messages: {
              'address[]': {
                required: "Please Enter Address",
              },
              'phone[]': {
                required: "Please Enter Phone",
                number: "Please Enter Only Numbers",
              },
              'email[]': {
                required: "Please Enter Email",
              }
            },
            submitHandler: function(form) {
              
              }
          })
        }

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
                                        '<td><a href="#" class="btn btn-sm btn-primary selected_row" id="selected_row_id'+value.id+'"  data-id="'+value.id+'"> select </a></td>'+
                                        '</tr>'

                      $('#search_result').append(table_row);

                      })


                    },
                   error: function (error) {
                        console.log(error);
                    }
                })
        })


        $(document).on('click','.selected_row',function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#selected_row_id'+id).removeClass('btn btn-sm btn-primary').addClass('btn btn-sm btn-success')
            $.ajax({
                method: 'POST',
                url: adminUrl + '/individualAppend/data',
                data: {'id':id},
                dataType: 'JSON',
                success: function (data) {
                    
                  var table_two_row = '';

                    table_two_row = '<tr>'+
                                  '<td style="display:none"><input readonly class="form-control"  name="id[]" value="'+data.id+'"/></td>'+
                                  '<td><input readonly class="form-control" type="text" name="name[]" value="'+data.name+'"/></td>'+
                                  '<td><input readonly class="form-control" type="text" name="designation[]" value="'+data.designation+'"/></td>'+
                                  '<td><input  class="form-control" type="text" name="address[]" /></td>'+
                                  '<td><input class="form-control" type="text" name="phone[]" /></td>'+
                                  '<td><input class="form-control" type="email" name="email[]" /></td>'+
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

       

      //  ************************ we dont need to insert name and designation again. so i take employee_id as foreign key and insert the rest of the information*************


         function getInputs() {
            var id = $('input[name="id[]"]').map(function(){ 
                    return this.value; 
                }).get();
            var email = $('input[name="email[]"]').map(function(){ 
                    return this.value; 
                }).get();
            var address = $('input[name="address[]"]').map(function(){ 
                    return this.value; 
                }).get();
            var phone = $('input[name="phone[]"]').map(function(){ 
                    return this.value; 
                }).get();

            return {'id[]': id,'email[]': email,'address[]': address,'phone[]': phone}
        }

        function finalSubmitForm() {
          var emptyVal = false;
          var phone = $('input[name="phone[]"]').map(function(){ 
                    return this.value; 
                }).get();

          $.each(phone,function(index,value){
            if(value == ''){
              emptyVal = true;
            }
          })

          if(emptyVal == false){
            finalSubmit()
          }else{
            alert("some of your field is empty")
          }

        }

          function finalSubmit(){

                    $.ajax({
                        method: 'POST',
                        url: adminUrl + '/final/store',
                        data: getInputs(),
                        dataType: 'JSON',
                        success: function () {

                        $('#search_result').html('');
                        $('#table_two_append').html('');

                        successToast()

                          $('#designation_search').val('')

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    })
                }

                function successToast(){
                toastr.success('data added successfully')
        }
          
        
   
</script>

@endsection