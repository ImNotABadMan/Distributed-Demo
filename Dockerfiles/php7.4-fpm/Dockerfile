# base/fpm7.4:latest 是自己使用官方已经构建好的php-fpm源，再加自己要的扩展等

#FROM base/fpm7.4:latest

#COPY icu-release-67-1.tar.gz /usr/local/src

#COPY sources.list /etc/apt/sources.list.ubuntu


# 使用ubuntu镜像
#RUN cat /etc/apt/sources.list.ubuntu >> /etc/apt/sources.list
#RUN apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 3B4FE6ACC0B21F32 && apt update

#RUN apt install -y \
#    libfreetype6-dev \chm
#    libjpeg62-turbo-dev \
#    libpng-dev \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install -j$(nproc) gd


# 依赖构建好的镜像
# test/fpm:latest 依赖base/fpm7.4 增加依赖
#FROM test/fpm
#
#COPY icu/icu4c-52_2-src.tgz /usr/local/src
#chmo
#RUN  docker-php-ext-install pdo_mysql
#
## 安装initl
#RUN apt install -y libicu-dev \
#    && docker-php-ext-install intl

#FROM test/fpm
#
#RUN docker-php-ext-install mysqli



# 依赖构建好的镜像
FROM mysql/fpm7.4

# 定义Dockerfile运行的工作目录，/开头才重新刷新使用绝对路径
#WORKDIR .

ENV APP_ROOT=/var/www/html

# 用于docker-compose 运行赋值的变量 args
#ARG app_root

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini \
    && mkdir -p /etc/glpi && chmod 777 /etc/glpi

RUN sed -e 's/memory_limit = [[:digit:]]*/memory_limit = 64/g' $PHP_INI_DIR/php.ini | grep -E "memory_limit = [[:digit:]]*" \
    && sed -e 's/max_execution_time = [[:digit:]]*/max_execution_time = 600/g' $PHP_INI_DIR/php.ini | grep -E "max_execution_time = [[:digit:]]*"\
    && sed -i 's/memory_limit = [[:digit:]]*/memory_limit = 64/g' $PHP_INI_DIR/php.ini \
    && sed -i 's/max_execution_time = [[:digit:]]*/max_execution_time = 600/g' $PHP_INI_DIR/php.ini


# 运行在基于上一层的这一层镜像中
RUN /bin/bash -c 'mkdir /var/test'

# 动态，依赖docker-compose执行
#RUN chmod -R 777 $app_root/config && chmod -R 777 $app_root/files

EXPOSE 9000

# 挂载目录无法再Dockerfile中使用
#CMD "chmod -R 777 $APP_ROOT/config && chmod -R 777 $AOO_ROOT/files && php-fpm"

# docker build -t 确定镜像名字 .




