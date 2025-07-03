<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
</head>

<body>

    <div class="container">
        <h2>Bordered Table</h2>
        <div class="container">
            <h2>Panel Heading</h2>
            <div class="panel panel-primary">
                <div class="panel-heading">List Projects</div>
                <div class="panel-body">
                    <p>The .table-bordered class adds borders to a table:</p>
                    <div class="row">
                        <div class="col-sm-10">
                            <table class="table table-bordered" id="tbl-project">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>#Project Name</th>
                                        <th>#Client</th>
                                        <th>#Technology</th>
                                        <th>#Excerpt</th>
                                        <th>#Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Portfolio Theme WP</td>
                                        <td>DC Aditya Dubey</td>
                                        <td>WP,PHP,jQUERY</td>
                                        <td>Dynamic Project Portfolio theme</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-info">View</a>
                                            <a href="javascript:void(0)" class="btn btn-warning">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function () {
            $('#tbl-project').DataTable();
        });
    </script>
</body>

</html>