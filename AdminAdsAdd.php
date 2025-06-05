<?php
session_start();
include '../DAO/AdsDAO.php';

$adsDAO = new AdsDAO();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $target_url = $_POST['target_url'] ?? '';
    $image_url = '';

    if ($title && $target_url && isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../Ads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['image_file']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadFile)) {
            $image_url = 'Ads/' . $fileName; // Lưu đường dẫn tương đối vào DB
            $result = $adsDAO->addAd($title, $image_url, $target_url);
            if ($result) {
                header('Location: AdminAdsShow.php');
                exit;
            } else {
                echo "Thêm quảng cáo thất bại!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm quảng cáo</title>
  <link rel="stylesheet" href="../CSS/formSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/IndexAdmin.css?v=<?= time(); ?>">
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <main>
            <h2>Thêm quảng cáo mới</h2>
            <form method="post" enctype="multipart/form-data">
                <label>Tiêu đề:</label><br>
                <input type="text" name="title" required><br><br>
                <label>Link ảnh (image_url):</label><br>
                <input type="file" name="image_file" accept="image/*" required><br><br>
                <label>Link đích (target_url):</label><br>
                <input type="text" name="target_url" required><br><br>
                <input type="submit" value="Thêm quảng cáo">
            </form>
        </main>
    </div>
    <?php include 'footerAdmin.php'; ?>
</body>
</html>