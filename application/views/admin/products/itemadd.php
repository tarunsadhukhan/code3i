<!DOCTYPE html>
<html>
<head>
    <title>Employee Photo Capture</title>
    <script>
        // Function to capture a photo from the camera
        function capturePhoto() {
            const video = document.getElementById('webcam');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            
            // Ensure the video stream is loaded
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                // Set canvas dimensions to match the video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // Draw the current frame from the video onto the canvas
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Convert the canvas content to a data URL (JPEG image)
                const photoData = canvas.toDataURL('image/jpeg');

                // Display the captured photo
                const photo = document.getElementById('photo');
                photo.src = photoData;

                // You can send the `photoData` to your server to save it to the database
                // Use an XMLHttpRequest, Fetch API, or a form submission to send the data
            }
        }
    </script>
</head>
<body>
    <h1>Employee Photo Capture</h1>
    <video id="webcam" width="640" height="480" autoplay></video>
    <br>
    <button onclick="capturePhoto()">Capture Photo</button>
    <br>
    <canvas id="canvas" style="display: none;"></canvas>
    <img id="photo" alt="Captured Photo" style="display: none;">
    <br>
    <form action="save_employee.php" method="post" enctype="multipart/form-data">
        <label for="empcode">Employee Code:</label>
        <input type="text" name="empcode" id="empcode" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <!-- Input to send the captured photo data as base64 encoded JPEG -->
        <input type="hidden" name="photo_data" id="photo_data">
        <input type="submit" value="Save Employee">
    </form>
    <script>
        // Access the user's webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                const video = document.getElementById('webcam');
                video.srcObject = stream;
            })
            .catch(function(error) {
                console.error('Error accessing webcam:', error);
            });
    </script>
</body>
</html>
