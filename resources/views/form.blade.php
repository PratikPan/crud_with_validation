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
        <form id="formsubmit" method="POST">
            @csrf
            <div class="row g-3 m-4">
                <div class="col">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
                    <span class="text-danger error-text" id="namemessageError"></span>
                </div>
                <div class="col">
                    <input type="text" id="mobile" name="mobile" class="form-control" maxlength="10"
                        placeholder="Mobile Number">
                    <span class="text-danger error-text" id="mobilemessageError"></span>

                </div>
            </div>
            <div class="row g-3 m-4">
                <div class="col">
                    <input type="date" id="dob" name="dob" class="form-control" placeholder="Date of Birth">
                    <span class="text-danger error-text" id="dobmessageError"></span>
                </div>
                <div class="col">
                    <label class="form-check-label" for="">Gender: </label><br>
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male" checked>
                    <label class="form-check-label" for="gender">
                        Male
                    </label>
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                    <label class="form-check-label" for="gender">
                        Female
                    </label>
                </div>
            </div>
            <div class="row g-3 m-4">
                <div class="col">
                    <input type="file" id="image" name="image" class="form-control">
                    <span class="text-danger error-text" id="imagemessageError"></span>
                </div>
                <div class="col">
                    <input type="submit" id="formsubmit" value="Submit" class="btn btn-sm btn-primary">
                    <input type="button" id="clear" value="Clear" class="btn btn-sm btn-danger">
                    <a href="/" class="btn btn-sm btn-dark">Back</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#formsubmit').on('submit', function(e) {
                e.preventDefault();

                var fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('name', $('#name').val());
                fd.append('mobile', $('#mobile').val());
                fd.append('dob', $('#dob').val());
                fd.append('gender', $('input[name="gender"]:checked').val());
                fd.append('image', $('#image')[0].files[0]);


                $.ajax({
                    url: "{{ route('form.post') }}",
                    method: 'post',
                    data: fd,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $('span.error-text').text('');
                    },
                    success: function(res) {

                        if (res.code == 0) {
                            $.each(res.error, function(index, val) {
                                $('#' + index + 'messageError').text(val[0]);
                            })
                        } else {
                            $('#formsubmit')[0].reset();
                            alert("Successfully Added");
                        }
                        // console.log(res);
                        // var msg = "";
                        // if (res.success != undefined) {
                        //     alert(res.success);
                        // } else {
                        //     console.log(res.name);
                        //     if (res.name != undefined) {
                        //         $('#namemessageError').text(res.name[0]);
                        //     } else {
                        //         $('#namemessageError').html('');
                        //     }
                        //     if (res.dob != undefined) {
                        //         $('#dobmessageError').text(res.dob[0]);
                        //     } else {
                        //         $('#dobmessageError').html('');
                        //     }
                        //     if (res.mobile != undefined) {
                        //         $('#mobilemessageError').text(res.mobile[0]);
                        //     } else {
                        //         $('#mobilemessageError').html('');
                        //     }

                        // }
                    }
                })
            })
            $('#clear').click(function() {
                $('#formsubmit')[0].reset();
            });
        })
    </script>
</body>

</html>
