## Cosilan 网页 指南- 用户

### 一、登录客流管理平台

1）打开浏览器，输入软件所安装的电脑的IP地址，即托管服务器IP地址。
![](images/I16625714910.jpeg)

2） 输入用户名和密码。	默认账号（初始用户名）：root	初始密码：rootpass
![](images/I16625714911.jpeg)

### 二、用户账号注册
#### 新用户注册
在登陆页面点击用户注册。	本地部署客流管理平台和公有云部署客流管理平台用户注册步骤一致。  
![](images/I16625714912.jpeg)

输入子账号名称、电子邮箱、密码，点击开通账号。  
![](images/I16625714913.jpeg) ![](images/I16625714914.jpeg)

#### 账号授权
退出用户注册页面，用管理员账号登录客流管理平台进行受权。  
1. 点击右上角管理员，再点击“管理者项目”  
![](images/I16625714915.jpeg)

2. 点击“用户”，在“无位账号”里点击刚刚创建的子账号
![](images/I16625714916.jpeg)

3. 用户账号受权
![](images/I16625714917.jpeg)

### 三、广场和店铺是商业中心的基本分层结构。
用管理员账号登录客流管理平台，点击右上角管理员，再点击“管理者项目”，进入管理页面。  
![](images/I16622668260.jpeg)

### 添加广场
1. 点击“设备树”，再点击设备树右侧“…”弹出“添加广场”，点击“添加广场”创建新广场。  
![](images/I16622668261.jpeg)  

2. 填写广场信息  
![](images/I16622668262.jpeg)  

3. 添加广场完成  
![](images/I16622668263.jpeg)  

### 添加店铺
1. 添加店铺： 点击刚刚添加的广场右侧的“…”添加店铺。  
![](images/I16622668264.jpeg)  

2. 完善店铺信息：填写新添加的店铺名称、电话、联系人、地址等信息。  
![](images/I16622668265.jpeg)  
3. 添加店铺完成  
![](images/I16622668266.jpeg)  

### 删除店铺和广场
删除店铺和广场需要最高权限，即root账户权限。  
删除店铺, 点击需要删除的店铺  
![](images/I16622668267.jpeg)  
![](images/I16622668268.jpeg)  

### 删除广场
点击需要删除的店铺  
![](images/I16622668269.jpeg)  


### 四、客流管理平台管理客流设备
#### 平台连接客流像机
<p><strong style="color: rgb(255, 153, 0);">
注：用托管服务的话， 在添加客流像机之前，客流像机的TLSS(托管服务) 和计数功能、计数报表功能要先设置好，设置步骤详见《<a href="/help/view_markdown.php?pk=37" target="_blank" style="color: rgb(255, 0, 0);">云平台摄像机终端配置指南</a>》。</strong></p>

每个客流像机都有一个唯一的USN码（序列号）。在客流像机里设置好TLSS(托管服务) 和计数功能、计数报表功能以后，通过客流像机的USN码在客流管理平台可以查看该像机是否已正常上线。  
步骤如下：

1. 进入管理页面
用管理员账号登录客流管理平台，点击右上角管理员，再点击“管理者项目”，进入管理页面。  
![](images/I16625277470.jpeg)

2. 进入数据库
> 点击数据库里的“parameter”参数，可以查看客流像机是否上线，有初次上线时间、最近访问时间和状态等信息。状态为绿色表示像机工作正常，平台访问客流像机的数据正常。  
![](images/I16625277471.jpeg)

#### 添加客流像机
客流像机须添加到店铺下面， 店铺的名称可以自定义修改。  
1. 添加客流像机
点击店铺右侧“…”，弹出“添加设备”，再点击“添加设备”添加客流像机。  
![](images/I16625277472.jpeg)
![](images/I16625277473.jpeg)  
![](images/I16625277474.jpeg)

2. 完善客流像机信息并启用相应功能
点击新添加的客流像机进入客流像机功能启用界面，勾选并启用相应的功能、设置计数器标签（请注意计数器出、入方向不要弄反）  
![](images/I16625277475.jpeg)

#### 删除客流像机
删除客流像机，点删除后选择管理员账户，然后点击“确认删除”。  
![](images/I16625277476.jpeg)