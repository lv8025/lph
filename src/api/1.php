<?php
// 连接数据库
$connect = mysqli_connect('localhost', 'lvpenghui', 'lvpenghui', 'lvpenghui') or die('数据库连接失败');
mysqli_set_charset($connect, 'utf8');
// 查询总条数
$sql = "select * from deal";
$query = mysqli_query($connect, $sql);
// 返回结果集中行的数量
$num = mysqli_num_rows($query);
// 定义每页显示几条
$pageSize = 2;
// 一共分几页
$totalPage = ceil($num / $pageSize);
// 获取当前页
if ($_GET['page']) {
	$page = $_GET['page'];
} else {
	$page = 1;
}
// 在当前页的基础上确定上一页
if ($page == 1) {
	$up = 1;
} else {
	$up = $page - 1;
}
// 在当前页的基础上确定下一页
if ($page == $totalPage) {
	$next = $totalPage;
} else {
	$next = $page + 1;	
}
// 求出 limit 的第一个参数
$start = ($page - 1) * $pageSize;
$sql = "select * from student deal $start, $pageSize";
$res = mysqli_query($connect, $sql);
$result = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 </head>
 <body>
	<table border="1" cellspacing="0" cellpadding="0" style="width: 50%;text-align: center;">
		<caption>学生列表</caption>
		<tr>
			<td>ID</td>
			<td>姓名</td>
		</tr>
		<?php foreach ($result as $v) { ?>
		<tr>
			<td><?php echo $v['game']; ?></td>
			<td><?php echo $v['moves']; ?></td>
		</tr>
		<?php } ?>
	</table>
	<a href="1.php?page=<?php echo $up; ?>"><button>上一页</button></a>
	<a href="1.php?page=<?php echo $next; ?>"><button>下一页</button></a>
 </body>
</html>

