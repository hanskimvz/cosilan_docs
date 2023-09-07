## 开发 计数平台 考虑事项

### 参考事项。
#### 定义：  
  - server（服务器） : 装平台软件的电脑 或者服务器  
  - device （设备）： 计数设备， 计数专用摄像机

#### 考虑事项：
1. 设备跟服务器在同一个局域网里面？ 就 服务器可以查到设备， 或者直接通讯？
2. 读取设备的计数报表？
3. 用设备的 推送功能， 接收设备的实时客流事件信息？
 
##### 情况1： 服务器在公网， 设备在局域网， 采用设备报表功能。
用 托管服务功能， 参考 文档 [托管服务](ts_tlss_setting.md)

##### 情况2：服务器在公网或者局域网， 设备在局域网， 采用 实时计数事件推送功能
用 TCP 或者 HTTP 计数推送， 参考文档 [计数事件推送(TCP)](ts_tcp_push.md) & [计数事件推送(HTTP)](ts_http_push.md) 

#### 情况3： 设备跟服务器在一个局域网， 用设备的报表功能
用 报表功能， 参考文档 [云平台摄像机终端配置指南(TLSS)](ts_tlss_device.md)
	
使用 API《设备跟服务器在一个局域网里面可用， 或者 用托管服务环境下可用》
- http://{Device IP}/uapi-cgi/param.fcgi   : 可读取设备的所有的参数， 可以指定 group
- http://{Device IP}/uapi-cgi/param.fcgi?action=list&group=VCA.Ch0.ct*   : 读取 计数器的信息
- http://{Device IP}/cgi-bin/operator/countreport.cgi : 读取计数报表信息
- http://{Device IP}/nvc-cgi/operator/snapshot.fcgi: 读取抓拍画面
	