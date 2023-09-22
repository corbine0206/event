<?php
    session_start();
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
    $event_id = $_GET['eventID'];
    if (!isset($event_id)) {
        header("location: event.php");
    }

     function getProductAndTechnology($connection, $technology_id) {
        $prod_techline = array();
        $sql = "SELECT * FROM product_technology_lines WHERE technology_id = '$technology_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $prod_techline[] = $row;
            }
        }
        return $prod_techline;
    }
    function getTechnology($connection, $session_id) {
        $technologies = array();
        $sql = "SELECT * FROM technologies WHERE session_id = '$session_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $technologies[] = $row;
            }
        }
        return $technologies;
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

    <title>Add Event</title>


    <?php include'link.php'; ?>

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
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-calendar"></i> Add Event</h6>
                        </div>
                        <div class="card-body">
                            <form id="eventForm" method="POST" enctype="multipart/form-data" action="update_event.php">
                                <?php
                                    $connection = openConnection();
                                    $eventSql = "SELECT * FROM events where event_id = '$event_id'";
                                    $events = getRecord($connection, $eventSql);
                                    foreach ($events as $key => $event) {
                                        echo '<div class="form-group">
                                                <label for="eventTitle">Event Title:</label>
                                                <input type="text" id="eventTitle" name="eventTitle" class="form-control" value="'. $event['event_title'] .'">
                                            </div>';
                                    }
                                ?>
                                <?php
                                    $sessionSql = "SELECT * FROM event_sessions WHERE event_id = '$event_id'";
                                    $sessions = getRecord($connection, $sessionSql);
                                    foreach ($sessions as $key => $session) {?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="session-${sessionIndex}">Session:</label>
                                                <input type="text" id="session-${sessionIndex}" class="form-control" name="session[]" value="<?php echo $session['session_title']; ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="schedule-${sessionIndex}">Schedule:</label>
                                                <div class="input-group">
                                                    <input type="date" id="schedule-${sessionIndex}" class="form-control date-input" name="date[]" value="<?php echo $session['date1']; ?>" required>
                                                    <select class="form-control time-select" name="time[]" required>
                                                        <option value="<?php echo $session['time1']; ?>"><?php echo $session['time1']; ?></option>
                                                        <option value="06:00">06:00</option>
                                                        <option value="07:00">07:00</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-md-12" id="techContainer-${sessionIndex}">
                                                <?php
                                                $technologies = getTechnology($connection , $session['session_id']);
                                                foreach ($technologies as $technology) { ?>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Technology:</label>
                                                            <input type="text" class="form-control" name="" value="<?php echo $technology['technology_name']; ?>" required>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php
                                                            $prod_techlines = getProductAndTechnology($connection, $technology['technology_id']);
                                                            foreach ($prod_techlines as $key => $prod_techline) {?>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Product:</label>
                                                                        <input type="text" class="form-control" name="" value="<?php echo $prod_techline['product_name']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Technology Line:</label>
                                                                        <input type="text" class="form-control" name="" value="<?php echo $prod_techline['technology_line']; ?>" required>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                   <?php }
                                ?>
                                <div class="form-group">
                                    <label for="csvFile">Select Participants CVS File:</label>
                                    <input type="file" class="form-control-file" name="csvFile" id="csvFile" accept=".csv">
                                </div>
                                <div id="sessionContainer">
                                    <!-- Topics and their Technology, Products, and Technology Lines will be added here dynamically -->
                                </div>
                                
                                <button type="button" id="addSessionBtn" class="btn btn-primary">Add Session</button>

                                <!-- Submit button is inside the form -->
                                <div class="text-center mt-3">
                                    <button type="submit" form="eventForm" class="btn btn-success">Submit</button>
                                </div>
                            </form>
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

<script>
    let sessionIndex = 0;

    document.getElementById("addSessionBtn").addEventListener("click", () => {
        const sessionContainer = document.getElementById("sessionContainer");

        // Add an <hr> element to separate sessions
        if (sessionIndex > 0) {
            const hr = document.createElement("hr");
            sessionContainer.appendChild(hr);
        }

        const sessionDiv = document.createElement("div");
        sessionDiv.className = "form-group";
        sessionDiv.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <label for="session-${sessionIndex}">Session:</label>
                    <input type="text" id="session-${sessionIndex}" class="form-control" name="session[]" required>
                </div>
                <div class="col-md-4">
                    <label for="schedule-${sessionIndex}">Schedule:</label>
                    <div class="input-group">
                        <input type="date" id="schedule-${sessionIndex}" class="form-control date-input" name="date[]" required>
                        <select class="form-control time-select" name="time[]" required>
                            <option value="06:00">06:00</option>
                            <option value="07:00">07:00</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12" id="techContainer-${sessionIndex}">
                    <button type="button" class="addTechBtn" onclick="addTechnology(${sessionIndex})">Add Technology</button>
                </div>
            </div>
        `;

        sessionContainer.appendChild(sessionDiv);
        sessionIndex++;
    });

    function addTechnology(sessionIndex) {
        const techContainer = document.getElementById(`techContainer-${sessionIndex}`);
        const techIndex = techContainer.querySelectorAll('.form-group').length;

        const techDiv = document.createElement("div");
        techDiv.className = "form-group";
        techDiv.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <label>Technology:</label>
                    <input type="text" class="form-control" name="technology[${sessionIndex}][]" required>
                </div>
                <div class="col-md-4">
                    <label>Product:</label>
                    <input type="text" class="form-control" name="product[${sessionIndex}][${techIndex}][]" required>
                </div>
                <div class="col-md-4">
                    <label>Technology Line:</label>
                    <input type="text" class="form-control" name="technologyLine[${sessionIndex}][${techIndex}][]" required>
                </div>
                <div class="col-md-8">
                    <button type="button" class="addTechLineBtn" onclick="addProductAndLine(${sessionIndex}, ${techIndex})">Add Product and Technology Line</button>
                </div>
            </div>
        `;

        techContainer.appendChild(techDiv);
    }

    function addProductAndLine(sessionIndex, techIndex) {
        const techContainer = document.getElementById(`techContainer-${sessionIndex}`);
        const techDiv = techContainer.querySelectorAll('.form-group')[techIndex];
        
        const productContainer = techDiv.querySelector(`[name="product[${sessionIndex}][${techIndex}][]"]`);
        const productInput = document.createElement("input");
        productInput.type = "text";
        productInput.className = "form-control";
        productInput.name = `product[${sessionIndex}][${techIndex}][]`;
        productInput.required = true;

        productContainer.parentNode.insertBefore(productInput, productContainer.nextSibling);

        const techLineContainer = techDiv.querySelector(`[name="technologyLine[${sessionIndex}][${techIndex}][]"]`);
        const techLineInput = document.createElement("input");
        techLineInput.type = "text";
        techLineInput.className = "form-control";
        techLineInput.name = `technologyLine[${sessionIndex}][${techIndex}][]`;
        techLineInput.required = true;

        techLineContainer.parentNode.insertBefore(techLineInput, techLineContainer.nextSibling);
    }
</script>


<?php
    // include 'connection.php';

    // if (isset($_POST['btnSubmit'])) {
    //     $con = openConnection();
    //     $eventTitle = $_POST['eventTitle'];
    //     $strSql = "INSERT INTO event(event_title)VALUES('$eventTitle')";
    //     echo $strSql;
    //     if (mysqli_query($con, $strSql)){
    //         echo '
    //             <script type="text/javascript">
    //                 swal({
    //                     title: "Success",
    //                     text: "Redirecting in 2 seconds.\nSuccessfully add event",
    //                     icon: "success",
    //                     timer: 2000,
    //                     showConfirmButton: false
    //                 }).then(function() {
    //                     window.location.href = "./event-add.php";
    //                 });
    //             </script>
    //         ';
    //     }
    //     else{
    //         echo '
    //             <script type="text/javascript">
    //                 swal({
    //                     title: "Failed",
    //                     text: "Redirecting in 2 seconds.\Failed add event",
    //                     icon: "warning",
    //                     timer: 2000,
    //                     showConfirmButton: false
    //                 }).then(function() {
    //                     window.location.href = "./event-add.php";
    //                 });
    //             </script>
    //         ';
    //     }
    // }
?>
