<?php
    session_start();
    include 'connection.php';
    include 'phpqrcode\phpqrcode\qrlib.php';
    require 'vendor/autoload.php'; // Include Composer's autoloader

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $event_id = isset($_GET['eventID']) ? $_GET['eventID'] : null;
    $email = isset($_GET['email']) ? $_GET['email'] : null;
    
    try {
        if ($event_id !== null && $email !== null) {
            $connection = openConnection();
            $strSql = "SELECT * FROM participants where event_id = '$event_id' and email = '$email'";
            $result = mysqli_query($connection, $strSql);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $reqPersons = mysqli_fetch_array($result);
                    mysqli_free_result($result);
                }
                else{
                    $message = "NO USER FOUND";
                }
            }

           
        } else {
            $message = "";
            throw new Exception('');
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        $message = "";
    }
?>

<?php
if (isset($_POST['btnSubmit'])) {
    // Establish a database connection if needed
    $connection = openConnection();

    $email = $_GET['email'];
    $event_id = $_GET['eventID'];
    $updateParticipantSql = "UPDATE participants set status = 1 where event_id = '$event_id' and email = '$email'";
    if (mysqli_query($connection, $updateParticipantSql)) {
        echo 'Successfully update participants';
    }
    $updateEventSql = "UPDATE events set event_status = 2 where event_id = '$event_id'";
    if (mysqli_query($connection, $updateEventSql)) {
        echo "successfully event updated to 2";
    }
    if (isset($_POST["technology"])) {
        $selectedTechnologies = $_POST["technology"];

        foreach ($selectedTechnologies as $selectedTechId) {
            $selectedDropdownValue = $_POST["dropdown_" . $selectedTechId];
            $dataExplode = explode("-", $selectedDropdownValue);
            $response = $dataExplode[0];
            $product_id = $dataExplode[1];
            $technology_id = $dataExplode[2];
            $session_id = $dataExplode[3];
            // Insert the selected technology_id and dropdown value into your database
             $insertSql = "INSERT INTO response (event_id, email, product_id, technology_id, session_id, response) VALUES ('$event_id','$email', '$product_id', '$technology_id', '$session_id', '$response')";

             if (mysqli_query($connection, $insertSql)) {
                 echo 'Data inserted successfully for technology ID ' . $selectedTechId . '<br>';
             } else {
                 echo 'Error inserting data for technology ID ' . $selectedTechId . ': ' . mysqli_error($con) . '<br>';
             }
        }
    }
    // Retrieve the dataset
    $datasetSql = "SELECT technology_line, es.session_title ,pt.session_id, t.technology_name, es.date1, es.time1, es.time2
    FROM product_technology_lines as pt 
    join technologies as t on pt.technology_id = t.technology_id 
    join event_sessions as es on es.session_id = pt.session_id where pt.event_id = '$event_id'";
    
    // Execute the SQL query and fetch the data
    $result = mysqli_query($connection, $datasetSql);
    
    // Initialize an array to store dataset entries
    $dataset = array();

    // Fetch rows and add them to the dataset array
    while ($row = mysqli_fetch_assoc($result)) {
        $dataset[] = $row;
    }

    // Get selected technologies from the form
    $selected_technologies = $_POST["technology"];
    $selected_data = [];
    // Iterate through selected technologies
    foreach ($selected_technologies as $tech_id) {
        // Check if a dropdown menu associated with this technology is set
        $dropdown_key = "dropdown_" . $tech_id;
        if (isset($_POST[$dropdown_key])) {
            // Add selected product and technology data to the array
            $selectedDropdownValue = $_POST[$dropdown_key];
            $dataExplode = explode("-", $selectedDropdownValue);
            $response = $dataExplode[0];
            $selected_data[] = $response;
        }
    }
    // Combine the data into an associative array
    $dataToPass = array(
        "user_preferences" => $selected_data,
        "dataset" => $dataset
    );

    // Encode the data as JSON
    $jsonData = json_encode($dataToPass);
    // Create a temporary file to store the JSON data
    $tempFile = tempnam(sys_get_temp_dir(), 'json_data');
    file_put_contents($tempFile, $jsonData);

    // Use escapeshellarg to properly escape the file path for the command line
    $fileArg = escapeshellarg($tempFile);

    // Call your Python script with the file path as an argument
    $command = "python new-recommendation.py $fileArg";
    exec($command, $output, $returnCode);

    // Remove the temporary file
    unlink($tempFile);

    $outputFileName = "$email.png";
    $textToEncode = $email;
    // Generate the QR code
    QRcode::png($textToEncode, $outputFileName, QR_ECLEVEL_L, 3);
    if ($returnCode === 0) {
        // The Python script executed successfully
        $emailContent = '<h1>Session Information:</h1><br>'; // Initialize email content
        $printed_session_ids = [];
        $reserved_time1 = [];
        $reserved_time2 = [];
    
        foreach ($output as $line) {
            // Parse the JSON data sent by the Python script
            $json_data = json_decode($line, true);
    
            if ($json_data) {
                foreach ($json_data as $result) {
                    $session_id = $result['Session ID'];
                    $date1 = $result['Date1'];
                    $time1 = $result['Time1'];
                    $time2 = $result['Time2'];
    
                    // Create a unique identifier for the time slot based on Date1 and the time
                    $time_slot_identifier = "$date1-$time1";
    
                    // Check if the current session_id is different from the previous one
                    if (!in_array($session_id, $printed_session_ids)) {
                        // Check if Time1 is available and Date1/Time1 doesn't conflict with previous recommendations
                        if (!empty($time1) && !in_array($time_slot_identifier, $reserved_time1)) {
                            // Add session information to the email content with Time1
                            $emailContent .= "<p>Session Title: " . $result['Session Title'] . "</p>";
                            $emailContent .= "<p>Date: $date1</p>";
                            $emailContent .= "<p>Time Morning: $time1</p>";
                            $emailContent .= "<hr>";
                            // Reserve Time1
                            $reserved_time1[] = $time_slot_identifier;
                        } elseif (!empty($time2) && !in_array($time_slot_identifier, $reserved_time2)) {
                            // Add session information to the email content with Time2
                            $emailContent .= "<p>Session Title: " . $result['Session Title'] . "</p>";
                            $emailContent .= "<p>Date: $date1</p>";
                            $emailContent .= "<p>Time Afternoon: $time2</p>";
                            $emailContent .= "<hr>";
                            // Reserve Time2
                            $reserved_time2[] = $time_slot_identifier;
                        }
                        // Add the current session_id to the printed_session_ids array
                        $printed_session_ids[] = $session_id;
                    }
                }
            } else {
                echo 'Invalid JSON data received from Python<br>';
            }
        }
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
        $mail->Subject = "SESSION RECOMMENDED";
    
        // Add the QR code image as an attachment
        $mail->addAttachment($outputFileName);
    
        // Embed the QR code image in the email body
        $emailContent .= '<br><img src="cid:' . $outputFileName . '>';
        $mail->Body = $emailContent;
    
        // Send the email
        if ($mail->send()) {
            echo "Email sent successfully.";
        } else {
            echo "Email sending failed: " . $mail->ErrorInfo;
        }
    } else {
        // There was an error executing the Python script
        echo "Error executing Python script. Return code: $returnCode";
    }
    header("Refresh:0");    
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>

    /* Style for the dropdown menus */
    .tech-dropdown {
        display: none;
    }
    .sticky-footer {
        position: fixed;
        text-align: center;
        bottom: 0;
        width: 100%;
        background-color: #ffffff; /* You can change the background color as needed */
        border-top: 1px solid #e0e0e0; /* Optional: Add a border at the top of the footer */
        padding: 10px 0; /* Optional: Add padding to the footer content */
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow at the bottom */
    }
    .larger-card {
    padding: 20px;
    margin: 0 auto;
    }
    .larger-text {
        font-size: 40px;
        font-family: sans-serif;
        white-space: nowrap;
    }
    .larger-checkbox {
        width: 1.5em;
        height: 1.5em;
        margin-right: 10px;
        vertical-align: middle; /* Align the checkbox vertically in the middle of the text */
    }
    .larger-dropdown {
        font-size: 30px;
        font-family: sans-serif;
        white-space: nowrap;
    }
    
</style>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php //include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column body">

            <div id="content" class="container">
                <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
                    <div class="larger-card card">
                        <div class="card-body larger-card text-center">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            } else {
                                if ($reqPersons['status'] == 1) {
                                    echo "You already answered the form";
                                } elseif (isset($message)) {
                                    echo "No email and event ID found";
                                } else {
                            ?>
                            <form method="post">
                                <input type="hidden" value="<?php echo $_GET['eventID'] ?>" name="event_id">
                                <input type="hidden" value="<?php echo $_GET['email'] ?>" name="email">
                                <div class="form-group">
                                    <?php
                                    $con = openConnection();
                                    $strSql = "SELECT * FROM technologies where event_id = '$event_id'";
                                    $result = getRecord($con, $strSql);
                                    foreach ($result as $key => $value) {
                                        echo '
                                            <label for="technology[]" class="form-check larger-text label-with-padding" style="margin-top: 20%;">
                                                <input type="checkbox" class="form-check-input larger-checkbox" name="technology[]" id="technology[]" value="' . $value['technology_id'] . '"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . $value['technology_name'] . '
                                            </label>
                                        ';
                                        // Query the product_technology_lines table for data related to the current technology_id
                                        $techId = $value['technology_id'];
                                        $dropdownSql = "SELECT * FROM product_technology_lines WHERE technology_id = '$techId'";
                                        $dropdownResult = getRecord($con, $dropdownSql);
                                        // Create the dropdown menu
                                        echo '<select class="tech-dropdown form-control larger-dropdown" name="dropdown_' . $techId . '">';
                                        echo '<option value="">Select a line</option>';
                                        foreach ($dropdownResult as $dropdownKey => $dropdownValue) {
                                            echo '<option value="' . $dropdownValue['technology_line'] . '-' . $dropdownValue['product_id'] . '-' . $dropdownValue['technology_id'] . '-' . $dropdownValue['session_id'] . '">' . $dropdownValue['technology_line'] . '</option>';
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg" name="btnSubmit">Submit</button>
                            </form>
                        </div>
                    </div>
                <?php } } ?>
            </div>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include 'script.php'; ?>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var maxChecked = 3; // Set the maximum number of checkboxes allowed
            
            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    var checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                    
                    if (checkedCheckboxes.length >= maxChecked) {
                        checkboxes.forEach(function (cb) {
                            if (!cb.checked) {
                                cb.disabled = true;
                            }
                        });
                    } else {
                        checkboxes.forEach(function (cb) {
                            cb.disabled = false;
                        });
                    }
                    
                    var dropdown = document.querySelector('select[name="dropdown_' + this.value + '"]');
                    
                    if (this.checked) {
                        dropdown.style.display = "block";
                    } else {
                        dropdown.style.display = "none";
                    }
                });
            });
        });
    </script>
