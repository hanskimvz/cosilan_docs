#### 显示画面  
<img src="pic.php?code=I16623517840" width="100%"></img>

#### 系统 设置
按 鼠标 右侧按键 弹出 系统设置画面  
<table><tr>
<td width="50%"><img src="pic.php?code=I16623517841"></img></td>
<td valign="top">
	- 数据库服务器 ： 平台运行的 IP 地址 <br />
	- 用户： 数据库(MariaDB 或者Mysql) 用户， 一般 rt_user <br />
	- 密码： 数据库用户密码 <br />
	- charset: utf8 <br />
	- 端口： 数据库 端口， 默认3306 <br />
	- 数据库名称： 计数数据， 数据库名称， 默认 cnt_demo <br />
	- 背景图片： 是否用背景画面， 要选择的话 按URL可以选 <br />
	- 更新间隔： 画面更新时间间隔， 1~5秒 <br />
	- 全屏： 是否用全拼 <br />
	- Template: 画面文件 <br />
</td></tr></table>
  
  
#### 画面文件（Template）
鼠标 左侧按键 双击 弹出 画面设置画面  
#### [文字]
<table><tr><td><img src="pic.php?code=I16623517842"></img></td>
<td>
- 显示：  显示的 内用 <br />
- 字体 ： 字体  <br />
- 字体效果 ： bold, italic, normal 等  <br />
- 颜色 ： 字体 颜色  <br />
- 背景颜色 ： 字体 背景 颜色  <br />
- 宽度/高度 ： 字体箱子的 宽度跟高度  <br />
- Padding ： 字体箱子边跟 内部字体的距离（x, y）  <br />
- 使用 ： 是否 显示  <br />
- X,Y,S ： 位置X， 位置Y， 字体大小S  <br />
</td><td>
name 开始 label~~ 或者 title~~ <br />
<pre>
{
        "color": [ "white", "black"   ],
        "flag": "y",
        "font": [ "simhei",  80, "italic" ],
        "name": "title0",
        "padding": [ 0, 0 ],
        "position": [ 607, 40 ],
        "size": [ 0, 1 ],
        "text": "客流报表"
},
</pre>
</td></tr></table>
<br />

#### [数字]
<table><tr><td><img src="pic.php?code=I16623517845"></img></td>
<td valign="top">
- 字体 ： 字体  <br />
- 字体效果 ： bold, italic, normal 等  <br />
- 颜色 ： 字体 颜色  <br />
- 背景颜色 ： 字体 背景 颜色  <br />
- 宽度/高度 ： 字体箱子的 宽度跟高度  <br />
- Padding ： 字体箱子边跟 内部字体的距离（x, y）  <br />
- 设备： 显示 数据的设备名称， 入显示 全设备合计 选'all' <br />
- 规则： 显示数据的规则** <br />
- 使用 ： 是否 显示  <br />
- X,Y,S ： 位置X， 位置Y， 字体大小S  <br />

** 规则 <br />
用法： [sum/diff/div/percent](datetime:ct_label, datetime:ct_label, ...) <br />
sum:合计
diff: 差异
div: 比率
percent: 百分比
datetime : today, yesterday, thismonth, thisyear<br /><br />
Ex) <br />
sum(today:Entrance, today:Exit) ：显示 今天的Entrance+今天的Exit <br />
sum(today:Entrance, today:Exit, today:Outside, yesterday:Entrance) : 显示 今天的 Entrance+Exit+Ouside+昨天的Entrance) <br />
diff(today:Entrance, today:Exit) : 显示 今天Entrance-今天Exit <br />
div( today:Entrance, yesterday:Entrance): 显示  今天Entrance/昨天Entrance <br />
percent( today:Entrance, yesterday:Entrance): 显示  今天Entrance/昨天Entrance *100<br />
</td>
<td>
name 开始 number~~ <br />
<pre>
{
        "color": [ "red",  "black" ],
        "device_info": "all",
        "flag": "y",
        "font": ["ds-digital", 120, "bold"  ],
        "name": "number3",
        "padding": [ 0, 0 ],
        "position": [ 980, 770  ],
        "rule": "yesterday:entrance",
        "size": [ 8,  1 ]
},
</pre></td></tr></table>
<br />

#### [图片]
<table><tr><td><img src="pic.php?code=I16623517843"></img></td>
<td>
- URL： 显示图片的 径路 <br />
- 宽度/高度 ：图片的 宽度跟高度  <br />
- Padding ： 图片箱子边跟 内部图片的距离（x, y）  <br />
- 使用 ： 是否 显示  <br />
- X,Y ： 位置X， 位置Y<br />
</td><td>
name 开始 picture~~ <br />
<pre>
{
        "flag": "y",
        "name": "picture_D",
        "padding": [ 0,  0 ],
        "position": [ 1300,  42  ],
        "size": [ 320,  180 ],
        "url": "D:\\BACKUP\\Codes\\Cosilan\\bin\\d.png"
},
</pre>
</td></tr></table>
<br />

#### [抓拍]
<table><tr><td><img src="pic.php?code=I16623517844"></img></td>
<td>
- 设备： 显示 抓拍的设备名称 <br />
- 宽度/高度 ：抓拍的 宽度跟高度  <br />
- Padding ：抓拍箱子边跟 内部抓拍的距离（x, y）  <br />
- 使用 ： 是否 显示  <br />
- X,Y ： 位置X， 位置Y<br />
</td><td>
name 开始 snapshot~~ <br />
<pre>
{
        "device_info": "mac=001323A007AD&brand=CAP&model=NS6202HD",
        "flag": "y",
        "name": "snapshot_B",
        "padding": [ 0,  0 ],
        "position": [ 500,  40 ],
        "size": [ 320,  180 ]
},
</pre>
</td></tr></table>
<br />
