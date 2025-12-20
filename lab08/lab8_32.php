<?php
echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
$pdh = new PDO("mysql:host=localhost;dbname=bookstore","root","");
$pdh->query("set names 'utf8'");

// Nếu submit form
if (isset($_POST["update"])) {
    $sql = "UPDATE category SET cat_name = :cat_name WHERE cat_id = :cat_id";
    $arr = [":cat_id" => $_POST["cat_id"], ":cat_name" => $_POST["cat_name"]];
    $stm = $pdh->prepare($sql);
    $stm->execute($arr);
    $n = $stm->rowCount();
    if ($n > 0) {
        echo "Đã sửa $n loại sách";
    } else {
        echo "Không có dòng nào được cập nhật";
    }
}

// Nếu có cat_id trên URL thì lấy dữ liệu cũ
if (isset($_GET["cat_id"])) {
    $stm = $pdh->prepare("SELECT * FROM category WHERE cat_id = :cat_id");
    $stm->execute([":cat_id" => $_GET["cat_id"]]);
    $row = $stm->fetch(PDO::FETCH_ASSOC);
}
?>

<?php if (!empty($row)): ?>
<form action="lab8_32.php" method="post">
    <table>
        <tr>
            <td>Mã loại:</td>
            <td><input type="text" name="cat_id" value="<?= htmlspecialchars($row['cat_id']) ?>" readonly /></td>
        </tr>
        <tr>
            <td>Tên loại:</td>
            <td><input type="text" name="cat_name" value="<?= htmlspecialchars($row['cat_name']) ?>" /></td>
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
    window.location = "lab8_3.php";
</script>

