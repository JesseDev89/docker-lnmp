# Docker LNMP 开发环境

基于 Docker 构建的现代化 LNMP 开发环境，支持多版本 PHP、多种数据库和中间件，提供开箱即用的本地开发体验。

## ✨ 特性

- 🚀 **快速部署**：一键启动完整的开发环境
- 🔄 **多版本支持**：PHP 7.4 / 8.0 / 8.1 / 8.2 及 Swoole 扩展
- 📦 **丰富组件**：MySQL、MongoDB、Redis、RabbitMQ、Elasticsearch、Nacos
- 🔧 **灵活配置**：通过环境变量轻松定制服务参数
- 💾 **数据持久化**：所有数据目录自动挂载到宿主机
- 🌐 **多项目支持**：支持同时运行多个 Web 项目

---

## 📋 系统要求

- Docker >= 20.10
- Docker Compose >= 2.0
- macOS / Linux / Windows (WSL2)

---

## 🚀 快速开始

### 1. 克隆项目

```bash
git clone https://gitee.com/jessedev/docker-lnmp.git
cd docker-lnmp
```

### 2. 初始化配置

```bash
# 复制环境变量配置文件
cp .env.example .env

# 复制 Docker Compose 配置文件
cp docker-compose-example.yml docker-compose.yml
```

### 3. 启动服务

```bash
# 构建并启动所有服务
docker compose up -d

# 查看服务状态
docker compose ps
```

### 4. 验证安装

访问以下地址确认服务正常运行：

- Nginx: http://localhost
- PHPInfo: http://localhost/demo/phpinfo.php

---

## 🛠️ 服务管理

### 常用命令

```bash
# 启动服务
docker compose up -d

# 停止服务
docker compose down

# 重启指定服务
docker compose restart nginx

# 查看日志
docker compose logs -f nginx

# 进入容器
docker exec -it jesse-nginx-service /bin/bash

# 查看服务状态
docker compose ps
```

---

## 📊 服务组件

### Web 服务器

#### Nginx
- **端口**: 80 (HTTP), 443 (HTTPS)
- **配置文件**: `conf/nginx/conf/nginx.conf`
- **站点配置**: `conf/nginx/conf/conf.d/`
- **日志目录**: `log/nginx/log/`
- **网站根目录**: `www/`

### 数据库

#### MySQL 8.0
- **端口**: 3306
- **默认用户**: root (无密码)
- **数据存储**: `store/mysql/data/`
- **配置文件**: `conf/mysql/my.cnf`

**修改 root 密码：**

```bash
# 进入容器, 直接回车
docker exec -it jesse-mysql8.0-service mysql -uroot -p

# 执行 SQL
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'a123456';
CREATE USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'a123456';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';
FLUSH PRIVILEGES;
```

#### MongoDB
- **端口**: 27017
- **数据存储**: `store/mongodb/data/`
- **配置文件**: `conf/mongodb/mongod.conf`

**创建管理员账号：**

```bash
# 进入 MongoDB Shell
docker exec -it jesse-mongodb-service mongosh admin

# 创建用户
db.createUser({ 
  user: 'root', 
  pwd: 'a123456', 
  roles: [ 
    { role: 'userAdminAnyDatabase', db: 'admin' }, 
    'readWriteAnyDatabase'
  ] 
});

# 验证
db.auth("root", "a123456");
```

#### Redis
- **端口**: 6379
- **数据存储**: `store/redis/`
- **配置文件**: `conf/redis/redis.conf`

### 消息队列

#### RabbitMQ
- **管理界面**: http://localhost:15672
- **AMQP 端口**: 5672
- **默认账号**: guest / guest
- **数据存储**: `store/rabbitmq/data/`

**创建管理员用户：**

```bash
docker exec -it jesse-rabbitmq-service rabbitmqctl add_user admin a123456
docker exec -it jesse-rabbitmq-service rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"
docker exec -it jesse-rabbitmq-service rabbitmqctl set_user_tags admin administrator
```

### 搜索引擎

#### Elasticsearch
- **端口**: 9200
- **数据存储**: `store/elasticsearch/data/`
- **配置文件**: `conf/elasticsearch/elasticsearch.yml`
- **日志目录**: `log/elasticsearch/`

**初始化密码：**

```bash
# 进入容器
docker exec -it jesse-elasticsearch-service /bin/bash

# 设置密码（建议统一使用: a123456）
elasticsearch-setup-passwords interactive
```

#### Kibana
- **访问地址**: http://localhost:5601
- **配置文件**: `conf/kibana/kibana.yml`
- **日志目录**: `log/kibana/`

### 服务治理

#### Nacos
- **访问地址**: http://localhost:8848/nacos
- **默认账号**: nacos / nacos
- **配置文件**: `conf/nacos/custom.properties`
- **日志目录**: `log/nacos/`

### PHP 运行时

支持以下版本（根据需要在 `docker-compose.yml` 中启用）：

