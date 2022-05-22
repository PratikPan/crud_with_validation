<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
</head>

<body>

    <div class="container mt-5">
        <table class="table table-striped">
            <tr class="text-center">
                <th>Name</th>
                <th>Mobile No.</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            <tbody id="getdata">

            </tbody>
        </table>

        <a href="/form" class="btn btn-dark my-5">Add</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $.ajax({
                url: "{{ route('getuserdata') }}",
                method: 'get',
                success: function(res) {
                    // console.log(res);
                    $.each(res, function(index, val) {
                        var datatable = '<tr class="text-center">';
                        datatable += '<td>' + val.name + '</td>';
                        datatable += '<td>' + val.mobile_no + '</td>';
                        datatable += '<td>' + val.dob + '</td>';
                        datatable += '<td>' + val.gender + '</td>';

                        datatable +=
                            '<td><a class="btn btn-sm btn-danger" id="deletebtn" data-id="' +
                            val.id + '">Delete</a></td></tr>';
                        $('#getdata').append(datatable);
                    })
                }
            })

            $(document).on('click', '#deletebtn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('deletedata') }}",
                    method: 'delete',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                    },
                    success: function(res) {
                        alert(res.success);
                        // table.ajax.reload(null, false);
                        location.reload();
                    }
                })

                // console.log("hello");
            })
        })
    </script>
</body>

</html>
