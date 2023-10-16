<?php
    session_start();
    include 'connection.php';
    require 'vendor/autoload.php'; // Include Composer's autoloader

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
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
    function getTechnologies($connection, $session_id){
        $technologiesArray = array();
        $sqlTechnologies = "SELECT * FROM technologies where session_id = '$session_id'";
        $result = mysqli_query($connection, $sqlTechnologies);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $technologiesArray[] = $row;
            }
        }
        return $technologiesArray;
    }
?>
    <?php include 'link.php'; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    /* Define the hidden class to hide elements */
    .hidden {
        display: none;
    }
    .bg-primary {
    background-color: #C9C9C8!important;
}
/* Center the content both horizontally and vertically */
.vh-100 {
  min-height: 100vh;
}

/* Add this CSS to your stylesheet or within a <style> tag in your HTML */


</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var checkboxes = document.querySelectorAll('.session-checkbox');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                var sessionId = this.getAttribute('data-session');
                var techCheckboxes = document.querySelectorAll('.tech-checkboxes[data-session="' + sessionId + '"] input[type="checkbox"]');
                var techLabels = document.querySelectorAll('.tech-checkboxes[data-session="' + sessionId + '"] label');

                techCheckboxes.forEach(function (techCheckbox, index) {
                    // Toggle the hidden class to show/hide the checkboxes
                    techCheckbox.classList.toggle("hidden", !this.checked);
                    // Enable/disable the checkboxes based on the session checkbox
                    techCheckbox.disabled = !this.checked;

                    // Toggle the hidden class for the associated labels
                    techLabels[index].classList.toggle("hidden", !this.checked);

                    // Log the sessionId and checkbox visibility
                    console.log("Session ID:", sessionId);
                    console.log("Checkbox Hidden:", techCheckbox.classList.contains("hidden"));
                    // Remove the "hidden" class from the .tech-checkboxes div when the session checkbox is checked
                    var techCheckboxesDiv = document.querySelector('.tech-checkboxes[data-session="' + sessionId + '"]');
                    if (this.checked) {
                        techCheckboxesDiv.classList.remove("hidden");
                    }
                }.bind(this));
            });
        });
    });
</script>


