<?php
$pdh = new PDO("mysql:host=localhost;dbname=bookstore","root","");
$pdh->query("set names 'utf8'");

// Nếu submit form
if (isset($_POST["update"])) {
    $sql = "UPDATE book 
            SET book_name   = :book_name, 
                description = :description, 
                price       = :price 
            WHERE book_id   = :book_id";

    $arr = [
        ":book_id"    => $_POST["book_id"],
        ":book_name"  => $_POST["book_name"],
        ":description"=> $_POST["description"],
        ":price"      => $_POST["price"]
    ];

    $stm = $pdh->prepare($sql);
    $stm->execute($arr);
    $n = $stm->rowCount();

    if ($n > 0) {
        echo "Đã sửa $n sách";
    } else {
        echo "Không có dòng nào được cập nhật (có thể book_id không tồn tại hoặc dữ liệu không thay đổi)";
    }
}


// Nếu có cat_id trên URL thì lấy dữ liệu cũ
if (isset($_GET["book_id"])) {
    $stm = $pdh->prepare("SELECT * FROM book WHERE book_id = :book_id");
    $stm->execute([":book_id" => $_GET["book_id"]]);
    $row = $stm->fetch(PDO::FETCH_ASSOC);
}
?>

<?php if (!empty($row)): ?>
<form action="lab8_43.php" method="post">
    <table>
        <tr>
            <td>Mã loại:</td>
            <td><input type="text" name="book_id" value="<?= htmlspecialchars($row['book_id']) ?>" readonly /></td>
        </tr>
        <tr>
            <td>Tên loại:</td>
            <td><input type="text" name="book_name" value="<?= htmlspecialchars($row['book_name']) ?>" /></td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><input type="text" name="description" value="<?= htmlspecialchars($row['description']) ?>" /></td>
        </tr>
        <tr>
            <td>Price:</td>
            <td><input type="text" name="price" value="<?= htmlspecialchars($row['price']) ?>" /></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="update" value="Update" /></td>
        </tr>
    </table>
</form>
<?php endif; ?>

<!-- ------------------- HIỂN THỊ THÔNG BÁO VÀ CHUYỂN TRANG ------------------- -->
<script language="javascript">
    // Hiển thị thông báo bằng hộp thoại alert
    alert("<?php echo $thongbao; ?>");
    // Sau khi bấm OK, chuyển hướng về trang danh sách loại sách
    window.location = "lab8_41.php";
</script>
