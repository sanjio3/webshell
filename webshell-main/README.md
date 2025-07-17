# webshell 
## 下载的准备工作
### 安装 PHP（以 Ubuntu 为例）
sudo apt update\
sudo apt install php php-cli php-mysql php-curl php-zip php-mbstring php-xml unzip -y

### 安装 MySQL
sudo apt install mysql-server -y\
sudo mysql_secure_installation  # 设置 root 密码

### 安装 Composer（PHP 包管理器）
php -r "copy('https://getcomposer.org/installer ', 'composer-setup.php');"\
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e61330cac4133458' ) { echo 'Installer verified'; } else { echo 'Installer corrupt'; \unlink('composer-setup.php'); } echo PHP_EOL;"\
php composer-setup.php\
php -r "unlink('composer-setup.php');"\
sudo mv composer.phar /usr/local/bin/composer

### 安装 Redis（用于任务队列）
sudo apt install redis-server -y

### 建议下载到本地部署，功能有限，见谅

## 使用方法
### 1. 下载项目到本地

### 2. 配置数据库
    1. 在config.php中配置数据库信息
    2. 在数据库中创建一个名为webshell-scanner的数据库
    3. 在数据库中执行database.sql
    （我用的是phpstudy以及MySQLworkbench，所以直接在phpstudy中创建数据库，然后执行sql文件即可）
    （MySQLworkbenc用来检查用的）

### 3. 启动项目
打开网址：
http://localhost/webshell-main/project_root/public/index.php

### 4. 扫描
    1. 将你要扫描的文件打包成一个zip文件
    2. 上传zip文件
    3. 等待扫描完成

## 常见的问题
如果遇到问题，请先检查以下内容：
### 1. composer 安装
    理论上不用，因为我已经配好了其中叫做vendor的文件夹，但是如果你没有，请下载composer，然后在安装时勾选环境变量path

### 2. 跳转到scan.php时数据库连接失败
    1. 检查数据库有没有打开
    2. 检查数据库配置是否正确
    3. 检查数据库有没有被防火墙拦截
检验方法是，用网址方法打开test.php，如果显示“连接成功”，则说明数据库配置正确,而且连接上了

### 3. 权限问题
如果显示 cannot access protected property，将scan.php，和results.php右键->属性，给权限打开

### 4. 路径问题
    1. 检查文件是否在对应的盘符
    2. 检查文件路径是否正确
（不要下载到本地之后就乱放，不然打不开scan.php）
![alt text](问题2.png)

## 注意事项
#### 1. 本项目仅供学习交流使用，请勿用于非法用途
#### 2. 本项目仅用于扫描php文件，而且只能扫描一些简单的webshell，对于一些加密的webshell，本项目无法扫描，说白了就是我比较菜，只能写一些简单的扫描器
#### 3. 所有你上传的东西都会被放在scans文件夹下，当做日志
