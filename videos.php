<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<title>Danh Sách Video - Banner Void Toàn Trang</title>
<style>
  /* Reset */
  * {
    margin:0; padding:0; box-sizing: border-box;
  }
  html, body {
    height: 100%;
    overflow: hidden;
    font-family: 'Arial', sans-serif;
    background: black;
    color: white;
  }
  /* Canvas cho chòm sao */
  #starfield {
    position: fixed;
    top:0; left:0;
    width: 100vw;
    height: 100vh;
    z-index: 0;
    background: radial-gradient(ellipse at center, #000000, #000011);
  }
  /* Banner full màn hình */
  .banner {
    position: relative;
    z-index: 10;
    width: 100vw;
    height: 100vh;
    padding: 40px 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    backdrop-filter: brightness(0.7);
  }
  .banner h1 {
    font-size: 3.2rem;
    margin-bottom: 5px;
    text-shadow: 0 0 10px #00aaffaa;
  }
  .banner p {
    margin-bottom: 30px;
    font-size: 1.3rem;
    color: #88ccffcc;
    text-shadow: 0 0 6px #00aaffaa;
  }
  /* Container video thumbnails */
  .video-thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 20px;
    width: 100%;
    max-width: 1200px;
    margin-top: auto;
    margin-bottom: 40px;
    overflow-y: auto;
    max-height: 50vh;
    padding-right: 10px;
  }
  /* Scrollbar đẹp */
  .video-thumbnails::-webkit-scrollbar {
    width: 8px;
  }
  .video-thumbnails::-webkit-scrollbar-track {
    background: transparent;
  }
  .video-thumbnails::-webkit-scrollbar-thumb {
    background: #00aaff99;
    border-radius: 4px;
  }
  /* Mỗi video thumbnail */
  .video-item {
    background: #00334d66;
    border-radius: 10px;
    padding: 8px;
    cursor: pointer;
    box-shadow: 0 0 8px #00aaff77;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .video-item:hover {
    transform: scale(1.1);
    box-shadow: 0 0 15px #00ddffcc;
  }
  .video-item video {
    width: 100%;
    border-radius: 8px;
    max-height: 110px;
    object-fit: cover;
  }
  .video-title {
    margin-top: 6px;
    font-size: 0.85rem;
    color: #aaddffcc;
    text-align: center;
    word-break: break-word;
  }

  /* Modal to xem video */
  .modal {
    display: none;
    position: fixed;
    top:0; left:0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0,0,0,0.9);
    align-items: center;
    justify-content: center;
    z-index: 50;
  }
  .modal.active {
    display: flex;
  }
  .modal video {
    max-width: 90vw;
    max-height: 90vh;
    border-radius: 10px;
    box-shadow: 0 0 30px #00aaffdd;
  }
  .modal .close-btn {
    position: absolute;
    top: 20px; right: 30px;
    font-size: 40px;
    color: #00aaffcc;
    cursor: pointer;
    user-select: none;
    transition: color 0.3s ease;
    font-weight: bold;
  }
  .modal .close-btn:hover {
    color: #00ddff;
  }
  /* Responsive */
  @media(max-width: 768px) {
    .banner h1 {
      font-size: 2.2rem;
    }
    .banner p {
      font-size: 1rem;
    }
    .video-thumbnails {
      max-height: 40vh;
      gap: 12px;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
    .video-item video {
      max-height: 80px;
    }
  }
	.back-home-fixed {
  position: fixed;
  top: 20px;
  left: 20px;
  z-index: 100;
  font-size: 1rem;
  color: #00bbff;
  text-decoration: none;
  border: 1px solid #00aaffaa;
  padding: 8px 14px;
  border-radius: 6px;
  background-color: rgba(0, 0, 0, 0.4);
  backdrop-filter: blur(2px);
  transition: all 0.25s ease;
  box-shadow: 0 0 10px #00aaff55;
}
.back-home-fixed:hover {
  background-color: rgba(0, 170, 255, 0.2);
  color: #ffffff;
  box-shadow: 0 0 15px #00ddffaa;
}
.menu-wrapper {
  position: fixed;
  top: 20px;
  left: 20px;
  z-index: 100;
}

.hamburger {
  font-size: 28px;
  cursor: pointer;
  color: #00bbff;
  background-color: rgba(0, 0, 0, 0.4);
  border: 1px solid #00aaffaa;
  padding: 8px 12px;
  border-radius: 6px;
  backdrop-filter: blur(2px);
  transition: all 0.3s ease;
  box-shadow: 0 0 10px #00aaff55;
}

.hamburger:hover {
  background-color: rgba(0, 170, 255, 0.2);
  color: #ffffff;
  box-shadow: 0 0 12px #00ddffaa;
}

.menu-dropdown {
  display: none;
  margin-top: 10px;
  background-color: rgba(0,0,0,0.6);
  border: 1px solid #00aaff66;
  border-radius: 6px;
  padding: 10px;
  backdrop-filter: blur(4px);
  box-shadow: 0 0 12px #00aaff44;
}

.menu-dropdown a {
  display: block;
  color: #00bbff;
  text-decoration: none;
  font-size: 1rem;
  padding: 6px 10px;
  border-radius: 4px;
  transition: background-color 0.25s;
}

.menu-dropdown a:hover {
  background-color: #00aaff22;
  color: #ffffff;
}

</style>
</head>
<body>
	
<div class="menu-wrapper">
  <div class="hamburger" onclick="toggleMenu()">☰</div>
  <div class="menu-dropdown" id="menuDropdown">
    <a href="index.php">⬅ Quay lại Trang Chủ</a>
  </div>
</div>


<canvas id="starfield"></canvas>

<!-- Banner void full màn hình -->
<div class="banner">
  <h1>🌌 Danh Sách Video - Không Gian Void</h1>
  <p>Nhấn vào video bên dưới để xem full màn hình</p>
	
		
  <div class="video-thumbnails" id="videoThumbnails">
  
    <?php
      $dir = "uploads/";
      $allowed = ['mp4','avi','mov','wmv'];
      $videos = array_filter(scandir($dir), function($f) use ($allowed, $dir) {
          $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
          return in_array($ext, $allowed);
      });

      if (count($videos) == 0) {
          echo "<p style='color:#44bbff; font-size:1.2rem; text-align:center; width:100%;'>Chưa có video nào được tải lên.</p>";
      } else {
          foreach ($videos as $v) {
              $path = $dir . $v;
              $ext = pathinfo($v, PATHINFO_EXTENSION);
              echo '<div class="video-item" onclick="openModal(\'' . addslashes($path) . '\')">';
              echo '<video muted preload="metadata"><source src="'. htmlspecialchars($path) .'" type="video/' . htmlspecialchars($ext) .'"></video>';
              echo '<div class="video-title">'. htmlspecialchars($v) .'</div>';
              echo '</div>';
          }
      }
    ?>
  </div>
</div>

<!-- Modal xem video full màn hình -->
<div id="videoModal" class="modal" onclick="closeModal(event)">
  <span class="close-btn" onclick="closeModal(event)">&times;</span>
  <video id="modalVideo" controls autoplay></video>
</div>

<script>
// Starfield animation
const canvas = document.getElementById('starfield');
const ctx = canvas.getContext('2d');
let stars = [];
const numStars = 200;

function randomRange(min, max) {
  return Math.random() * (max - min) + min;
}
function createStars() {
  stars = [];
  for(let i=0; i<numStars; i++) {
    stars.push({
      x: Math.random() * window.innerWidth,
      y: Math.random() * window.innerHeight,
      size: randomRange(0.8, 2.5),
      brightness: randomRange(0.5, 1),
      speed: randomRange(0.01, 0.04),
      directionX: Math.random() < 0.5 ? -1 : 1,
      directionY: Math.random() < 0.5 ? -1 : 1,
    });
  }
}
function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
function drawStars() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  stars.forEach(star => {
    star.x += star.speed * star.directionX;
    star.y += star.speed * star.directionY;

    // Bounce stars on edges for "smooth" move
    if(star.x < 0 || star.x > canvas.width) star.directionX *= -1;
    if(star.y < 0 || star.y > canvas.height) star.directionY *= -1;

    // Draw star with glow effect
    let grad = ctx.createRadialGradient(star.x, star.y, 0, star.x, star.y, star.size * 4);
    grad.addColorStop(0, `rgba(180, 230, 255, ${star.brightness})`);
    grad.addColorStop(0.6, `rgba(180, 230, 255, ${star.brightness*0.3})`);
    grad.addColorStop(1, 'rgba(180, 230, 255, 0)');
    ctx.fillStyle = grad;
    ctx.beginPath();
    ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
    ctx.fill();
  });
}
function animate() {
  drawStars();
  requestAnimationFrame(animate);
}
window.addEventListener('resize', () => {
  resizeCanvas();
  createStars();
});
resizeCanvas();
createStars();
animate();

// Modal video
const modal = document.getElementById('videoModal');
const modalVideo = document.getElementById('modalVideo');

function openModal(src) {
  modal.classList.add('active');
  modalVideo.src = src;
  modalVideo.play();
}
function closeModal(e) {
  if(e.target === modal || e.target.classList.contains('close-btn')) {
    modal.classList.remove('active');
    modalVideo.pause();
    modalVideo.src = "";
  }
}
	function toggleMenu() {
  const menu = document.getElementById('menuDropdown');
  menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

</script>
</body>
</html>
