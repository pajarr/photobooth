<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floral Photo Booth</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #fff5f5;
            overflow-x: hidden;
            position: relative;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        h1 {
            text-align: center;
            color: #e75480;
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Photo Booth Styles */
        .photo-booth {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .camera-container {
            position: relative;
            width: 100%;
            height: 400px;
            background-color: #f8f8f8;
            border-radius: 10px;
            margin-bottom: 20px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        #canvas {
            display: none;
        }
        
        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
        }
        
        .btn-capture {
            background-color: #e75480;
            color: white;
        }
        
        .btn-capture:hover {
            background-color: #d14a6e;
            transform: scale(1.05);
        }
        
        .btn-download {
            background-color: #5cb85c;
            color: white;
        }
        
        .btn-download:hover {
            background-color: #4cae4c;
            transform: scale(1.05);
        }
        
        .strip-selection {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .strip-option {
            padding: 10px 20px;
            background-color: #f0f0f0;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .strip-option:hover, .strip-option.active {
            background-color: #e75480;
            color: white;
        }
        
        .photo-strip-container {
            display: none;
            margin-top: 30px;
            justify-content: center;
        }
        
        .photo-strip {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 10px;
        }
        
        .photo-strip img {
            height: 150px;
            width: auto;
            border-radius: 3px;
        }
        
        /* Animated Flowers */
        .flower {
            position: absolute;
            z-index: 0;
            animation: float 6s infinite ease-in-out;
            opacity: 0.7;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }
        
        .flower-1 {
            top: 10%;
            left: 5%;
            width: 80px;
            animation-delay: 0s;
        }
        
        .flower-2 {
            top: 70%;
            left: 15%;
            width: 60px;
            animation-delay: 1s;
        }
        
        .flower-3 {
            top: 30%;
            right: 10%;
            width: 70px;
            animation-delay: 2s;
        }
        
        .flower-4 {
            bottom: 10%;
            right: 5%;
            width: 90px;
            animation-delay: 3s;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .camera-container {
                height: 300px;
            }
            
            .strip-selection {
                flex-direction: column;
                align-items: center;
            }
            
            .photo-strip {
                flex-direction: column;
            }
            
            .photo-strip img {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Flowers -->
    <img src="https://cdn.pixabay.com/photo/2017/01/10/03/06/flower-1968358_960_720.png" class="flower flower-1">
    <img src="https://cdn.pixabay.com/photo/2017/01/10/03/06/flower-1968358_960_720.png" class="flower flower-2">
    <img src="https://cdn.pixabay.com/photo/2017/01/10/03/06/flower-1968358_960_720.png" class="flower flower-3">
    <img src="https://cdn.pixabay.com/photo/2017/01/10/03/06/flower-1968358_960_720.png" class="flower flower-4">
    
    <div class="container">
        <h1>Floral Photo Booth</h1>
        
        <div class="photo-booth">
            <div class="camera-container">
                <video id="video" autoplay></video>
                <canvas id="canvas"></canvas>
            </div>
            
            <div class="strip-selection">
                <div class="strip-option active" data-strips="1">1 Strip</div>
                <div class="strip-option" data-strips="2">2 Strips</div>
                <div class="strip-option" data-strips="3">3 Strips</div>
            </div>
            
            <div class="controls">
                <button class="btn btn-capture" id="capture">Take Photo</button>
                <button class="btn btn-download" id="download" disabled>Download All</button>
            </div>
            
            <div class="photo-strip-container" id="photo-strip-container">
                <div class="photo-strip" id="photo-strip"></div>
            </div>
        </div>
    </div>
    
    <script>
        // Camera access
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture');
        const downloadBtn = document.getElementById('download');
        const photoStrip = document.getElementById('photo-strip');
        const photoStripContainer = document.getElementById('photo-strip-container');
        const stripOptions = document.querySelectorAll('.strip-option');
        
        let selectedStrips = 1;
        let photosTaken = 0;
        let photoDataUrls = [];
        
        // Set up camera
        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function(err) {
                console.log("An error occurred: " + err);
                alert("Could not access the camera. Please make sure you've granted camera permissions.");
            });
        
        // Capture photo
        captureBtn.addEventListener('click', function() {
            if (photosTaken >= selectedStrips) {
                alert(`You've already taken ${selectedStrips} photos. Please download or change the strip selection.`);
                return;
            }
            
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const dataUrl = canvas.toDataURL('image/png');
            photoDataUrls.push(dataUrl);
            
            const img = document.createElement('img');
            img.src = dataUrl;
            photoStrip.appendChild(img);
            
            photosTaken++;
            
            if (photosTaken === selectedStrips) {
                photoStripContainer.style.display = 'flex';
                downloadBtn.disabled = false;
                captureBtn.disabled = true;
            }
        });
        
        // Download photos
        downloadBtn.addEventListener('click', function() {
            photoDataUrls.forEach((dataUrl, index) => {
                const link = document.createElement('a');
                link.download = `photo-strip-${index + 1}.png`;
                link.href = dataUrl;
                link.click();
            });
        });
        
        // Strip selection
        stripOptions.forEach(option => {
            option.addEventListener('click', function() {
                stripOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                selectedStrips = parseInt(this.getAttribute('data-strips'));
                resetPhotoBooth();
            });
        });
        
        // Reset photo booth
        function resetPhotoBooth() {
            photosTaken = 0;
            photoDataUrls = [];
            photoStrip.innerHTML = '';
            photoStripContainer.style.display = 'none';
            downloadBtn.disabled = true;
            captureBtn.disabled = false;
        }
    </script>
</body>
</html>