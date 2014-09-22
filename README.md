Yii-QA
======

感谢选择 Yii-QA, 基于[Yii2](https://github.com/yiisoft/yii2)框架基础实现的问答程序.


环境条件
------------
- >= php5.4
- Yii2 

安装 Composer
============

###step 0:

安装 Composer：下载[安装包(win)](https://getcomposer.org/Composer-Setup.exe), 或访问 [getcomposer.org 官网](http://getcomposer.org)。

###step 1:

开启命令行，运行：
```
 composer global require "fxp/composer-asset-plugin:1.0.*@dev"
```

###step 2:
命令行切换到程序根目录并运行
```
 composer install
```

100 thousands years passed.... 十万年之后……

###step 3:

注意哦，你有可能需要输入GitHub Username & password，如果你之前没存过的话。
```console
The credentials will be swapped for an OAuth token stored in C:/Users/qiansen138
6/AppData/Roaming/Composer/auth.json, your password will not be stored
To revoke access to this token you can visit https://github.com/settings/applica
tions
Username: *********
Password:
```

###依据提示，输入信息(Follow the instruction)

程序初始化
------------
本程序基于命令行安装:
- 编辑 ``protected/config/db.php'文件, 填入您的数据库配置, 请确认数据库存在.
- 打开命令行工具 -> 切换到程序根目录.
- 在程序根目录中执行 ``php yii migrate`` 执行数据迁移命令导入数据结构

执行截图如下:

![photo](https://cloud.githubusercontent.com/assets/1625891/4351508/2f1f60bc-420d-11e4-81a9-d2f0afdaed26.png)


注意
------------
产品目前还是处于刚开发阶段.很多都未完善, 如果您对Yii2框架有兴趣,可以参考程序代码来学习Yii2.



反馈或贡献代码
------------
您可以在[这里](https://github.com/yii2-chinesization/yii-QA/issues)给我提出在使用中碰到的问题或Bug.

我会在第一时间回复您并修复.

你也可以加QQ群: Yii2中国交流群[**343188481**]  Yii2-QA[**325243235**]参与讨论交流.

或者发送邮件**callme-z@qq.com**给我并且说明您的问题. 

如果你有更好代码实现,请fork项目并发起您的pull request.我会及时处理. 感谢!
