# Docker LNMP Development Environment

A modern LNMP (Linux, Nginx, MySQL, PHP) development environment built with Docker, supporting multiple PHP versions, various databases and middleware, providing an out-of-the-box local development experience.

## ✨ Features

- 🚀 **Quick Deployment**: One-click startup of complete development environment
- 🔄 **Multi-Version Support**: PHP 7.4 / 8.0 / 8.1 / 8.2 with Swoole extension
- 📦 **Rich Components**: MySQL, MongoDB, Redis, RabbitMQ, Elasticsearch, Nacos
- 🔧 **Flexible Configuration**: Easily customize service parameters via environment variables
- 💾 **Data Persistence**: All data directories automatically mounted to host
- 🌐 **Multi-Project Support**: Run multiple web projects simultaneously

---

## 📋 System Requirements

- Docker >= 20.10
- Docker Compose >= 2.0
- macOS / Linux / Windows (WSL2)

---

## 🚀 Quick Start

### 1. Clone Repository

```bash
git clone https://gitee.com/jessedev/docker-lnmp.git
cd docker-lnmp
```

### 2. Initialize Configuration

```bash
# Copy environment configuration file
cp .env.example .env

# Copy Docker Compose configuration file
cp docker-compose-example.yml docker-compose.yml
```

### 3. Start Services

```bash
# Build and start all services
docker compose up -d

# Check service status
docker compose ps
```

### 4. Verify Installation

Visit the following URLs to confirm services are running properly:

- Nginx: http://localhost
- PHPInfo: http://localhost/demo/phpinfo.php

---

## 🛠️ Service Management

### Common Commands

```bash
# Start services
docker compose up -d

# Stop services
docker compose down

# Restart specific service
docker compose restart nginx

# View logs
docker compose logs -f nginx

# Enter container
docker exec -it jesse-nginx-service /bin/bash

# Check service status
docker compose ps
```

---

## 📊 Service Components

### Web Server

#### Nginx
- **Ports**: 80 (HTTP), 443 (HTTPS)
- **Configuration**: `conf/nginx/conf/nginx.conf`
- **Site Configs**: `conf/nginx/conf/conf.d/`
- **Log Directory**: `log/nginx/log/`
- **Web Root**: `www/`

### Databases

#### MySQL 8.0
- **Port**: 3306
- **Default User**: root (no password)
- **Data Storage**: `store/mysql/data/`
- **Configuration**: `conf/mysql/my.cnf`

**Change root password:**

```bash
# Enter container
docker exec -it jesse-mysql8.0-service mysql -uroot -p

# Execute SQL
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'a123456';
CREATE USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'a123456';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';
FLUSH PRIVILEGES;
```

#### MongoDB
- **Port**: 27017
- **Data Storage**: `store/mongodb/data/`
- **Configuration**: `conf/mongodb/mongod.conf`

**Create admin account:**

```bash
# Enter MongoDB Shell
docker exec -it jesse-mongodb-service mongosh admin

# Create user
db.createUser({ 
  user: 'root', 
  pwd: 'a123456', 
  roles: [ 
    { role: 'userAdminAnyDatabase', db: 'admin' }, 
    'readWriteAnyDatabase'
  ] 
});

# Verify
db.auth("root", "a123456");
```

#### Redis
- **Port**: 6379
- **Data Storage**: `store/redis/`
- **Configuration**: `conf/redis/redis.conf`

### Message Queue

#### RabbitMQ
- **Management UI**: http://localhost:15672
- **AMQP Port**: 5672
- **Default Credentials**: guest / guest
- **Data Storage**: `store/rabbitmq/data/`

**Create admin user:**

```bash
docker exec -it jesse-rabbitmq-service rabbitmqctl add_user admin a123456
docker exec -it jesse-rabbitmq-service rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"
docker exec -it jesse-rabbitmq-service rabbitmqctl set_user_tags admin administrator
```

### Search Engine

#### Elasticsearch
- **Port**: 9200
- **Data Storage**: `store/elasticsearch/data/`
- **Configuration**: `conf/elasticsearch/elasticsearch.yml`
- **Log Directory**: `log/elasticsearch/`

**Initialize passwords:**

```bash
# Enter container
docker exec -it jesse-elasticsearch-service /bin/bash

# Set passwords (recommended: a123456)
elasticsearch-setup-passwords interactive
```

#### Kibana
- **URL**: http://localhost:5601
- **Configuration**: `conf/kibana/kibana.yml`
- **Log Directory**: `log/kibana/`

### Service Governance

#### Nacos
- **URL**: http://localhost:8848/nacos
- **Default Credentials**: nacos / nacos
- **Configuration**: `conf/nacos/custom.properties`
- **Log Directory**: `log/nacos/`

