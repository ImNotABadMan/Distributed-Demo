@extends('voyager::master')

@section("head")
{{--    <link rel="stylesheet" type="text/css" href="{{ asset("DataTables/datatables.min.css") }}"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset("bootstrap-4.5.0/css/bootstrap.css") }}"/>--}}
@endsection

@section("content")
    <div class="container">
        <table id="redis" class="display">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
            </thead>
        </table>

    </div>
    <script type="text/javascript" src="{{ asset("js/jquery.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("DataTables/datatables.min.js") }}"></script>
    <script>
        $(document).ready(function () {
            $('#redis').DataTable({
                "ajax": "{{ route("admin.redis.all") }}",
                "columns" : [
                    {"data" : "key"},
                    {"data" : "value"},
                ]
            });
        });
    </script>

@endsection


