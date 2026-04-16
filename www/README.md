# 项目目录

此目录用于存放您的 Web 项目代码。

## 示例

- `demo/` - 环境测试示例（phpinfo 页面）

## 使用说明

1. 将您的项目代码复制到此目录
2. 在 `conf/nginx/conf/conf.d/` 中创建对应的 Nginx 配置文件
3. 重启 Nginx: `docker compose restart jesse-nginx-service`

详细配置方法请查看根目录的 [README.md](../README.md)
