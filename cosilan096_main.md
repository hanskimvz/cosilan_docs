### 安装Cosilan 主程序版教程
1. [下载](http://49.235.119.5/download.php?file=cosilan096Beta.zip) : http://49.235.119.5/download.php?file=cosilan096Beta.zip
2. 点击 update.bat  
![](images/I16568479940.png)   
![](images/I16568479941.png)

3. 选择 数据库软件， 输入 数据库root密码
	** 如没有安装的数据库软件 数据库不出来  
![](images/I16568479942.png)

4. 密码 错， 显示 FAIL on MariaDB, root password is not correct!!  
![](images/I16568479943.png)

5. 点击 Start  
![](images/I16568479944.png)

6. 完了，点击 cancel  
![](images/I16568479945.png)

7. 再运行 MariaDB，Windows + R , 输入 services.msc  
![](images/I16568479946.png)

8. 查找 MariaDB, 打开  
![](images/I16568479947.png)

9. 点击 “Stop”, 等关掉 点击 “Start”  
![](images/I16568479948.png)

10. 为了 系统重启时候 自动 运行数据库Startup type “Automatic”, 点击 Apply