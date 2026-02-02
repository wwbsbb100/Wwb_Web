<?php
// ============ 同样只改这4行配置！和上面的采集代码一模一样 ============
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = 'wwb123456';
$db_name = 'web_visit';
// ============ 配置结束，下面不用改 ============

// 连接数据库
$conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
mysqli_set_charset($conn, 'utf8mb4');

// 查询所有访问记录，最新的访问排在最上面
$sql = "SELECT * FROM visit_log ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$all_visit = mysqli_fetch_all($result, MYSQLI_ASSOC);

// 统计总访问量
$total_count = count($all_visit);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>我的网站访问监控后台</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{width:95%;margin:20px auto;font-family:微软雅黑;}
        h1{text-align:center;color:#2c3e50;margin-bottom:20px;}
        .total{font-size:18px;color:#e74c3c;font-weight:bold;margin-bottom:15px;}
        table{width:100%;border-collapse:collapse;border:1px solid #ddd;}
        th,td{padding:12px;text-align:center;border:1px solid #ddd;}
        th{background-color:#f8f9fa;color:#34495e;}
        tr:hover{background-color:#f1f1f1;}
        td{font-size:14px;}
    </style>
</head>
<body>
    <h1>✅ 我的网站访问监控后台</h1>
    <div class="total">📊 网站总访问量：<?php echo $total_count; ?> 次</div>
    <table>
        <tr>
            <th>序号</th>
            <th>访问者IP</th>
            <th>访问时间</th>
            <th>访问页面</th>
            <th>设备/浏览器</th>
            <th>访问来源</th>
        </tr>
        <?php foreach($all_visit as $k=>$v): ?>
        <tr>
            <td><?php echo $k+1; ?></td>
            <td><?php echo $v['ip']; ?></td>
            <td><?php echo $v['visit_time']; ?></td>
            <td><?php echo $v['page_url']; ?></td>
            <td><?php echo $v['device_info']; ?></td>
            <td><?php echo $v['visit_source']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php mysqli_close($conn); ?>