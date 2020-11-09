# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: 开机初始化网卡
# Description:       开机初始化网卡 ifconfig
### END INIT INFO

# crontab
#* */1 * * * /etc/init.d/ifconfig-init.sh >> /var/log/crontab.log 2>&1
# 开机测试显示网卡 ifconfig


date=`/bin/date`

netConfig=`/sbin/ifconfig ens32`

echo $date

echo $date >> /var/log/crontab.log

echo $netConfig

echo $netConfig >> /var/log/crontab.log


if /sbin/ifconfig ens32 | grep '192.168' > /dev/null; then

        echo "Not Need To Init route and ip, depend systemd start"

else
        #/sbin/ifconfig ens32 192.168.10.113 netmask 255.255.240.0

        #/sbin/route add default gw 192.168.0.1

        /sbin/ifconfig ens32

        echo "CMD"
        echo "/sbin/ifconfig ens32 192.168.10.113 netmask 255.255.240.0"
        echo "/sbin/route add default gw 192.168.0.1"
fi
