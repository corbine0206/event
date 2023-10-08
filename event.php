<?php
    session_start();
    include 'connection.php';
    date_default_timezone_set('Asia/Manila');
    $user_id = $_SESSION['user_id'];

    // Function to get event session titles, dates, and times for a specific event
    function getEventSessionsInfo($connection, $event_id) {
        $sessionsInfo = array();
        $sql = "SELECT session_title, date1, time1, time2 FROM event_sessions WHERE event_id = '$event_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sessionsInfo[] = $row;
            }
        }
        return $sessionsInfo;
    }
    function getEventTechnologyLineCount($connection, $event_id) {
        $techlineCount = "";
        $sql = "SELECT COUNT(*) as tech_count FROM product_technology_lines WHERE event_id = '$event_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $techlineCount = $row['tech_count'];
            return $techlineCount;
        }
        else{
        }
        return $techlineCount;
    }
    function getLastHighestDateTime($connection, $event_id) {
        $sql = "SELECT date1, time2 FROM event_sessions where event_id = '$event_id'  ORDER BY CONCAT(date1, ' ', time2) DESC LIMIT 1";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $lastHighestDateTime = $row['date1'] . ' ' . $row['time2'];
            }
            else{
                $lastHighestDateTime = "No records found";   
            }
            mysqli_free_result($result);
        }
        else{
            $lastHighestDateTime = "Error: " . mysqli_error($conn);
        }
        return $lastHighestDateTime;


    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Event</title>


    <?php include'link.php'; ?>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>            

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-calendar"></i>Event</h6>
                        </div>
                        <div class="card-body">
                            <a href="event-add.php" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Add Event</span>
                            </a>
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Event Name</th>
                                            <th>Session</th>
                                            <th>Technology</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $con = openConnection();
                                        $strSql = "SELECT * FROM events where user_id = '$user_id' order by event_id desc";
                                        $result = getRecord($con, $strSql);
                                        foreach ($result as $key => $event) {
                                            $event_status = $event['event_status'];
                                            echo 
                                            '<tr>
                                                <td>' . ($key + 1) . '</td>
                                                <td>' . $event['event_title'] . '</td>';

                                            // Get the event session titles, dates, and times for the current event
                                            $eventSessions = getEventSessionsInfo($con, $event['event_id']);

                                            echo '<td>';
                                            foreach ($eventSessions as $session) {
                                                echo '<strong>Title:</strong> ' . $session['session_title'] . '<br>';
                                                echo '<strong>Date:</strong> ' . $session['date1'] . '<br>';
                                                echo '<strong>Time:</strong> ' . $session['time1'] . '<br>';
                                                echo '<strong>Time2:</strong> ' . $session['time2'] . '<br><br>';
                                            }
                                            echo '</td>';

                                            echo '
                                                <td>';
                                                echo $techCount = getEventTechnologyLineCount($con, $event['event_id']);

                                            echo '</td>
                                                <td>';
                                                if ($event_status == '2') {
                                                    echo '
                                                    <button class="btn btn-danger btn-circle btnDeleteEvent" data-toggle="modal" data-target="#delete_event" event_id="'.$event['event_id'].'" disabled><i class="fas fa-trash"></i></button>
                                                    <button class="btn btn-warning" disabled><i class="fas fa-edit"></i></button>
                                                    <a href="event-session.php?eventID=' . $event['event_id'] . '" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                                        ';
                                                }
                                                else{
                                                    echo '
                                                    <button class="btn btn-danger btn-circle btnDeleteEvent" data-toggle="modal" data-target="#delete_event" event_id="'.$event['event_id'].'"><i class="fas fa-trash"></i></button>
                                                    <a href="event-edit.php?eventID=' . $event['event_id'] . '" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                    <a href="event-session.php?eventID=' . $event['event_id'] . '" class="btn btn-primary"><i class="fas fa-eye"></i></a>';

                                                }
                                                $lastHighestDateTime = getLastHighestDateTime($con, $event['event_id']);
                                                $dateToday = date('Y-m-d h:i:s');
                                                if ($lastHighestDateTime < $dateToday) {
                                                    $linkOrButton = '<a href="send-email-event-done.php?eventID=' . $event['event_id'] . '" class="btn btn-success"><i class="fa fa-telegram green-color"></i></a>';
                                                } else {
                                                    $linkOrButton = '<button class="btn btn-success" disabled><i class="fa fa-telegram green-color"></i></button>';
                                                }
                                                
                                                echo $linkOrButton;
                                            echo '
                                                </td>
                                                ';
                                                echo '
                                            </tr>';
                                        }
                                        closeConnection($con);

                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <?php include'script.php'; ?>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
    $('.btnDeleteEvent').on('click', function () {
       var event_id = $(this).attr('event_id');
      $("#event_id").val(event_id);
    });
  });
</script>
<!-- Delete modal -->
<form method="post">
    <div class="modal fade" id="delete_event" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete event</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this event?</h5>
                    <input type="hidden" name="event_id" id="event_id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" name="btnDeleteEvent">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Delete modal -->

<?php
    if (isset($_POST['btnDeleteEvent'])) {
        $connection = openConnection();
        $event_id = $_POST['event_id'];
        $strSqlDelete = "UPDATE events set event_status = 0 where event_id = '$event_id'";
        if (mysqli_query($connection, $strSqlDelete)){
            $strsqlUpdate = "UPDATE participants SET status = 2 where event_id = '$event_id'";
            if (mysqli_query($connection, $strsqlUpdate)){
                echo '
                <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Redirecting in 2 seconds.\nEvent Deleted",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = "./event.php"; // Replace with the actual page URL
                    });
                </script>
            ';
            }
        }
    }
?>