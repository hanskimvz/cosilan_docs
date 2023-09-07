## IPN Datetime CGI

* 时间 同步 用 时间服务器(NTP)
```code
/uapi-cgi/param.fcgi?action=update&group=SYSTEM.Datetime&syncsource=ntp
```

*  每天 同步 时间， 默认是开机的时候 同步一次。
```code 
/uapi-cgi/param.fcgi?action=update&group=SYSTEM.Datetime&syncinterval=everyday
```

* 时间区域 变更 中国 时间
```code 
/uapi-cgi/param.fcgi?action=update&group=SYSTEM.Datetime.Tz&name=Hong_Kong&posixrule=HKT-8
```

* <span style="color: rgb(230, 0, 0);">变更 时间服务器参数， 不发 这个命令 时间区域 无效</span>
```code 
/nvc-cgi/admin/timezone.cgi?action=set"
```

* 设备跟时间服务器 同步命令 （ sync now）
```code 
nvc-cgi/admin/param.fcgi?action=update&group=System.DateTime&syncnow=ntp
```
