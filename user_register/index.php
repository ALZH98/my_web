<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册</title>
</head>
<body>
    <h2>注册页面</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 数据库配置
        $servername = "localhost";
        $username = "root"; // 替换为你的数据库用户名
        $password = "4511123"; // 替换为你的数据库密码
        $dbname = "my_database";

        // 表单数据
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // 创建数据库连接
        $conn = new mysqli($servername, $username, $password, $dbname);

        // 检查连接是否成功
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }

        // 使用参数化查询防止SQL注入
        $stmt = $conn->prepare("INSERT INTO users_data (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $pass);

        if ($stmt->execute()) {
           echo "<script>alert('注册成功！'); window.location.href='http://192.168.62.145/display.php';</script>";
        } else {
            echo "<script>alert('注册失败: " . $conn->error . "');</script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form method="POST" action="">
        <label for="username">用户名：</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">密码：</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">注册</button>
    </form>
</body>
</html>
