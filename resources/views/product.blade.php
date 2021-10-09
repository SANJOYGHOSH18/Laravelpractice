<!DOCTYPE html>
<html>
<head>
    <title>Laravel Crud operation using ajax</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        label.error {
             color: #dc3545;
             font-size: 14px;
             /* font-weight: bold; */
        }

        /* .w-5{
                 display: none;
        } */

        .form-pos {

            float: right;
            clear: both;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Laravel Crud with Ajax</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewproduct"> Create New Product</a>

    {{-- @if(Session::has('success'))
      <div class="alert alert-success" align="center" id="success">
        <strong>{{Session::get('success')}}</strong>
      </div>
    @endif

    @if(Session::has('error'))
      <div class="alert alert-success" align="center" id="error">
        <strong>{{Session::get('error')}}</strong>
      </div>
    @endif --}}

    <div class="flash-message" align="center" id="flash-message"></div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Variant</th>
                <th>Item No</th>
                <th>Product Description</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" method="post" action="javascript:void(0)">
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Product Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="prod_name" name="prod_name" placeholder="Enter Product Name" value="" maxlength="50" required>
                            {{-- <span class="text-danger error-text prod_name_error">@error('email'){{$message}} @enderror</span> --}}
                            <span class="text-danger">
                                <strong id="prod_name-error"></strong>
                            </span>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Product Price</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="prod_price" name="prod_price" placeholder="Enter Product Price" value="" maxlength="50" required>
                            {{-- <span class="text-danger error-text prod_price_error">@error('email'){{$message}} @enderror</span> --}}
                            <span class="text-danger">
                                <strong id="prod_price-error"></strong>
                            </span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Product Variant</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="prod_variant" name="prod_variant" placeholder="Enter Product Variant" value="" maxlength="50" required>
                            {{-- <span class="text-danger error-text prod_variant_error">@error('email'){{$message}} @enderror</span> --}}
                            <span class="text-danger">
                                <strong id="prod_variant-error"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Item No</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="item_no" name="item_no" placeholder="Enter Item No" value="" maxlength="50" required>
                            {{-- <span class="text-danger error-text item_no_error">@error('email'){{$message}} @enderror</span> --}}
                            <span class="text-danger">
                                <strong id="item_no-error"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Product Description</label>
                        <div class="col-sm-12">
                            <textarea id="prod_description" name="prod_description" required="" placeholder="Enter Product Description" class="form-control"></textarea>
                            {{-- <span class="text-danger error-text prod_description_error">@error('email'){{$message}} @enderror</span> --}}
                            <span class="text-danger">
                                <strong id="prod_description-error"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



<script type="text/javascript">

  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'prod_name', name: 'prod_name'},
            {data: 'prod_price', name: 'prod_price'},
            {data: 'prod_variant', name: 'prod_variant'},
            {data: 'item_no', name: 'item_no'},
            {data: 'prod_description', name: 'prod_description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewproduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editProduct', function () {

      var id = $(this).data('id');

      $.get("{{ route('products.index') }}" +'/' + id +'/edit', function (data) {

          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-product");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#prod_name').val(data.prod_name);
          $('#prod_price').val(data.prod_price);
          $('#prod_variant').val(data.prod_variant);
          $('#item_no').val(data.item_no);
          $('#prod_description').val(data.prod_description);

      })
   });


    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Save');

        // var _token = $("input[name='_token']").val();
        // var prod_name = $("#prod_name").val();
        // var prod_price = $("#prod_price").val();
        // var prod_variant = $("#prod_variant").val();
        // var item_no = $("#item_no").val();
        // var prod_description = $("#prod_description").val();

        $( '#prod_name-error' ).html( "" );
        $( '#prod_price-error' ).html( "" );
        $( '#prod_variant-error' ).html( "" );
        $( '#item_no-error' ).html( "" );
        $( '#prod_description-error' ).html( "" );


        $.ajax({
          data: $('#productForm').serialize(),
          //data: {_token:_token, prod_name:prod_name, prod_price:prod_price,prod_variant:prod_variant,item_no:item_no,prod_description:prod_description},
          url: "{{ route('products.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              //alert(data.errors.prod_name[0]);

              if(data.errors) {
                    if(data.errors.prod_name){
                        $( '#prod_name-error' ).html( data.errors.prod_name[0] );
                    }
                    if(data.errors.prod_price){
                        $( '#prod_price-error' ).html( data.errors.prod_price[0] );
                    }
                    if(data.errors.prod_variant){
                        $( '#prod_variant-error' ).html( data.errors.prod_variant[0] );
                    }
                    if(data.errors.item_no){
                        $( '#item_no-error' ).html( data.errors.item_no[0] );
                    }
                    if(data.errors.prod_description){
                        $( '#prod_description-error' ).html( data.errors.prod_description[0] );
                    }
            }

            if(data.success) {

                $('#flash-message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert">×</button>' + data.success + '</div>');

                $('#productForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
            }

              console.log('Success:', data);

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });


    $('body').on('click', '.deleteProduct', function () {

        var id = $(this).data("id");

        confirm("Are You sure want to delete !");

        $.ajax({
            type: "DELETE",
            url: "{{ route('products.store') }}"+'/'+id,
            dataType: 'json',
            success: function (data) {
                table.draw();
                //alert(data.success);
                $('#flash-message').html('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert">×</button>' + data.success + '</div>');

                console.log('Success:', data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });


  });

</script>

{{-- <script src="{{asset('js/main.js')}}"></script> --}}

</body>
</html>