**Initialize Database:**

⚠️ **Important**: You must initialize the database before using Nacos.

```bash
# 1. Enter MySQL container
docker exec -it jesse-mysql8.0-service mysql -uroot -p

# 2. Create database
CREATE DATABASE IF NOT EXISTS `nacos2.2.3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

# 3. Exit MySQL
exit;

# 4. Import SQL script
docker exec -i jesse-mysql8.0-service mysql -uroot -p nacos2.2.3 < init/nacos/mysql/mysql-schema.sql
# Enter password and wait for import to complete

# 5. Verify tables
docker exec -it jesse-mysql8.0-service mysql -uroot -p nacos2.2.3 -e "SHOW TABLES;"
```

### PHP Runtime

Supported versions (enable as needed in `docker-compose.yml`):

- **PHP 7.4**: `jesse-php7.4-service`
- **PHP 8.0**: `jesse-php8.0-service`
- **PHP 8.1**: `jesse-php8.1-service`
- **PHP 8.2**: `jesse-php8.2-service`
- **Swoole Versions**: All PHP versions include Swoole extension support

**Configuration Locations**:
- PHP Config: `conf/php*/conf.d/`
- PHP-FPM Config: `conf/php*/php-fpm.d/`
- Log Directory: `log/php*/`

---

## 📁 Project Structure

```
docker-lnmp/
├── conf/                   # Service configuration files
│   ├── nginx/             # Nginx configuration
│   ├── mysql/             # MySQL configuration
│   ├── php*/              # PHP configuration
│   └── ...                # Other service configurations
├── www/                    # Web root directory
│   ├── project1/          # Project 1
│   ├── project2/          # Project 2
│   └── test.php           # Test file
├── store/                  # Data persistence directory
│   ├── mysql/             # MySQL data
│   ├── mongodb/           # MongoDB data
│   ├── redis/             # Redis data
│   └── ...                # Other service data
├── log/                    # Log directory
│   ├── nginx/             # Nginx logs
│   ├── mysql/             # MySQL logs
│   └── ...                # Other service logs
├── docker-compose.yml      # Docker Compose configuration
├── .env                    # Environment variables
└── README.md               # Project documentation
```

---

## ⚙️ Configuration

### Environment Variables (.env)

Main configuration items:

```bash
# Project path
WEB_ROOT_PATH=./www

# Nginx configuration
NGINX_PORT=80

# MySQL configuration
MYSQL_ROOT_PASSWORD=a123456
MYSQL_PORT=3306

# Redis configuration
REDIS_PORT=6379

# MongoDB configuration
MONGODB_PORT=27017

# RabbitMQ configuration
RABBITMQ_HTTP_PORT=15672
RABBITMQ_AMQP_PORT=5672

# Elasticsearch configuration
ES_HTTP_PORT=9200

# Kibana configuration
KIBANA_PORT=5601

# Nacos configuration
NACOS_PORT=8848
```

### Nginx Site Configuration

Create site configuration files in `conf/nginx/conf/conf.d/` directory:

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

## 🔧 Troubleshooting

### 1. Port Conflicts

If ports are occupied, modify port configuration in `.env` file:

```bash
NGINX_HTTP_PORT=8080
MYSQL_PORT=3307
```

### 2. Permission Issues

Ensure data directories have correct permissions:

```bash
chmod -R 777 store/ log/
```

### 3. Missing PHP Extensions

⚠️ **Note**: This project does not provide source code building functionality. If you need to add PHP extensions or customize images, please contact the author for technical support.

**Contact**:
- Gitee: https://gitee.com/jessedev
- Email: jessdev@163.com

### 4. Clean Data

⚠️ **WARNING**: This operation will delete all persisted data!

```bash
docker compose down -v
rm -rf store/* log/*
```

---

## 📝 Development Tips

1. **Code Storage**: Place all project code in the `www/` directory
2. **Domain Configuration**: Add local domain mappings in `/etc/hosts`
3. **SSL Certificates**: Place certificate files in `conf/nginx/ssl/` directory
4. **Data Backup**: Regularly backup important data in `store/` directory
5. **Log Monitoring**: Use `docker compose logs -f` to view logs in real-time

---

## 🤝 Contributing

Issues and Pull Requests are welcome!

---

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

Thanks to the following open source projects:

- [Docker](https://www.docker.com/)
- [Nginx](https://nginx.org/)
- [MySQL](https://www.mysql.com/)
- [PHP](https://www.php.net/)
- [Redis](https://redis.io/)
- [MongoDB](https://www.mongodb.com/)
- [RabbitMQ](https://www.rabbitmq.com/)
- [Elasticsearch](https://www.elastic.co/elasticsearch/)