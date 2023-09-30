<?php
    session_start();
    include 'connection.php';
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
            }
           
        } else {
            throw new Exception('No event ID or email');
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    ?>
<?php
// Previous PHP code for form processing and data retrieval

if (isset($_POST['btnSubmit'])) {
    // Get selected technology and product choices from the form
    $email = $_GET['email'];

    // Create an array to store selected product and technology data
    $selected_data = [];

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
    // Get selected technologies from the form
    $selected_technologies = $_POST["technology"];

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

    // Prepare the selected data as a comma-separated string
    $selected_data_str = implode(",", $selected_data);

    // Run the Python script with the selected data as arguments
    $output = shell_exec("recommendation.py \"$selected_data_str\"");
    $recommended_sessions = json_decode($output, true);

    if ($recommended_sessions) {
        $updateSql = "UPDATE events SET event_status = 2 WHERE event_id = '$event_id'";
        mysqli_query($connection, $updateSql);
        $userUpdate = "UPDATE participants SET status = 1 WHERE event_id = '$event_id' AND email = '$email'";
        mysqli_query($connection, $userUpdate);

        // Build and send an email with recommended sessions
        $email_subject = "Recommended Sessions";
        $email_message = "<html><body>";
        $email_message .= "<h2>Recommended Sessions</h2>";
        $email_message .= "<ul>";

        $uniqueSessionIds = [];

        foreach ($recommended_sessions as $session) {
            $sessionId = $session[0];

            if (!in_array($sessionId, $uniqueSessionIds)) {
                echo $email_message .= "<li>Session Name: " . $session[4] . "</li>";
                $email_message .= "<li>Date: " . $session[1] . "</li>";
                $email_message .= "<li>Time: " . $session[2] . "</li>";
                $email_message .= "<li>Technology: " . $session[6] . "</li>";

                // Add the session ID to the uniqueSessionIds array
                $uniqueSessionIds[] = $sessionId;
            }
        }

        $email_message .= "</ul>";
        $email_message .= "</body></html>";

        // Set recipient email address
        $to = $email; // Replace with the recipient's email address

        // Set email headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: your_email@gmail.com' . "\r\n"; // Replace with your email address

        // Send the email
        mail($to, $email_subject, $email_message, $headers);
    } else {
        echo "No recommended sessions.";
    }
    
    // Add any additional code or redirects as needed after processing
}
?>



<style>
        /* Center the container */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Style for the dropdown menus */
        .tech-dropdown {
            display: none;
        }

        /* Style for labels */
        label {
            display: block;
            margin-bottom: 10px;
        }

        /* Style for the content container */
        #content {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f7f7f7;
            border-radius: 5px;
        }
    </style>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php //include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php
                        if ($reqPersons['status'] == 1) {
                            echo "You already answered the form";
                        }
                        else{ ?>
                            <form method="post">
                                <?php
                                $con = openConnection();
                                $strSql = "SELECT * FROM technologies where event_id = '$event_id'";
                                $result = getRecord($con, $strSql);

                                foreach ($result as $key => $value) {
                                    echo '<label>';
                                    echo '<input type="checkbox" name="technology[]" value="' . $value['technology_id'] . '"> ' . $value['technology_name'];
                                    echo '</label>';

                                    // Query the product_technology_lines table for data related to the current technology_id
                                    $techId = $value['technology_id'];
                                    $dropdownSql = "SELECT * FROM product_technology_lines WHERE technology_id = '$techId'";
                                    $dropdownResult = getRecord($con, $dropdownSql);

                                    // Create the dropdown menu
                                    echo '<select class="tech-dropdown" name="dropdown_' . $techId . '">';
                                    echo '<option value="">Select a line</option>'; // Optional initial option
                                    foreach ($dropdownResult as $dropdownKey => $dropdownValue) {
                                        echo '<option value="' . $dropdownValue['technology_line'] . '-'.$dropdownValue['product_id'].'-'.$dropdownValue['technology_id'].'-'.$dropdownValue['session_id'].'">' . $dropdownValue['technology_line'] . '</option>';
                                    }
                                    echo '</select><br>';
                                }
                                ?>
                                <input type="submit" name="btnSubmit" value="Submit">
                            </form>
                       <?php }
                    ?>
                
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

