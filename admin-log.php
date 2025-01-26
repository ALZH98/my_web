<?php
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

// 处理登录请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $conn->real_escape_string($_POST['username']);
    $input_password = $conn->real_escape_string($_POST['password']);

    // 查询数据库中的用户名和密码
    $sql = "SELECT * FROM users WHERE username = '$input_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // 检查密码是否正确
        if ($input_password == $row['password']) {
            // 登录成功，重定向到 admin.php
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $input_username;
            header("Location: admin.php");
            exit();
        } else {
            // 密码错误
            $error = "用户名或密码错误！";
        }
    } else {
        // 用户不存在
        $error = "用户名或密码错误！";
    }
}

// 关闭数据库连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录页面</title>

	<style>
		*{
			margin:0;
			padding:0;
			}
		body{background-color: white;}
		
		.contianer{
			  width: 675px;
			  height: 331px;
			  border: solid 1px;
			  margin: 150px auto;
			  background-color: darkseagreen;
			  border-radius: 20px;
			  box-shadow: 33px 26px 8px 0px #c6c6c6;
			  overflow: hidden;
  			}
		.log{
  			width: 350px;
  			height: 100%;
			background-color: whitesmoke;
			float:right;
			}
		.log h2{
			margin:20px auto 20px;
		  	width: 100px;
		  	text-align:center;
		  	font-size: xxx-large;
			}
		.log form{
			padding:10px 30px;
			}
		label {
			font-size: large;
			}
		.log input {
   			 width: 183px;
   			 height: 27px;
  			 border: 0px;
   			 margin-top: 19px;
   			 box-shadow: 10px 11px 5px 3px #c6c6c6;
   			 border-radius: 6px;
			}
		input::placeholder {
        		color: gray;
        		font-style: italic;
        		font-size: 14px;
    			}
		button{
			width:100px;
			height:30px;
			border-radius: 12px;
			display:block;
			margin:30px auto;
			background-color: skyblue;
			border:solid 0px;
			}
		.log-con{

			}
		.left{
			width: 350px;
			height: 100%;
			background: red;
			background-image:url("/image/nft2.webp");
			background-size: 100%;
			}
		button{
			box-shadow: 5px 9px 8px 3px #cccccc;
			}
	 	/* 按钮初始样式 */
	  #colorButton {
		    font-size: 16px;
		    color: white;
		    background-color: blue; /* 初始颜色为蓝色 */
		    border: none;
		    cursor: pointer;
		    height: 37px;
		    border-radius: 26px;
  			}
	</style>

    
    <script type="text/javascript">
        // 显示错误信息
        window.onload = function() {
            <?php if (isset($error)): ?>
                alert("<?php echo $error; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body>
<div class="contianer">
   <div class="log">
   		 <h2>登录</h2>
   	  <div class="log-con">
   		
 		   <form method="post" action="admin-log.php">
       			 <label for="username">用户名：</label>
        			 <input type="text" id="username" name="username" placeholder="请输入用户名" required><br><br>
        			 <label for="password">&nbsp;&nbsp;&nbsp;&nbsp;密码：</label>
       			 <input type="password"  id="password" name="password" placeholder="请输入密码" required><br><br>
        			 <button type="submit" id="colorButton" value="登录">登录 </button>
    			</form>
    	   </div>
    			
   </div>
   <div class="left">
 	
  
  </div>   
</div>
<script src="https://cdn.bootcss.com/canvas-nest.js/1.0.0/canvas-nest.min.js"></script>

</body>
</html>
s