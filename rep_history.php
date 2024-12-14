<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/history.css">
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Reports</h4>
                        <a href="admin_dashboard.php" class="btn btn-primary btn-sm float-end">Back to Home</a>
                    </div>
                    <div class="card-body">
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Report Title</th>
                                    <th>Report Details</th>
                                    <th>Report Type</th>
                                    <th>Report Image</th>
                                    <th>Report Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","auth");

                                    // Fetching data in descending order by ID
                                    $query = "SELECT * FROM report ORDER BY id DESC"; 
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $row)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= $row['user']; ?></td>
                                                <td><?= $row['title']; ?></td>
                                                <td><?= $row['details']; ?></td>
                                                <td><?= $row['type']; ?></td>
                                                <td><img width="50" height="50" src="upload/<?= $row['image']; ?>"></td>
                                                <td><?= $row['date']; ?></td>                                          
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <tr>
                                                <td colspan="7">No Record Found</td>
                                            </tr>
                                        <?php
                                    }
                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
