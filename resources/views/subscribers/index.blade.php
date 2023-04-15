<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
    <h1>Subscribers</h1>
    <a href="/subscribers/create">Add Subscriber</a>
    <table id="subscribers-table" class="table table-striped">
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Country</th>
                <th>Subscribe Date</th>
                <th>Subscribe Time</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function() {
            let table = $('#subscribers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/subscribers',
                    type: 'GET',
                },
                columns: [
                    { data: 'email', name: 'email' },
                    { data: 'name', name: 'name' },
                    { data: 'country', name: 'country' },
                    { data: 'date_subscribe', name: 'date_subscribe' },
                    { data: 'time_subscribe', name: 'time_subscribe' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });

            $(document).on('click', '.delete-subscriber', function() {
                const subscriber_id = $(this).data('id');
                $.ajax({
                    url: '/subscribers/' + subscriber_id,
                    type: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        table.ajax.reload();
                        alert('Subscriber deleted successfully.');
                    },
                    error: function(response) {
                        alert('Error deleting subscriber.');
                    },
                });
            });
        });
    </script>
</body>
</html>

