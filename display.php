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

// 查询数据库中的数据
$sql = "SELECT id, title, li, image_path FROM my_table"; 
$result = $conn->query($sql);

// 关闭数据库连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/style.css">
		<title>游戏吧</title>

	</head>
	<body style="background-color:black;">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/87/three.js"></script>
		<script src="https://cdn.jsdelivr.net/gh/theme-next/theme-next-three@latest/three-waves.min.js"></script>

		<div class="container">
			<div class="logo">
				<img src="/image/youxiba.jpg" alt="Baidu Tieba Logo">
			</div>
			<div class="search-bar">
				<input type="text" placeholder="游戏">
				<button id="serch">全吧搜索</button>
			</div>
		</div>

		<div class="yxbg">
			<img src="/image/yxbg.jpg">
		</div>

		<div class="content">

			<div id="ytb" class="contents">
					<div class="buttons">
						<h2 class="btn1">游贴吧</h2>
					<!--	<h2 class="btn2">留言吧</h2>  -->
					</div>
				<?php if ($result && $result->num_rows > 0): ?>
				<table id="ytb">
					<thead>
						<tr>
							<th>火热游戏排行</th>
							<!--    <th>序列</th>  -->
							<th>游戏名</th>
							<th>游戏介绍</th>
						</tr>
					</thead>
					<tbody>
						<?php while($row = $result->fetch_assoc()): ?>
						<tr>
							<td>
								<?php if ($row['image_path']): ?>
								<img src="<?= htmlspecialchars($row['image_path']) ?>" alt="图片"
									style="width:100px; height:auto;">
								<?php else: ?>
								无图片
								<?php endif; ?>
							</td>
							<td><?= htmlspecialchars($row['title']) ?></td>
							<td><a href="https://www.baidu.com"><?= nl2br(htmlspecialchars($row['li'])) ?></a></td>

						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
				<?php else: ?>
				<p>数据库中没有数据。</p>
				<?php endif; ?>
				<br><br>
			<a href="admin-log.php" style="float:left;padding-top:40px;">去登录</a>  
			</div>

			<div class="sider">
				<div class="qr-code">
					<img src="/image/code.jpg" alt="二维码下载客户端">
					<p>下载贴吧APP<br>看高清直播、视频！</p>
				</div>

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
		<!-- 固定广告框 -->
		<div class="ad-box" id="adBox">
			<a href="https://www.baidu.com" target="_blank"><img src="/image/gg.gif" alt="广告"></a>

			<button class="close-btn" onclick="closeAd()">×</button>
	<!--	<div id="lyb" class="contents">
		
			</div>	-->
	</div>

<script>
// 关闭广告框的函数
function closeAd() {
const adBox = document.getElementById('adBox');
adBox.style.display = 'none';
}
</script>

<script>
const btn1 = document.querySelector('.btn1');
const btn2 = document.querySelector('.btn2');
const ytb = document.getElementById('ytb');
const lyb = document.getElementById('lyb');

// 初始状态：显示第一个按钮的内容
ytb.classList.add('active');

btn1.addEventListener('click', () => {
  ytb.classList.add('active');
  lyb.classList.remove('active'); 
});

btn2.addEventListener('click', () => {
  lyb.classList.add('active'); 
  ytb.classList.remove('active'); 
});

</script>

	</body>
</html>
