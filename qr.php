<?php
    require_once 'phpqrcode\phpqrcode\qrlib.php';
?>
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

        <?php //include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php

                        // Text you want to encode as a QR code
$textToEncode = "Hello, World!";

// Create a function to display the QR code as an image
function displayQRCode($text) {
    // Generate the QR code as a string
    ob_start();
    QRcode::png($text, null, QR_ECLEVEL_L, 3);
    $imageData = ob_get_contents();
    ob_end_clean();

    // Set the appropriate HTTP headers
    header('Content-Type: image/png');
    header('Content-Length: ' . strlen($imageData));

    // Output the QR code image
    echo $imageData;
}

// Call the function to display the QR code
displayQRCode($textToEncode);
                        ?>
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
