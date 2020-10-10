# 使用官方已经构建好的php-fpm源，再加自己要的扩展等
FROM php:7.4-fpm

# apt镜像加速
#COPY sources.list /etc/apt
#RUN apt-key adv --recv-keys --keyserver mirrors.aliyun.com/ubuntu 40976EAF437D05B5 && \
#    apt-key adv --recv-keys --keyserver mirrors.aliyun.com/ubuntu 3B4FE6ACC0B21F32 && \
#    curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -
RUN apt update
