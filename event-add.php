<?php
    session_start();
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
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
                            <form id="eventForm" method="POST" enctype="multipart/form-data" action="insert_event1.php">
                                <div class="form-group">
                                    <label for="eventTitle">Event Title:</label>
                                    <input type="text" id="eventTitle" name="eventTitle" class="form-control" required>
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="csvFile">Select a CSV file:</label>
                                    <input type="file" class="form-control-file" name="csvFile" id="csvFile" accept=".csv" required>
                                </div>
                                 <div id="sessionContainer">
                        <!-- Sessions will be added here -->
                                </div>
                                <!-- Add Session Button -->
                                <button type="button" class="btn btn-primary" id="addSessionBtn" onclick="addSession()">Add Session</button>

                                <!-- Submit Button -->
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
        // Define an object to keep track of technology line indices for each session and technology
        const techLineIndices = {};

        // Function to add a new session
        let sessionIndex = 0;

        // Function to add a new session
        function addSession() {
            const sessionContainer = document.getElementById("sessionContainer");

            // Create a new session div
            const sessionDiv = document.createElement("div");
            sessionDiv.className = "session";
            sessionDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label for="session-${sessionIndex}">Session:</label>
                        <input type="text" id="session-${sessionIndex}" class="form-control" name="session[]" required="true"> 
                    </div>
                    <div class="col-md-4">
                        <label for="schedule-${sessionIndex}">Schedule:</label>
                        <div class="input-group">
                            <input type="date" id="schedule-${sessionIndex}" class="form-control date-input" name="date[]" required>
                            <select class="form-control time-select" name="time[]" required>
                                <option value="06:00">06:00</option>
                                <option value="07:00">07:00</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                            </select>
                            <select class="form-control time-select" name="time2[]" required>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="techContainer-${sessionIndex}">
                        <button type="button"  class="btn btn-info" onclick="addTechnology(${sessionIndex})">Add Technology</button>
                    </div>
                </div>
            `;

            // Append the new session to the container
            sessionContainer.appendChild(sessionDiv);
            sessionIndex++;
        }

        // Function to remove a technology element within a session
        function removeTechnology(sessionIndex, techIndex) {
            const techContainer = document.getElementById(`techContainer-${sessionIndex}`);
            const techDivs = techContainer.querySelectorAll('.form-group');

            // Check if the techIndex is valid
            if (techIndex >= 0 && techIndex < techDivs.length) {
                const techToRemove = techDivs[techIndex];
                techToRemove.remove();
            }
        }

        // Function to remove a product and technology line within a technology element
        function removeProductAndLine(sessionIndex, techIndex, lineIndex) {
            // Use the data attributes to select the elements
            console.log(`${sessionIndex},${techIndex}, ${lineIndex}` );
            const productElements = document.querySelectorAll(`input[name="product[${sessionIndex}][${techIndex}][]"]
                                                                            [data-session-index="${sessionIndex}"]
                                                                            [data-tech-index="${techIndex}"]
                                                                            [data-line-index="${lineIndex}"]`);
            const techLineElements = document.querySelectorAll(`input[name="technologyLine[${sessionIndex}][${techIndex}][]"][data-session-index="${sessionIndex}"][data-tech-index="${techIndex}"][data-line-index="${lineIndex}"]`);

            productElements.forEach((productElement) => {
                if (productElement) {
                    productElement.parentElement.parentElement.remove();
                }
            });

            techLineElements.forEach((techLineElement) => {
                if (techLineElement) {
                    techLineElement.parentElement.parentElement.remove();
                }
            });

            // You can add any additional logic here as needed
        }



        // Function to initialize the technology line indices
        function initTechLineIndices(sessionId, techId) {
            if (!techLineIndices[sessionId]) {
                techLineIndices[sessionId] = {};
            }
            if (!techLineIndices[sessionId][techId]) {
                techLineIndices[sessionId][techId] = 0;
            }
        }
        // Function to add a new technology element within a session
        function addTechnology(sessionIndex) {
            const techContainer = document.getElementById(`techContainer-${sessionIndex}`);
            const techDiv = document.createElement("div");
            techDiv.className = "form-group";

            // Initialize the technology index for this session
            let techIndex = techContainer.querySelectorAll('.form-group').length;

            techDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label>Technology:</label>
                        <input type="text" class="form-control" name="technology[${sessionIndex}][]" required>
                    </div>
                    <div class="col-md-2">
                        <label>Product:</label>
                        <input type="text" class="form-control" name="product[${sessionIndex}][${techIndex}][]" required
                            data-session-index="${sessionIndex}" data-tech-index="${techIndex}" data-line-index="0">
                    </div>
                    <div class="col-md-2">
                        <label>Technology Line:</label>
                        <input type="text" class="form-control" name="technologyLine[${sessionIndex}][${techIndex}][]" required
                            data-session-index="${sessionIndex}" data-tech-index="${techIndex}" data-line-index="0">
                    </div>
                    <div class="col-md-8">
                        <button type="button" class="btn btn-primary" onclick="addProductAndLine(${sessionIndex}, ${techIndex})">Add Product and Technology Line</button>
                        <button type="button" class="btn btn-danger" data-remove-index="${techIndex}" onclick="removeTechnology(${sessionIndex}, ${techIndex})">Remove Technology</button>
                    </div>
                </div>
            `;

            // Append the new technology to the container
            techContainer.appendChild(techDiv);

            // Initialize the technology line indices
            initTechLineIndices(sessionIndex, techIndex);
        }

        // Function to add a product and technology line within a technology element
        function addProductAndLine(sessionIndex, techIndex) {
            const techContainer = document.getElementById(`techContainer-${sessionIndex}`);
            const techDiv = techContainer.querySelectorAll('.form-group')[techIndex];

            if (techDiv) {
                const lineIndex = techLineIndices[sessionIndex][techIndex] + 1;

                // Create a new row
                const rowDiv = document.createElement("div");
                rowDiv.className = "row"; // Create a new row to contain the elements

                // Create the col-md-4 for "Product"
                const productDiv = document.createElement("div");
                productDiv.className = "col-md-2";
                productDiv.innerHTML = `
                    <label>Product:</label>
                    <input type="text" class="form-control" name="product[${sessionIndex}][${techIndex}][]" required
                        data-session-index="${sessionIndex}" data-tech-index="${techIndex}" data-line-index="${lineIndex}">
                `;

                // Create the col-md-4 for "Technology Line"
                const techLineDiv = document.createElement("div");
                techLineDiv.className = "col-md-2";
                techLineDiv.innerHTML = `
                    <label>Technology Line:</label>
                    <input type="text" class="form-control" name="technologyLine[${sessionIndex}][${techIndex}][]" required
                        data-session-index="${sessionIndex}" data-tech-index="${techIndex}" data-line-index="${lineIndex}">
                `;

                // Create an empty col-md-4 to align with the layout
                const emptyDiv = document.createElement("div");
                emptyDiv.className = "col-md-4";

                // Create the col-md-4 for the "Remove" button
                const removeButtonDiv = document.createElement("div");
                removeButtonDiv.className = "col-md-4";
                removeButtonDiv.innerHTML = `
                    <button type="button" style="margin-top: 6%;" class="btn btn-danger" data-remove-index="${lineIndex}" onclick="removeProductAndLine(${sessionIndex}, ${techIndex}, ${lineIndex})">Remove Product and Technology Line</button>
                `;

                // Append the col-md-4 elements to the row
                rowDiv.appendChild(emptyDiv);
                rowDiv.appendChild(productDiv);
                rowDiv.appendChild(techLineDiv);
                rowDiv.appendChild(removeButtonDiv);

                // Append the new row containing product, technology line, and remove button to the techDiv
                techDiv.appendChild(rowDiv);

                // Increment the technology line index
                techLineIndices[sessionIndex][techIndex]++;
            }
        }
    </script>
