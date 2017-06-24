# Missra CMS

## 平台需求
* Windows 平台：
IIS/Apache/Nginx + PHP4/PHP5.2+/PHP5.3+ + MySQL4/5
如果在windows环境中使用，建议用WampServer套件以达到最佳使用性能。

* Linux/Unix 平台
Apache + PHP4/PHP5 + MySQL3/4/5 (PHP必须在非安全模式下运行)

建议使用平台：Linux + Apache2.2 + PHP5.2/PHP5.3 + MySQL5.0

* PHP必须环境或启用的系统函数：
allow_url_fopen
GD扩展库
MySQL扩展库
系统函数 —— phpinfo、dir

* 基本目录结构</br>
/</br>
..../install     安装程序目录，安装完后可删除[安装时必须有可写入权限]</br>
..../admin       默认后台管理目录（可任意改名）</br>
..../include     类库文件目录</br>
..../plus        附助程序目录</br>
..../member      会员目录</br>
..../images      系统默认模板图片存放目录</br>
..../uploads     默认上传目录[必须可写入]</br>
..../a        	 默认HTML文件存放目录[必须可写入]</br>
..../templets    系统默认内核模板目录</br>
..../data        系统缓存或其它可写入数据存放目录[必须可写入]</br>
..../special     专题目录[生成一次专题后可以删除special/index.php，必须可写入]</br>

* PHP环境容易碰到的不兼容性问题
  - data目录没写入权限，导致系统session无法使用，这将导致无法登录管理后台（直接表现为验证码不能正常显示）；
  - php的上传的临时文件夹没设置好或没写入权限，这会导致文件上传的功能无法使用；
  - 出现莫名的错误，如安装时显示空白，这样能是由于系统没装载mysql扩展导致的，对于初级用户，可以下载missra的php套件包，以方便简单的使用。

## 程序安装使用
* 下载程序解压到本地目录;
* 上传程序目录中的/uploads到网站根目录
* 浏览器运行domain/install/index.php (domain表示你的域名),按照安装提速说明进行程序安装
 
## 相关资源
Missra官网	http://www.missra.com/
