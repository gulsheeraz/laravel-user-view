<div class="container mt-5">
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>User Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Roles</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@include('users.modal')


@push('scripts')
    
    <script type="text/javascript">
      $(function () {
        
        // Populate users list, server side enabled
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.list') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: 'department_id', name: 'department_id'},
                {data: 'roles', name: 'roles'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });

        // Show user detail using ajax request
        $(document).on('click', '.user-detail', function(){
   
            var userid = $(this).data('id');
            $('#userDetail').modal('show'); 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // AJAX request
            $.ajax({
                url: "{{ route('users.detail') }}",
                type: 'post',
                data: {id: userid},
                success: function(response){ 
                    // Add response in Modal body
                    $('.modal-body').html(response);

                    // Display Modal
                    $('#userDetail').modal('show'); 
                }
            });
        });

        // Close user detail modal
        $(document).on('click', '.close', function(){
            $('#userDetail').modal('hide');     
        });

        // Event for modal close
        $('#userDetail').on('hidden.bs.modal', function () {
            $('#userDetail  .modal-body').html('loading...'); 
        });
        
      });
    </script>

@endpush