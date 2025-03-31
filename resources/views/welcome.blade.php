<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floral Photo Booth Deluxe</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }
        
        body {
            background-color: #fff5f5;
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 1;
            padding-bottom: 60px;
        }
        
        h1 {
            text-align: center;
            color: #e75480;
            margin-bottom: 30px;
            font-size: 2.8rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            font-family: 'Pacifico', cursive;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #e75480, #ffb6c1, #e75480);
            border-radius: 5px;
        }
        
        /* Photo Booth Styles */
        .photo-booth {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border: 3px solid #ffb6c1;
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
            border: 2px dashed #e75480;
        }
        
        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1); /* Mirror effect */
        }
        
        #canvas {
            display: none;
        }
        
        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 15px 25px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-capture {
            background-color: #e75480;
            color: white;
            font-size: 1.3rem;
            letter-spacing: 1px;
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
        
        .btn-reset {
            background-color: #f0ad4e;
            color: white;
        }
        
        .btn-reset:hover {
            background-color: #ec971f;
            transform: scale(1.05);
        }
        
        .strip-selection {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .strip-option {
            padding: 12px 25px;
            background-color: #f0f0f0;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            border: 2px solid transparent;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .strip-option:hover, .strip-option.active {
            background-color: #e75480;
            color: white;
            border-color: #d14a6e;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(231, 84, 128, 0.4);
        }
        
        .template-selection {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .template-option {
            padding: 10px;
            background-color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #ddd;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .template-option:hover, .template-option.active {
            border-color: #e75480;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(231, 84, 128, 0.2);
        }
        
        .template-preview {
            width: 80px;
            height: 40px;
            background-color: #f8f8f8;
            margin-bottom: 5px;
            display: flex;
            gap: 2px;
        }
        
        .template-preview div {
            flex-grow: 1;
            background-color: #e75480;
            opacity: 0.7;
        }
        
        .template-1 .template-preview div {
            height: 100%;
        }
        
        .template-2 .template-preview div {
            height: 100%;
            border-radius: 3px;
        }
        
        .template-3 .template-preview div {
            height: 100%;
            clip-path: polygon(0 0, 100% 0, 80% 100%, 20% 100%);
        }
        
        .template-4 .template-preview div {
            height: 100%;
            border-radius: 50%;
        }
        
        .template-name {
            font-size: 0.8rem;
            color: #666;
            font-weight: bold;
        }
        
        .photo-strip-container {
            display: none;
            margin-top: 30px;
            justify-content: center;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .photo-strip {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            display: flex;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }
        
        /* Different strip templates */
        .strip-template-1 {
            background: linear-gradient(135deg, #fff5f5, #ffffff);
            border: 3px solid #e75480;
        }
        
        .strip-template-1 .photo-frame {
            border: 5px solid white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .strip-template-2 {
            background: linear-gradient(135deg, #f8e1e7, #fadadd);
            border: 2px dashed #e75480;
        }
        
        .strip-template-2 .photo-frame {
            border: 8px solid white;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
        }
        
        .strip-template-3 {
            background: #fff;
            border: 1px solid #e75480;
        }
        
        .strip-template-3 .photo-frame {
            border: 3px solid #e75480;
            clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%);
        }
        
        .strip-template-4 {
            background: #f9f9f9;
            border: 2px solid #e75480;
        }
        
        .strip-template-4 .photo-frame {
            border-radius: 10px;
            overflow: hidden;
            border: 5px double #e75480;
        }
        
        .photo-frame {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .photo-frame img {
            display: block;
            height: 200px;
            width: auto;
            transition: all 0.3s ease;
        }
        
        .photo-frame:hover {
            transform: scale(1.03);
            z-index: 2;
        }
        
        .photo-frame:hover img {
            transform: scale(1.05);
        }
        
        .photo-frame::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(231,84,128,0.1));
            pointer-events: none;
        }
        
        /* Capture animation */
        .flash {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            opacity: 0;
            pointer-events: none;
            z-index: 10;
        }
        
        .flash-animate {
            animation: flash 0.5s ease-out;
        }
        
        @keyframes flash {
            0% { opacity: 0; }
            20% { opacity: 1; }
            100% { opacity: 0; }
        }
        
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #e75480;
            opacity: 0;
            z-index: 11;
        }
        
        /* Animated Flowers */
        .flower {
            position: absolute;
            z-index: 0;
            animation: float 6s infinite ease-in-out;
            opacity: 0.7;
            pointer-events: none;
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
            filter: hue-rotate(0deg);
        }
        
        .flower-2 {
            top: 70%;
            left: 15%;
            width: 60px;
            animation-delay: 1s;
            filter: hue-rotate(90deg);
        }
        
        .flower-3 {
            top: 30%;
            right: 10%;
            width: 70px;
            animation-delay: 2s;
            filter: hue-rotate(180deg);
        }
        
        .flower-4 {
            bottom: 10%;
            right: 5%;
            width: 90px;
            animation-delay: 3s;
            filter: hue-rotate(270deg);
        }
        
        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            color: #e75480;
            font-size: 0.9rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            border-top: 1px solid #ffb6c1;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            
            .camera-container {
                height: 300px;
            }
            
            .strip-selection, .template-selection {
                gap: 10px;
            }
            
            .strip-option {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .photo-strip {
                flex-direction: column;
            }
            
            .photo-frame img {
                width: 100%;
                height: auto;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
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
                <div class="flash" id="flash"></div>
                <div id="confetti-container"></div>
            </div>
            
            <div class="strip-selection">
                <div class="strip-option active" data-strips="1">1 Photo</div>
                <div class="strip-option" data-strips="2">2 Photos</div>
                <div class="strip-option" data-strips="3">3 Photos</div>
                <div class="strip-option" data-strips="4">4 Photos</div>
            </div>
            
            <div class="template-selection">
                <div class="template-option template-1 active" data-template="1">
                    <div class="template-preview">
                        <div></div>
                    </div>
                    <span class="template-name">Classic</span>
                </div>
                <div class="template-option template-2" data-template="2">
                    <div class="template-preview">
                        <div></div>
                        <div></div>
                    </div>
                    <span class="template-name">Vintage</span>
                </div>
                <div class="template-option template-3" data-template="3">
                    <div class="template-preview">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <span class="template-name">Modern</span>
                </div>
                <div class="template-option template-4" data-template="4">
                    <div class="template-preview">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <span class="template-name">Fun</span>
                </div>
            </div>
            
            <div class="controls">
                <button class="btn btn-capture" id="capture">📸 Take Photo</button>
                <div style="display: flex; gap: 10px;">
                    <button class="btn btn-download" id="download" disabled>💾 Download All</button>
                    <button class="btn btn-reset" id="reset">🔄 Start Over</button>
                </div>
            </div>
            
            <div class="photo-strip-container" id="photo-strip-container">
                <div class="photo-strip strip-template-1" id="photo-strip"></div>
            </div>
        </div>
    </div>
    
    <footer>
        ✨ Floral Photo Booth - Capture Your Special Moments ✨
    </footer>
    
    <script>
        // Camera access
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture');
        const downloadBtn = document.getElementById('download');
        const resetBtn = document.getElementById('reset');
        const photoStrip = document.getElementById('photo-strip');
        const photoStripContainer = document.getElementById('photo-strip-container');
        const stripOptions = document.querySelectorAll('.strip-option');
        const templateOptions = document.querySelectorAll('.template-option');
        const flash = document.getElementById('flash');
        const confettiContainer = document.getElementById('confetti-container');
        
        let selectedStrips = 1;
        let selectedTemplate = 1;
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
        
        // Capture photo with animation
        captureBtn.addEventListener('click', function() {
            if (photosTaken >= selectedStrips) {
                alert(`You've already taken ${selectedStrips} photos. Please download or reset.`);
                return;
            }
            
            // Flash animation
            flash.classList.add('flash-animate');
            setTimeout(() => {
                flash.classList.remove('flash-animate');
            }, 500);
            
            // Create confetti
            createConfetti();
            
            // Delay capture slightly for better UX
            setTimeout(() => {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                const dataUrl = canvas.toDataURL('image/png');
                photoDataUrls.push(dataUrl);
                
                const frame = document.createElement('div');
                frame.className = 'photo-frame';
                
                const img = document.createElement('img');
                img.src = dataUrl;
                frame.appendChild(img);
                
                photoStrip.appendChild(frame);
                
                photosTaken++;
                
                if (photosTaken === selectedStrips) {
                    photoStripContainer.style.display = 'flex';
                    downloadBtn.disabled = false;
                    captureBtn.disabled = true;
                }
            }, 200);
        });
        
        // Create confetti effect
        function createConfetti() {
            // Clear previous confetti
            confettiContainer.innerHTML = '';
            
            // Create new confetti
            for (let i = 0; i < 30; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                
                // Random color
                const colors = ['#e75480', '#ffb6c1', '#ff69b4', '#ff1493', '#db7093'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.backgroundColor = randomColor;
                
                // Random position
                const startX = Math.random() * 100;
                const startY = Math.random() * 100;
                confetti.style.left = `${startX}%`;
                confetti.style.top = `${startY}%`;
                
                // Random shape
                const shapes = ['circle', 'square', 'triangle'];
                const randomShape = shapes[Math.floor(Math.random() * shapes.length)];
                
                if (randomShape === 'circle') {
                    confetti.style.borderRadius = '50%';
                } else if (randomShape === 'triangle') {
                    confetti.style.clipPath = 'polygon(50% 0%, 0% 100%, 100% 100%)';
                }
                
                // Random size
                const size = Math.random() * 10 + 5;
                confetti.style.width = `${size}px`;
                confetti.style.height = `${size}px`;
                
                confettiContainer.appendChild(confetti);
                
                // Animate
                animateConfetti(confetti);
            }
        }
        
        function animateConfetti(confetti) {
            const startX = parseFloat(confetti.style.left);
            const startY = parseFloat(confetti.style.top);
            
            // Random animation
            const animation = confetti.animate([
                { 
                    opacity: 1,
                    transform: 'translate(0, 0) rotate(0deg)',
                },
                { 
                    opacity: 0,
                    transform: `translate(${Math.random() * 200 - 100}px, ${Math.random() * 200 + 100}px) rotate(${Math.random() * 360}deg)`,
                }
            ], {
                duration: 1000 + Math.random() * 1000,
                easing: 'cubic-bezier(0.1, 0.8, 0.9, 1)',
            });
            
            animation.onfinish = () => {
                confetti.remove();
            };
        }
        
        // Download photos
        downloadBtn.addEventListener('click', function() {
            photoDataUrls.forEach((dataUrl, index) => {
                const link = document.createElement('a');
                link.download = `floral-photo-${index + 1}.png`;
                link.href = dataUrl;
                link.click();
            });
        });
        
        // Reset photo booth
        resetBtn.addEventListener('click', resetPhotoBooth);
        
        function resetPhotoBooth() {
            photosTaken = 0;
            photoDataUrls = [];
            photoStrip.innerHTML = '';
            photoStripContainer.style.display = 'none';
            downloadBtn.disabled = true;
            captureBtn.disabled = false;
        }
        
        // Strip selection
        stripOptions.forEach(option => {
            option.addEventListener('click', function() {
                stripOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                selectedStrips = parseInt(this.getAttribute('data-strips'));
                resetPhotoBooth();
            });
        });
        
        // Template selection
        templateOptions.forEach(option => {
            option.addEventListener('click', function() {
                templateOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                selectedTemplate = parseInt(this.getAttribute('data-template'));
                
                // Update photo strip template
                photoStrip.className = 'photo-strip';
                photoStrip.classList.add(`strip-template-${selectedTemplate}`);
                
                // If we have photos, show them in the new template
                if (photosTaken > 0) {
                    photoStripContainer.style.display = 'flex';
                }
            });
        });
    </script>
</body>
</html>