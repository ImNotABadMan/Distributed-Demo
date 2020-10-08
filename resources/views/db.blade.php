<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DbController</title>
    <link rel="stylesheet" type="text/css" href="{{ asset("DataTables/datatables.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("bootstrap-4.5.0/css/bootstrap.css") }}"/>

</head>
<body>
<div class="container">
    <table id="db" class="display" style="width:60%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Name</th>
{{--            <th>Password</th>--}}
{{--            <th>Remember</th>--}}
            <th>email_verified_at</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        </thead>
    </table>

</div>
</body>

<script type="text/javascript" src="{{ asset("js/jquery.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("DataTables/datatables.min.js") }}"></script>
<script>
    $(document).ready(function () {
        $('#db').DataTable({
            "ajax": "{{ route("db.all") }}",
{{--            "ajax": "{{ route("db.one", ["id" => 27]) }}",--}}
            "columns" : [
                {"data" : "id"},
                {"data" : "name"},
                {"data" : "email"},
                // {"data" : "password"},
                // {"data" : "remember_token"},
                {"data" : "email_verified_at"},
                {"data" : "created_at"},
                {"data" : "updated_at"},
            ]
        });
    });
</script>
</html>

