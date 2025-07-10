# webshell
## 安装 PHP（以 Ubuntu 为例）
sudo apt update\
sudo apt install php php-cli php-mysql php-curl php-zip php-mbstring php-xml unzip -y

## 安装 MySQL
sudo apt install mysql-server -y\
sudo mysql_secure_installation  # 设置 root 密码

## 安装 Composer（PHP 包管理器）
php -r "copy('https://getcomposer.org/installer ', 'composer-setup.php');"\
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e61330cac4133458' ) { echo 'Installer verified'; } else { echo 'Installer corrupt'; \unlink('composer-setup.php'); } echo PHP_EOL;"\
php composer-setup.php\
php -r "unlink('composer-setup.php');"\
sudo mv composer.phar /usr/local/bin/composer

## 安装 Redis（用于任务队列）
sudo apt install redis-server -y
