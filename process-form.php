<?php
include 'connection.php';

if (isset($_POST['btnSubmit'])) {
    // Get selected technology and product choices from the form
    $event_id = $_POST['event_id'];
    // Create an array to store selected product and technology data
    $selected_data = [];
    $connection = openConnection();
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
    
    // Combine both datasets into an associative array
    $data_to_send = array(
        "dataset" => $dataset,
        "user_preferences" => array(
            "technology_line" => $selected_data_str , // Add the correct technology_line here
            "selected_data" => $selected_data_str 
        )
    );
    
    // Convert the array to JSON
    $data_json = json_encode($data_to_send);
    
    // Create a temporary JSON file and write the data to it
    $tempJsonFile = tempnam(sys_get_temp_dir(), 'event_data_');
    file_put_contents($tempJsonFile, $data_json);
    
    $pythonScript = 'new-recommendation.py';
    
    // Pass the temporary JSON file path as an argument
    $escapedJsonFilePath = escapeshellarg($tempJsonFile);
    $command = "python $pythonScript $escapedJsonFilePath";
    
    // Capture the output of the Python script
    $output = shell_exec($command);
    
    // You can also convert the JSON data to a PHP array or object and work with it as needed
    $dataFromPython = json_decode($output, true);
    
    // Clean up the temporary JSON file
    unlink($tempJsonFile);

    // Check if recommended_sessions exist in the response
    if (isset($dataFromPython['recommended_sessions'])) {
        $recommendedSessions = $dataFromPython['recommended_sessions'];

        // Display the recommended sessions
        foreach ($recommendedSessions as $session) {
            echo "Session ID: " . $session['session_id'] . "<br>";
            echo "Technology Line: " . $session['technology_line'] . "<br>";
            echo "Product ID: " . $session['product_id'] . "<br>";
            // Add more session details as needed
        }
    } else {
        echo "can't run python script";
    }
    
    // Rest of your HTML code
}
?>
