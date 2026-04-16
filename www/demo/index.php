<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker LNMP 环境</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .success { color: #4CAF50; font-weight: bold; }
        .info { background: #e3f2fd; padding: 15px; border-radius: 4px; margin: 20px 0; }
        a { color: #2196F3; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 Docker LNMP 环境运行成功!</h1>
        
        <p class="success">✓ Nginx 服务正常</p>
        <p class="success">✓ PHP 服务正常</p>
        
        <div class="info">
            <h3>📚 可用链接</h3>
            <ul>
                <li><a href="/demo/phpinfo.php">PHP 信息</a></li>
                <li><a href="http://localhost:15672" target="_blank">RabbitMQ 管理界面</a></li>
                <li><a href="http://localhost:5601" target="_blank">Kibana</a></li>
                <li><a href="http://localhost:8848/nacos" target="_blank">Nacos</a></li>
            </ul>
        </div>
        
        <div class="info">
            <h3>📝 使用说明</h3>
            <p>将你的项目代码放在 <code>www/</code> 目录下,然后在 <code>conf/nginx/conf/conf.d/</code> 中添加对应的 Nginx 配置。</p>
            <p>详细文档请查看项目 <a href="https://gitee.com/jessedev/docker-lnmp" target="_blank">README.md</a></p>
        </div>
    </div>
</body>
</html>