- **PHP 7.4**: `jesse-php7.4-service`
- **PHP 8.0**: `jesse-php8.0-service`
- **PHP 8.1**: `jesse-php8.1-service`
- **PHP 8.2**: `jesse-php8.2-service`
- **Swoole 版本**: 各 PHP 版本均提供 Swoole 扩展支持

**配置文件位置**：
- PHP 配置: `conf/php*/conf.d/`
- PHP-FPM 配置: `conf/php*/php-fpm.d/`
- 日志目录: `log/php*/`

---

## 📁 项目结构

```
docker-lnmp/
├── conf/                   # 服务配置文件
│   ├── nginx/             # Nginx 配置
│   ├── mysql/             # MySQL 配置
│   ├── php*/              # PHP 配置
│   └── ...                # 其他服务配置
├── www/                    # 网站根目录
│   ├── project1/          # 项目 1
│   ├── project2/          # 项目 2
│   └── test.php           # 测试文件
├── store/                  # 数据持久化目录
│   ├── mysql/             # MySQL 数据
│   ├── mongodb/           # MongoDB 数据
│   ├── redis/             # Redis 数据
│   └── ...                # 其他服务数据
├── log/                    # 日志目录
│   ├── nginx/             # Nginx 日志
│   ├── mysql/             # MySQL 日志
│   └── ...                # 其他服务日志
├── docker-compose.yml      # Docker Compose 配置
├── .env                    # 环境变量配置
└── README.md               # 项目说明文档
```

---

## ⚙️ 配置说明

### 环境变量 (.env)

主要配置项：

```bash
# 代码项目目录
WEB_ROOT_PATH=./www

# Nginx 配置
NGINX_PORT=80

# MySQL 配置
MYSQL_ROOT_PASSWORD=a123456
MYSQL_PORT=3306

# Redis 配置
REDIS_PORT=6379

# MongoDB 配置
MONGODB_PORT=27017

# RabbitMQ 配置
RABBITMQ_HTTP_PORT=15672
RABBITMQ_AMQP_PORT=5672

# Elasticsearch 配置
ES_HTTP_PORT=9200

# Kibana 配置
KIBANA_PORT=5601

# Nacos 配置
NACOS_PORT=8848
```

### Nginx 站点配置

在 `conf/nginx/conf/conf.d/` 目录下创建站点配置文件：

```nginx
server {
    listen 80;
    server_name example.local;
    root /var/www/example/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass jesse-php8.1-service:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## 🔧 常见问题

### 1. 端口冲突

如果端口被占用，修改 `.env` 文件中的端口配置：

```bash
NGINX_HTTP_PORT=8080
MYSQL_PORT=3307
```

### 2. 权限问题

确保数据目录有正确的权限：

```bash
chmod -R 777 store/ log/
```

### 3. PHP 扩展缺失

⚠️ **注意**：本项目不提供源码构建功能。如需添加 PHP 扩展或自定义镜像，请联系作者获取技术支持。

**联系方式**：
- Gitee: https://gitee.com/jessedev
- Email: jessdev@163.com

### 4. 清理数据

⚠️ **警告**：此操作将删除所有持久化数据！

```bash
docker compose down -v
rm -rf store/* log/*
```

---

## 📝 开发建议

1. **代码存放**：将所有项目代码放在 `www/` 目录下
2. **域名配置**：在 `/etc/hosts` 中添加本地域名映射
3. **SSL 证书**：将证书文件放在 `conf/nginx/ssl/` 目录
4. **备份数据**：定期备份 `store/` 目录中的重要数据
5. **日志监控**：使用 `docker compose logs -f` 实时查看日志

---

## 🤝 贡献指南

欢迎提交 Issue 和 Pull Request！

---

## 📄 许可证

本项目遵循 Mulan PSL v2 许可证，详情请查看 [LICENSE](LICENSE) 文件。

---

## 💬 联系与支持

### 📌 重要提示

**本项目为非商用版本，以下情况请联系作者获取支持：**

- 🔧 **扩展编译**：需要安装额外的 PHP 扩展或系统依赖
- 🏗️ **镜像构建**：需要自定义构建 Docker 镜像或修改底层配置
- 💼 **商业授权**：计划将本软件用于商业项目或盈利性服务
- 🛠️ **技术支持**：遇到环境问题、性能优化或定制化需求

### 📮 联系方式

- **Gitee**: [https://gitee.com/jessedev](https://gitee.com/jessedev)
- **Email**: jessdev@163.com

### ⚡ 响应说明

- 一般问题：1-2 个工作日内回复
- 技术支持：根据问题复杂度提供解决方案
- 商业合作：单独沟通授权方式和服务内容

---

## 🙏 致谢

感谢以下开源项目：

- [Docker](https://www.docker.com/)
- [Nginx](https://nginx.org/)
- [MySQL](https://www.mysql.com/)
- [PHP](https://www.php.net/)
- [Redis](https://redis.io/)
- [MongoDB](https://www.mongodb.com/)
- [RabbitMQ](https://www.rabbitmq.com/)
- [Elasticsearch](https://www.elastic.co/elasticsearch/)