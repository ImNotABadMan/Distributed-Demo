#!/bin/sh

start="start"

echo "redis-server "$1""

if [ "start" = $1 ]; then
        /usr/local/bin/redis-server /usr/local/src/redis.conf > /usr/local/src/redis &
        /bin/ps aux | /bin/grep redis
else
        /bin/ps aux| /bin/grep "redis-server \*:6379"
        pid=`/bin/ps aux| /bin/grep "redis-server \*:6379" | /usr/bin/awk '{print $2}'`
        echo '/bin/ps aux| /bin/grep "redis-server \*:6379" | /usr/bin/awk "{print $2}" ::result::' $pid
        if [ $pid > 0 ] ;then
                /bin/ps aux| /bin/grep "redis-server \*:6379" | /usr/bin/awk '{print $2}' | /usr/bin/xargs kill -9
        else
                echo 'redis-server already stop'
        fi
fi


