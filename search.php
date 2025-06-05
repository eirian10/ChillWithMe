<?php
session_start();

include 'DAO/ShowCategoryDAO.php';
$showCategory = new ShowCategoryDAO();
$query = "";
if (isset($_GET['query']))  {
  $query = $_GET['query'];

  if (isset($_SESSION['search_history'])) {
      $history = $_SESSION['search_history'];
  } else {
      $history = [];
  }

  // Nếu lịch sử rỗng hoặc từ khóa tìm kiếm khác từ đầu danh sách
  if (empty($history) || $history[0] !== $query) {
      // Nếu từ khóa đã có trong lịch sử (ở giữa), xóa đi
      $history = array_diff($history, [$query]);

      // Thêm từ khóa mới vào đầu danh sách
      array_unshift($history, $query);

      // Giới hạn lịch sử còn 5 phần tử
      $history = array_slice($history, 0, 5);
  }

  // Lưu lại lịch sử vào session
  $_SESSION['search_history'] = $history;
  $result_baihat = $showCategory->searchMusic($query);
} else {
  echo "Vui lòng nhập từ khóa tìm kiếm.";
  exit;
}

// Tìm kiếm bài hát và ca sĩ


?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thư Viện Nhạc</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="CSS/Category.css">
  <link rel="stylesheet" href="CSS/songCard.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="CSS/search.css">
  <link rel="stylesheet" href="CSS/header.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="CSS/footer.css">
</head>



<body>
  <?php include 'header.php' ?>
  <?php include 'slide.php' ?>
  <div class="results">
    <h2 style="color: red;">Kết quả tìm kiếm cho: "<?php echo $_GET['query']; ?>"</h2>
    <?php if ($result_baihat && $result_baihat->num_rows > 0): ?>
      <div class="hot-songs search">
        <?php while ($row = $result_baihat->fetch_assoc()): ?>
          <div class="song-card" data-id="<?php echo $row['id_baihat']; ?>">
            <div class="play-overlay">
              <i class='bx bx-play-circle'></i>
            </div>
            <img src="<?php echo $row['album']; ?>" alt="Song">
            <div class="song-info">
              <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
              <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p>Không tìm thấy bài hát nào.</p>
    <?php endif; ?>
  </div>

  <?php include 'footer.php' ?>
</body>

<script>
 const songCards = document.querySelectorAll('.song-card');

songCards.forEach((card) => {
  card.addEventListener('click', () => {
    const songId = card.getAttribute('data-id');
    window.location.href = `DetailCategory copy.php?id_baihat=${songId}`;
  });
});

</script>


</html>