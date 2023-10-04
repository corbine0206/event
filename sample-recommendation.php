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
    // Establish a database connection if needed
    $connection = openConnection();

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

    // Process the output or print it for debugging

    if ($returnCode === 0) {
        // The Python script executed successfully
        foreach ($output as $line) {
            // Parse the JSON data sent by the Python script
            $json_data = json_decode($line, true);
    
            if ($json_data) {
                foreach ($json_data as $result) {
                    if (isset($result['Session ID'])) {
                        $session_title = $result['Session ID'];
                        echo "Session Title: $session_title<br>";
                    } else {
                        echo 'Session Title not found in JSON data<br>';
                    }
                }
            } else {
                echo 'Invalid JSON data received from Python<br>';
            }
            
        }
    } else {
        // There was an error executing the Python script
        echo "Error executing Python script. Return code: $returnCode";
    }
    
    

    // Enable PHP error reporting for debugging
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
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
                                <input type="text" value="<?php echo $_GET['eventID'] ?>" name="event_id"> <!-- Replace "process-form.php" with your PHP script's filename -->
                                <input type="text" value="<?php echo $_GET['email'] ?>" name="email">
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
