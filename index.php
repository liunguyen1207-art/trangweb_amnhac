<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Tải Video Lên</title>
  <style>
    html, body {
      margin: 0; padding: 0;
      height: 100%;
      background: #0d0d0d;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
      color: white;
      user-select: none;
    }

    .banner {
      position: relative;
      width: 100vw;
      height: 100vh;
      background: radial-gradient(circle at center, #1a1a2e 0%, #0f0f1c 70%, #000000 100%);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }

    .banner h1 {
      font-size: 4rem;
      margin-bottom: 15px;
      color: #a0cfff;
      text-shadow: 0 0 25px rgba(160, 207, 255, 0.8);
      z-index: 10;
    }

    .banner p {
      font-size: 1.5rem;
      margin-bottom: 30px;
      color: #cccccc;
      z-index: 10;
    }

    .btn-rounded {
      background: linear-gradient(90deg, #00c6ff, #0072ff);
      color: white;
      padding: 14px 36px;
      border-radius: 50px;
      font-size: 1.2rem;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 6px 20px rgba(0, 114, 255, 0.7);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      z-index: 10;
      user-select: none;
      margin-bottom: 40px;
      display: inline-block;
    }

    .btn-rounded:hover {
      transform: scale(1.1);
      box-shadow: 0 10px 30px rgba(0, 114, 255, 1);
    }

    .stars {
      position: absolute;
      inset: 0;
      overflow: visible;
      pointer-events: none;
      z-index: 1;
    }

    .star {
      position: absolute;
      background: white;
      border-radius: 50%;
      opacity: 0.9;
      will-change: transform;
      box-shadow:
        0 0 10px 3px rgba(255, 255, 255, 0.85),
        0 0 15px 6px rgba(160, 207, 255, 0.9);
      animation: twinkle 5s infinite ease-in-out;
      cursor: default;
    }

    @keyframes twinkle {
      0%, 100% {opacity: 0.7;}
      50% {opacity: 1;}
    }

    /* Form upload */
    .upload-container {
      background: rgba(10, 20, 40, 0.85);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(0, 114, 255, 0.6);
      max-width: 400px;
      width: 100%;
      z-index: 10;
      color: #cce3ff;
    }

    .upload-container h2 {
      margin-bottom: 25px;
      font-weight: 600;
      font-size: 2rem;
      color: #a0cfff;
    }

    input[type="file"] {
      margin-bottom: 25px;
      padding: 8px;
      width: 100%;
      border-radius: 6px;
      border: none;
      font-size: 1rem;
      cursor: pointer;
      background: #14253d;
      color: white;
    }

    input[type="submit"] {
      background-color: #2193b0;
      color: white;
      border: none;
      padding: 14px 20px;
      cursor: pointer;
      font-size: 1.1rem;
      border-radius: 50px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      width: 100%;
    }

    input[type="submit"]:hover {
      background-color: #186a83;
    }
  </style>
</head>
<body>

  <div class="banner" id="banner">
    <div class="stars" id="stars"></div>

    <h1>📤 Tải Video Lên</h1>
    <p>Chọn và tải video từ thiết bị của bạn</p>
    <a href="videos.php" class="btn-rounded">📂 Xem Video Đã Tải</a>

    <div class="upload-container">
      <h2>Chọn Video để Tải Lên:</h2>
      <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="videoFile" id="videoFile" accept="video/*" required><br />
        <input type="submit" value="Tải Lên" name="submit" />
      </form>
    </div>
  </div>

  <script>
    const starsContainer = document.getElementById('stars');
    const banner = document.getElementById('banner');
    const numStars = 70;

    const starsData = [];

    function randomRange(min, max) {
      return Math.random() * (max - min) + min;
    }

    for (let i = 0; i < numStars; i++) {
      const star = document.createElement('div');
      star.classList.add('star');

      const size = randomRange(2.5, 6);
      star.style.width = `${size}px`;
      star.style.height = `${size}px`;

      const x = randomRange(0, 100);
      const y = randomRange(0, 100);

      star.style.left = `${x}%`;
      star.style.top = `${y}%`;

      star.style.animationDelay = `${randomRange(0, 5)}s`;

      starsContainer.appendChild(star);

      starsData.push({
        element: star,
        baseXPercent: x,
        baseYPercent: y,
        size,
        xPx: 0,
        yPx: 0,
      });
    }

    let mouseX = 0.5, mouseY = 0.5;
    let targetX = 0.5, targetY = 0.5;
    const maxMovePx = 25;

    banner.addEventListener('mousemove', (e) => {
      const rect = banner.getBoundingClientRect();
      targetX = (e.clientX - rect.left) / rect.width;
      targetY = (e.clientY - rect.top) / rect.height;
    });

    banner.addEventListener('mouseleave', () => {
      targetX = 0.5;
      targetY = 0.5;
    });

    function animate() {
      mouseX += (targetX - mouseX) * 0.1;
      mouseY += (targetY - mouseY) * 0.1;

      starsData.forEach(star => {
        const moveX = (mouseX - 0.5) * star.size * maxMovePx;
        const moveY = (mouseY - 0.5) * star.size * maxMovePx;
        star.element.style.transform = `translate(${moveX}px, ${moveY}px)`;
      });

      requestAnimationFrame(animate);
    }

    animate();
  </script>
</body>
</html>
