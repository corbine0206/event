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
if (isset($_POST['btnSubmit'])) {
    // Get selected technology and product choices from the form
    $email = $_GET['email'];

    // Create an array to store selected product and technology data
    $selected_data = [];

    $event_id = $_GET['eventID'];
    $datasetSql = "SELECT * FROM `product_technology_lines` as pt 
    join event_sessions as es on es.event_id = pt.event_id 
    join technologies as t on es.event_id = t.event_id 
    where pt.event_id = '$event_id'
    ";
    $dataset = getRecord($connection, $datasetSql);
    
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
    
    $user_preferences = array(
        "selected_data" => $selected_data_str
    );

    // Combine both datasets into an associative array
    $data_to_send = array(
        "dataset" => $dataset,
        "user_preferences" => $user_preferences
    );
    
    // Convert the array to JSON
    $data_json = json_encode($data_to_send);
    
    // Create a temporary JSON file and write the data to it
    $tempJsonFile = tempnam(sys_get_temp_dir(), 'event_data_');
    file_put_contents($tempJsonFile, $data_json);
    
    $pythonScript = 'new-recommendation.py';
    
    // Pass the temporary JSON file path as an argument
    $escapedJsonFilePath = escapeshellarg($tempJsonFile);
    $command = "$pythonScript $escapedJsonFilePath";
    $output = shell_exec($command);
    
    // Check if valid JSON data was returned
    $dataFromPython = json_decode($output, true);

    if ($dataFromPython !== null && is_array($dataFromPython) && isset($dataFromPython['recommended_sessions'])) {
        // Valid data received, proceed to display recommended sessions
        $recommendedSessions = $dataFromPython['recommended_sessions'];
        foreach ($recommendedSessions as $session) {
            // Display session details as needed
            echo "Session ID: " . $session['session_id'] . "<br>";
            echo "Technology Line: " . $session['technology_line'] . "<br>";
            echo "Product ID: " . $session['product_id'] . "<br>";
            // Add more session details as needed
        }
    } else {
        // Handle the case where valid data was not received
        echo "Error: Invalid or no data received from Python script.";
    }
    
    // Clean up the temporary JSON file
    unlink($tempJsonFile);
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
                            <form method="post" action="process-form.php">
                                <input type="text" value="<?php echo $_GET['eventID'] ?>" name="event_id"> <!-- Replace "process-form.php" with your PHP script's filename -->
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
                                <input type="submit" name="btnSubmit">
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

