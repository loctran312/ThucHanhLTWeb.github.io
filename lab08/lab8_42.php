<?php
// ------------------- KẾT NỐI CSDL -------------------
try {
    // Tạo đối tượng PDO kết nối đến database 'bookstore' với user 'root'
    $pdh = new PDO("mysql:host=localhost; dbname=bookstore", "root", "");
    // Thiết lập bộ mã UTF-8 để hiển thị tiếng Việt đúng
    $pdh->query("set names 'utf8'");
} catch (Exception $e) {
    // Nếu kết nối thất bại thì báo lỗi và dừng chương trình
    echo $e->getMessage();
    exit;
}

// ------------------- LẤY MÃ LOẠI CẦN XÓA -------------------
$book_id = isset($_GET["book_id"]) ? $_GET["book_id"] : ""; 
// Lấy tham số 'cat_id' từ URL, nếu không có thì gán rỗng

// ------------------- CÂU LỆNH SQL XÓA -------------------
$sql = "delete from book where book_id = :book_id"; 
// Câu lệnh SQL có tham số :cat_id
$arr = array(":book_id" => $book_id); 
// Mảng ánh xạ tham số với giá trị lấy từ URL

// ------------------- THỰC THI CÂU LỆNH -------------------
$stm = $pdh->prepare($sql); // Chuẩn bị câu lệnh
$stm->execute($arr);        // Thực thi với mảng tham số
$n = $stm->rowCount();      // Số dòng bị ảnh hưởng (số bản ghi xóa được)

// ------------------- THÔNG BÁO KẾT QUẢ -------------------
if ($n > 0) 
    $thongbao = "Đã xóa $n loại sách!"; // Nếu có dòng bị xóa
else 
    $thongbao = "Lỗi xóa!";             // Nếu không có dòng nào bị xóa
?>

<!-- ------------------- HIỂN THỊ THÔNG BÁO VÀ CHUYỂN TRANG ------------------- -->
<script language="javascript">
    // Hiển thị thông báo bằng hộp thoại alert
    alert("<?php echo $thongbao; ?>");
    // Sau khi bấm OK, chuyển hướng về trang danh sách loại sách
    window.location = "lab8_41.php";
</script>
