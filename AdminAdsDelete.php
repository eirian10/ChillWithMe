
<?php
include '../DAO/AdminSongDAO.php';

$songDAO = new AdminSongDAO();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $songData = $songDAO->GetSongById($id);

    if ($songData) {
        // Xóa file album nếu tồn tại
        if (!empty($songData['album'])) {
            $albumPath = '../album/' . $songData['album'];
            if (file_exists($albumPath)) {
                unlink($albumPath);
            }
        }
        // Xóa file nhạc nếu tồn tại
        if (!empty($songData['linknhac'])) {
            $audioPath = '../audio/' . $songData['linknhac'];
            if (file_exists($audioPath)) {
                unlink($audioPath);
            }
        }

        // Xóa dữ liệu trong database
        $deleteResult = $songDAO->DeleteSongById($id);

        if ($deleteResult) {
            header("Location: AdminSongShow.php");
            exit();
        } else {
            echo "Xóa bài hát không thành công.";
        }
    } else {
        echo "Không tìm thấy dữ liệu bài hát.";
    }
} else {
    echo "Không tìm thấy ID bài hát để xóa.";
}
?>