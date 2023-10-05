<?php
    session_start();
    include 'connection.php';
    $event_id = isset($_GET['eventID']) ? $_GET['eventID'] : null;
    $email = isset($_GET['email']) ? $_GET['email'] : null;
    
    // try {
    //     if ($event_id !== null && $email !== null) {
    //         $connection = openConnection();
    //         $strSql = "SELECT * FROM participants where event_id = '$event_id' and email = '$email'";
    //         $result = mysqli_query($connection, $strSql);
    //         if ($result) {
    //             if (mysqli_num_rows($result) > 0) {
    //                 $reqPersons = mysqli_fetch_array($result);
    //                 mysqli_free_result($result);
    //             }
    //         }
           
    //     } else {
    //         throw new Exception('No event ID or email');
    //     }
    // } catch (Exception $e) {
    //     echo 'Error: ' . $e->getMessage();
    // }

    function getAttendance($connection, $email, $event_id){
        $sessionsInfo = array();
        $sqlSelectAttendance = "SELECT * FROM attendance as a join event_sessions as es on a.session_id = es.session_id  where a.event_id = '$event_id' and a.email = '$email'";
        $result = mysqli_query($connection, $sqlSelectAttendance);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $sessionsInfo[] = $row;
            }
        }
        return $sessionsInfo;
    }
?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php //include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form method="post">
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="suggestion">Suggestion:</label>
                                <textarea class="form-control" id="suggestion" name="suggestion" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="S_event">Would yougo to a similar event in the future:</label>
                                <input class="form-control" id="S_event" name="S_event"required></input>
                            </div>
                            <div class="row card">
                                <label for="card-body-survey">Which of the sessions did you enjoy? Why?</label>
                                <div class="card-body" id="card-body-survey">
                                    <?php 
                                        $connection = openConnection();
                                        $attendance = getAttendance($connection, $email, $event_id);
                                        foreach ($attendance as $attended){
                                            echo '
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="session1" name="session[]" value="'.$attended['session_id'].'">
                                                        <label class="form-check-label" for="session1">'.$attended['session_title'].'</label>
                                                    </div>
                                                ';
                                        }
                                    ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="btnSubmit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

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

<?php
if(isset($_POST['btnSubmit'])){
    $connection = openConnection();
    $comment = $_POST['comment'];
    $suggestion = $_POST['suggestion'];
    $S_event = $_POST['S_event'];
    $sqlInsertComment = "INSERT INTO comment (comment, suggestion, similar_event, event_id, email) VALUES('$comment', '$suggestion', '$S_event', '$event_id', '$email')";
    
    if (mysqli_query($connection, $sqlInsertComment)) {
        $comment_id = mysqli_insert_id($connection);

        // Check if any checkboxes were selected
        if (isset($_POST['session']) && is_array($_POST['session'])) {
            foreach ($_POST['session'] as $session_id) {
                // Insert each selected session into the survey table
                $sqlInsertSurvey = "INSERT INTO survey (comment_id, session_id) VALUES ('$comment_id', '$session_id')";
                mysqli_query($connection, $sqlInsertSurvey);
            }
        }
        echo '<script type="text/javascript">
                swal({
                    title: "Success",
                    text: "Redirecting in 2 seconds.\nSuccessfully Answered survey",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = "post-survey.php";
                });
            </script>';
    }
}
?>