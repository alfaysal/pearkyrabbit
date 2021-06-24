@extends('back-end.master')

@section('title')
  <title>Perkyrabbit Dashboard</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('/') }}/asset/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  
  <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

@endsection


@section('bread_crumb')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0  text-center">Create Employee</h1>
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
             <div class="card card-dark">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Create Employee</h3>
                <a class="btn btn-success btn-sm pull-right" onclick="createSupplier()">Add New</a>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body table-responsive p-0">

                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  
                  </tfoot>
                </table>
              </div>
            </div>
           </div>
        </div>

        <div class="modal fade" id="employee_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control input-sm" type="text" name="name">
                        </div>

                        <div class="form-group">
                            <label>Designation</label>
                            <input class="form-control input-sm" type="text" name="designation">
                        </div>

                       
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary SupplierbtnSave"
                                onClick="storeEmployee()">Save
                        </button>
                        <button type="button" class="btn btn-primary SupplierbtnUpdate"
                                onClick="supplierUpdate()">Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
      

@endsection

@section('scripts')
  <script src="{{ asset('/') }}/asset/plugins/toastr/toastr.min.js"></script>

  <script src="{{ asset('/') }}/asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('/') }}/asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('/') }}/asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('/') }}/asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('/') }}/asset/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('/') }}/asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- jquery validation cdn -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>


        var employee_modal = $('#employee_modal');
        var SupplierbtnSave = $('.SupplierbtnSave');
        var SupplierbtnUpdate = $('.SupplierbtnUpdate');
        var adminUrl = '{{ url('Employee') }}';

        var table = $('#example1').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{{ route('datatables_data') }}',
              columns: [
                  { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                  { data: 'name', name: 'name' },
                  { data: 'designation', name: 'designation' },
                  { data: 'action', name: 'action' },
              ]
        });
        


          $.ajaxSetup({
            headers: {'X-CSRF-Token': '{{ csrf_token() }}'}
          });

          function createSupplier() {
            employee_modal.find('.modal-title').text('New Supplier');
            
            employee_modal.modal('show')
            SupplierbtnSave.show()
            SupplierbtnUpdate.hide()
         }

         function getInput() {
            var id = $('input[name="id"]').val()
            var name = $('input[name="name"]').val()
            var designation = $('input[name="designation"]').val()
            return {id: id, name: name,designation: designation}
        }

         function storeEmployee(){
            $.ajax({
                method: 'POST',
                url: adminUrl + '/employee/store',
                data: getInput(),
                dataType: 'JSON',
                success: function () {
                    employee_modal.modal('hide')
                    successToast()  
                    table.ajax.reload(null,false) 
                    reset()             

                },
               error: function (error) {
                    console.log(error);
                }
            })
        }

        function successToast(){
                toastr.success('data added successfully')
        }

        function infoToast(){
                toastr.info('data updated successfully')
        }

        function errorToast(){
                toastr.error('data deleted')
        }

        $(document).on('click','#edit',function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                method: 'POST',
                url: adminUrl + '/edit/data',
                data: {'id':id},
                dataType: 'JSON',
                success: function (data) {

                  employee_modal.modal('show')
                  employee_modal.find('.modal-title').text('Update Supplier');

                  $('input[name="id"]').val(data.data.id)
                  $('input[name="name"]').val(data.data.name)
                  $('input[name="designation"]').val(data.data.designation)
                  SupplierbtnSave.hide()
                  SupplierbtnUpdate.show()            
                },
               error: function (error) {
                    console.log(error);
                }
            })
        })

        function reset() {
            employee_modal.find('input').each(function () {
                $(this).val(null)
            })
        }

        employee_modal.on('hidden.bs.modal', function () {
            reset()
        })
        function supplierUpdate() {
          $.ajax({
                method: 'POST',
                url: adminUrl + '/employee/update',
                data: getInput(),
                dataType: 'JSON',
                success: function () {
                    employee_modal.modal('hide')
                    infoToast();
                    table.ajax.reload(null,false) 
                    reset()             

                }
            })
        }

         $(document).on('click','#delete',function(e) {
            if(!confirm('Are you sure?')) return;

            var id = $(this).data('id');

            $.ajax({
                method: 'POST',
                url: adminUrl + '/delete/data',
                data: {'id':id},
                dataType: 'JSON',
                success: function (data) {
                    table.ajax.reload(null,false) 
                    errorToast();        
                },
               error: function (error) {
                    console.log(error);
                }
            })
        })
   
</script>

@endsection