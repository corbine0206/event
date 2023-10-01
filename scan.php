<?php
    session_start();
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
    require_once 'lib/QrReader.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Event</title>
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


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
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-calendar"></i>Event</h6>
                        </div>
                        <div class="card-body">
                            <h1>QR Code Scanner</h1>
                            <video id="qr-video" width="400" height="300" autoplay playsinline></video>
                            <div id="qr-result"></div>
                            <script src="scanner.js"></script>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
<script>
    const video = document.getElementById('qr-video');
    const qrResult = document.getElementById('qr-result');

    const scanner = new Instascan.Scanner({ video: video });
    scanner.addListener('scan', function (content) {
        qrResult.innerText = content;

        // Send scanned data to PHP for processing
        fetch('process_qr.php', {
            method: 'POST',
            body: JSON.stringify({ data: content }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.text())
        .then(responseText => {
            console.log('Response from PHP:', responseText);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function (err) {
        console.error('Error accessing the camera:', err);
    });

</script>

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

