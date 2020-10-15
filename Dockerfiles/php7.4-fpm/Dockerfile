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
#    && docker-php-ext-install -j$(nproc) gd \


# 依赖构建好的镜像
#FROM test/fpm
#
#COPY icu/icu4c-52_2-src.tgz /usr/local/src
#chmo
#RUN  docker-php-ext-install pdo_mysql
#
## 安装initl
#RUN apt install -y libicu-dev \
#    && docker-php-ext-install intl


# 依赖构建好的镜像
FROM test/fpm

WORKDIR .

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
RUN sed -e 's/memory_limit = [[:digit:]]*/memory_limit = 64/g' $PHP_INI_DIR/php.ini | grep -E "memory_limit = [[:digit:]]*" \
    && sed -e 's/max_execution_time = [[:digit:]]*/max_execution_time = 600/g' $PHP_INI_DIR/php.ini | grep -E "max_execution_time = [[:digit:]]*" \
RUN sed -i 's/memory_limit = [[:digit:]]*/memory_limit = 64/g' $PHP_INI_DIR/php.ini \
    && sed -i 's/max_execution_time = [[:digit:]]*/max_execution_time = 600/g' $PHP_INI_DIR/php.ini \

# docker build 确定镜像名字