<!-- Your HTML code remains unchanged -->

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php //include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <?php
                        $connection = openConnection();
                        $attendance = getAttendance($connection, $email, $event_id);
                        if (!empty($attendance)){ ?>
                            <form method="post">
                                <div class="row card">
                                    <label for="card-body-survey">Which of the sessions did you enjoy? Why?</label>
                                    <div class="card-body" id="card-body-survey">
                                        <?php
                                            foreach ($attendance as $key => $value) {
                                                $sessionId = $value['session_id'];
                                                ?>
                                                <label>
                                                    <input type="checkbox" class="session-checkbox" data-session="<?php echo $sessionId; ?>" name="session[]" value="<?php echo $sessionId; ?>">
                                                    <?php echo $value['session_title']; ?>
                                                </label>

                                                <div class="tech-checkboxes hidden" data-session="<?php echo $sessionId; ?>">
                                                    <?php
                                                    $technologies = getTechnologies($connection, $sessionId);
                                                    foreach ($technologies as $checkboxValue) {
                                                        ?>
                                                        <label for="technology_<?php echo $sessionId; ?>[]">
                                                            <input type="checkbox" name="technology_<?php echo $sessionId; ?>[]" id="technology_<?php echo $sessionId; ?>[]"value="<?php echo $checkboxValue['technology_id']; ?>">
                                                            <?php echo $checkboxValue['technology_name']; ?>
                                                        </label>
                                                        <?php
                                                    }
                                                    ?>
                                                </div><br>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
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
                                <button type="submit" class="btn btn-primary" name="btnSubmit">Submit</button>
                            </form>
                        <?php
                        }
                        else{
                            echo '
                                <div class="col-md-12 d-flex justify-content-center align-items-center vh-100">
                                    <div class="card bg-primary">
                                        <div class="card-body text-center">
                                        <h5>No Session attended</h5>
                                        </div>
                                    </div>
                                </div>
                                ';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright Demand &copy; Generation</span>
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
if (isset($_POST['btnSubmit'])) {
    $connection = openConnection();
    $comment = $_POST['comment'];
    $suggestion = $_POST['suggestion'];
    $S_event = $_POST['S_event'];
    $sqlInsertComment = "INSERT INTO comment (comment, suggestion, similar_event, event_id, email) VALUES ('$comment', '$suggestion', '$S_event', '$event_id', '$email')";

    if (mysqli_query($connection, $sqlInsertComment)) {
        $comment_id = mysqli_insert_id($connection);

        // Check if any checkboxes were selected
        if (isset($_POST['session']) && is_array($_POST['session'])) {
            foreach ($_POST['session'] as $session_id) {
                // Insert each selected session into the survey table
                $sqlInsertSurvey = "INSERT INTO survey (comment_id, session_id) VALUES ('$comment_id', '$session_id')";
                mysqli_query($connection, $sqlInsertSurvey);
                $survey_id = mysqli_insert_id($connection);

                // Check if any technology checkboxes were selected for this session
                if (isset($_POST['technology_' . $session_id]) && is_array($_POST['technology_' . $session_id])) {
                    foreach ($_POST['technology_' . $session_id] as $tech_id) {
                        // Insert each selected technology into the survey_technologies table
                        $sqlInsertSurveyTechnologies = "INSERT INTO survey_technologies (survey_id, technology_id) VALUES ('$survey_id', '$tech_id')";
                        mysqli_query($connection, $sqlInsertSurveyTechnologies);
                    }
                }
            }
        }
        $sqlProductRec = "SELECT * FROM survey_technologies as st 
                           join response as r on st.technology_id = r.technology_id
                           join product_technology_lines as pt on r.product_id = pt.product_id
                           where r.event_id = '$event_id' & email ='$email'";
        $resultProd = getRecord($connection, $sqlProductRec);

        if ($resultProd) {
            $printedProductIds = [];
            $productRecommended = [];
            foreach ($resultProd as $key => $prod) {
                $productId = $prod['product_id'];
                
                // Check if this product_id has already been printed
                if (!in_array($productId, $printedProductIds)) {
                    // Print the product_id
                    
                    
                    // Print other data from the row
                    
                    // Add more fields as needed
                    
                    // Add the product_id to the printedProductIds array
                    $printedProductIds[] = $productId;
                    $productRecommended[] =  $prod['product_name'];
                }
        
                // If you want to print other data for each occurrence of the same product_id, you can do it here within this loop.
            }
        } else {
            echo "NO DATA FOUND";
        }
        // Format the $productRecommended array as a list
        $productRecommendedList = implode("<br>", $productRecommended);
        $emailContent = '<br><strong>Product Recommended:</strong><br>' . $productRecommendedList;

        // Create a personalized message
        $emailContent .= '<br><br>Dear '.$email.',<br><br>';
        $emailContent .= 'We are excited to provide you with personalized product recommendations based on the technologies and preferences you specified during the session you attended.';

        // Continue with the rest of your email content
        $emailContent .= '<br><br>Please find below the list of products that we think you might be interested in:';
        $emailContent .= '<br><br>' . $productRecommendedList;

        $mail = new PHPMailer(true);
        // SMTP settings (you may need to configure these)
        $mail->isSMTP();
        $mail->Host = 'mail.laundryandwash.com';
        $mail->SMTPSecure = 'tls'; // Use 'tls' for TLS encryption
        $mail->SMTPAuth = true;
        $mail->Username = 'event@laundryandwash.com';
        $mail->Password = 'GhZ%3SiW]x=Z';
        $mail->Port = 587; // Change to your SMTP port

        // Set the "From" address correctly
        $mail->setFrom('event@laundryandwash.com', 'Event Organizer');

        $mail->addAddress($email); // Recipient's email address
        $mail->isHTML(true);
        $mail->Subject = "Product Recommendation";

        // Embed the QR code image in the email body
        $mail->Body = $emailContent;

        // Send the email
        if ($mail->send()) {
            echo '<script type="text/javascript">
                swal({
                    title: "Success",
                    text: "Redirecting in 2 seconds.\nSuccessfully Answered survey",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = "./post-survey.php";
                });
            </script>';
        } else {
            echo "Email sending failed: " . $mail->ErrorInfo;
        }
    }
}

?>