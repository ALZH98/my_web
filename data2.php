<?php
// 启动会话
session_start();

// 检查用户是否已登录
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // 如果未登录，重定向到登录页面
    header("Location: login.php");
    exit();
}


// 连接到 MySQL 数据库
$servername = "localhost";
$username = "root";  
$password = "4511123";     
$dbname = "my_database";  

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $li = $conn->real_escape_string($_POST['li']);
    
    // 上传图片处理
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetDir = 'uploads/';
        $targetFile = $targetDir . $imageName;

        // 移动上传的文件
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // 插入数据，包括图片路径
            $sql = "INSERT INTO my_table (title, li, image_path) VALUES ('$title', '$li', '$targetFile')";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='color:green;'>新记录插入成功</p>";
            } else {
                echo "<p style='color:red;'>错误: " . $sql . "<br>" . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color:red;'>图片上传失败</p>";
        }
    } else {
        // 如果没有上传图片
        $sql = "INSERT INTO my_table (title, li) VALUES ('$title', '$li')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>新记录插入成功</p>";
        } else {
            echo "<p style='color:red;'>错误: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
}

// 查询数据库中的数据
$sql = "SELECT id, title, li, image_path FROM my_table";
$result = $conn->query($sql);

// 关闭数据库连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数据插入与显示</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 100px; /* 设置图片大小 */
            height: auto;
        }

	.content {
		display:none;
		width: 1000px;
  		height: 800px;
  		overflow: auto;
  		margin:-104px 300px;
  		padding: 10px;
  		background-color: #f4f4f4;
  		border: 1px solid #ccc;
	}
	.content.active {
		display:block;
		}
/* 导航栏 */
	.navtion{
    	  	width:100%;
    	  	height:100%;
   	}
	
	.left-side, .right-side{
    		width: 300px;
    		height: 50px;
    		border: solid 1px #727171;
	}
		
	 button {
		width:100%;
		height:100%;
  		background-color: #4CAF50;
  		border: none;
  		font-size:17px;
  		transition: background-color 0.5s; /* 平滑过渡效果 */
	}

	button:hover{
		  background-color: #5edd63; /* 鼠标悬停时变为深绿色 */
	}
	
	/* 按钮变成红色的样式 */
	.hryx {
  		background-color: #73E178;
  		color: white;  /* 可选，确保按钮文字颜色清晰 */
	}


    </style>
</head>
<body>

<div class="navtion">
	<div class="left-side">
   <button id="button1" style="color:seashell;">火热游戏排行</button>
  
</div>

<div class="right-side">
	 <button id="button2" style="color:seashell;">本吧信息</button>

<div id="content1" class="content">
    <h2>插入数据</h2>
    <form method="post" enctype="multipart/form-data">
       
         <label for="image">上传图片：</label>
        <input type="file" id="image" name="image" accept="image/*"><br><br>
        
        <label for="title">标题：</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="li">内容：</label>
        <textarea id="li" name="li" required></textarea><br><br>

        <input type="submit" value="提交">
    </form>

    <h2>数据库内容</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>图片</th> <!-- 修改为显示图片 -->
                  <th>ID</th>  
                    <th>游戏名</th>
                    <th>游戏介绍</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($row['image_path']): ?>
                                <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="图片">
                            <?php else: ?>
                                无图片
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['li'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>数据库中没有数据。</p>
    <?php endif; ?>

     <button id="closeButton">关闭</button>
  </div>

<div id="content2" class="content">
    <div class="info-section">
					<h2>本吧信息</h2>
					<div class="avatar">
						<img src="/image/nft.jpg" alt="头像" style="width:36%;">
						<p><strong>吧主</strong></p>
					</div>
					<div style="float:left;">
						<p>ALZH</p>
						<p>小吧：小吧主共29人</p>
						<p>会员：单机游民</p>
						<p>目录：单机与主机游戏</p>
						<p><a href="#">申请吧主</a> | <a href="#">申请小吧主</a></p>
					</div>
				</div>

				<div class="friend-bar">
					<p><a href="http://192.168.62.136/display.php">友情连接</a></p>
					<div>
						<img src="/image/wlyx.jpg" alt="网络游戏">
						<p>网络游戏</p>
					</div>
					<div>
						<img src="image/wdsj.jpg" alt="PS4">
						<p>ps4</p>
					</div>
					<div>
						<img src="/image/ns.jpg" alt="我的世界">
						<p>我的世界</p>
					</div>
					<div>
						<img src="/image/stm.jpg" alt="Steam">
						<p>steam</p>
					</div>
				</div>
  </div>
</div>


</div>

<script>
const button1 = document.getElementById('button1');
const button2 = document.getElementById('button2');
const content1 = document.getElementById('content1');
const content2 = document.getElementById('content2');

// 初始状态：显示第一个按钮的内容
content1.classList.add('active');

button1.addEventListener('click', () => {
  content1.classList.add('active'); // 显示 content1
  content2.classList.remove('active'); // 隐藏 content2
});

button2.addEventListener('click', () => {
  content2.classList.add('active'); // 显示 content2
  content1.classList.remove('active'); // 隐藏 content1
});

  
  </script>
  
</body>
</html>

