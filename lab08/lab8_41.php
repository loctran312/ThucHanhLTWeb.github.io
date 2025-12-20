<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lab8_41</title>
</head>

<body>
        <!-- Form nhập dữ liệu loại sách -->
        <form action="lab8_41.php" method="post">
            <table>
                <tr>
                    <td>Tìm sách:</td>
                    <td><input type="text" name="search" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="sm" value="Tìm kiếm" />
                    </td>
                </tr>
            </table>
        </form>
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

    // ------------------- TRUY VẤN SELECT -------------------
    $rows = [];
    if (isset($_POST["sm"])) {
        $search = $_POST["search"]; // từ khóa tìm kiếm
        $sql = "select * from book where book_name like :ten"; // câu lệnh SQL có tham số
        $stm = $pdh->prepare($sql); // chuẩn bị câu lệnh
        $stm->bindValue(":ten", "%$search%"); // gán giá trị cho tham số :ten
        $stm->execute(); // thực thi câu lệnh
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC); // lấy tất cả kết quả dưới dạng mảng kết hợp
    }
    ?>

    <!-- Hiển thị danh sách loại sách -->
    <table border="1px">
    <?php
    if (!empty($rows)) {
        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["book_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["book_name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["pub_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cat_id"]) . "</td>";
            echo "<td>" . "<a href=" . "lab8_42.php?book_id=$row[book_id]" . ">Xóa</a></td>";
            echo "<td>" . "<a href=" . "lab8_43.php?book_id=$row[book_id]" . ">Sửa</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
    }
    ?>
    </table>

</body>

</html>
