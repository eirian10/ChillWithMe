<?php
    session_start();
?>
<div class="Header">
  <!-- Logo -->
  <div class="Logo">
    <a href="trangchu.php">
      <img src="imageWeb/logo.png" alt="" />
    </a>
  </div>
  <!-- Main menu -->
  <div class="Menu">
    <ul>
      <li>
        <a href="trangchu.php">Home</a>
      </li>
      <li>
        <a href="Category copy.php">Thể loại</a>
      </li>
      <li>
        <a href="nghesi.php">Album</a>
      </li>
      <li>
        <a href="#">Playlist</a>
      </li>
      <li>
        <a href="#">BXH</a>
      </li>

      <li id="Other">
        <a href="#">
          <img src="./image/Icon/Icon_others.png" alt="" />
        </a>
      </li>
    </ul>
  </div>
  <!-- Others option -->
  <div class="Other">
    <ul>
      <li>
        <div class="search-box">
          <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Tìm bài hát hoặc nghệ sĩ " autocomplete="off">
            <button type="submit">Tìm kiếm</button>
          </form>
<div class="recent-searches">
    <p><strong>Tìm kiếm gần đây:</strong></p>
    <?php
    // Bước 1: Kiểm tra và lấy lịch sử tìm kiếm từ session
    if (isset($_SESSION['search_history'])) {
        $history = $_SESSION['search_history'];
    } else {
        $history = [];
    }

    // Bước 2: Kiểm tra nếu có lịch sử thì hiển thị, nếu không thì báo chưa có
    if (!empty($history)) {
        foreach ($history as $keyword) {
            // Hiển thị từng từ khóa tìm kiếm gần đây, đảm bảo an toàn với htmlspecialchars
            ?>
            <a href="search.php?query=<?= urlencode($keyword) ?>" class="search-tag">
                <?= htmlspecialchars($keyword) ?>
            </a>
            <?php
        }
    } else {
        // Nếu không có lịch sử tìm kiếm
        echo '<p>Chưa có tìm kiếm nào.</p>';
    }
    ?>
</div>

      </li>

      </li>
      <li class="Login">
        <a href="dangnhap.php" id="Login"> Đăng nhập </a>
      </li>
      <li class="Signin">
        <a href="dangky.php" id="Signin">Đăng ký</a>
      </li>
    </ul>
  </div>
</div>