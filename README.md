Yii-QA 简介
===========

感谢选择 Yii-QA，基于 [Yii2](https://github.com/yiisoft/yii2) 框架基础实现的问答程序。


环境条件
-------
简而言之：

- >= php5.4

>提示：详细的信息请在参考下个板块安装后，检查`http://localhost/<project-folder>/requirements.php` 页面了解详情。

通过 Composer 安装
----------------

####预备工作:

安装 Composer：下载[安装包(win)](https://getcomposer.org/Composer-Setup.exe)，或访问 [getcomposer.org 官网](http://getcomposer.org)。

####安装 Yii-qa：

开启命令行切换到程序根目录并依次运行以下两条命令：

```console
 composer global require "fxp/composer-asset-plugin:1.0.0-beta3"
 composer create-project --prefer-dist --stability=dev yii2-chinesization/yii-qa yii-qa
```

>注意：如果遭遇到防火墙脑抽，或中国移不动，网不通的时候，可以使用宏大师搭建的墙内 Composer 镜像服务器，地址与使用请点击[Composer Proxy](http://composer-proxy.com/)。或歪果仁制作的商务加速服务[Toran Proxy中文版](http://pkg.phpcomposer.com/)

####额外:

如果你之前没存过的话，此时有可能需要你输入你的 GitHub Username & password。

示例如下：

```console
The credentials will be swapped for an OAuth token stored in C:/Users/qiansen138
6/AppData/Roaming/Composer/auth.json, your password will not be stored
To revoke access to this token you can visit https://github.com/settings/applica
tions
Username: *********
Password:
```

依据网络状况不同，需耗时几分钟到十二亿五千万年……然后就安装完成了包括 Yii2 在内的所有依赖库。

程序本体的安装及初始化
------------

安装步骤如下：
- 【可选项】在您的数据库系统中新建一个数据库
- 重命名 `protected/config/db-default.php` 文件 为 `db.php`，依据您的数据库配置相应地修改该文件。（请确认数据库已存在）
- 打开命令行工具 -> 切换到程序根目录
- 在程序根目录中执行 ``php yii migrate`` 执行数据迁移命令导入数据结构

执行截图如下:

![photo](https://cloud.githubusercontent.com/assets/1625891/4351508/2f1f60bc-420d-11e4-81a9-d2f0afdaed26.png)


注意
------------
产品目前还是处于刚开发阶段.很多都未完善，如果您对Yii2框架有兴趣,可以参考程序代码来学习Yii2。

反馈或贡献代码
------------
您可以在[这里](https://github.com/yii2-chinesization/yii-QA/issues)给我们提出在使用中碰到的问题或Bug。

本项目住持——CallMeZ大神承诺在第一时间回复您并修复。

你也可以发送邮件**callme-z@qq.com**给CallMeZ住持留言并且说明您的问题。

如果你有更好代码实现,请 fork 此项目并发起您的 Pull-Request，我们会及时处理。感谢!

如果你有其他的好想法，也欢迎您加入这两个QQ群: Yii2中国交流群[**343188481**]  Yii2-QA[**325243235**]参与讨论交流。

>额外啰嗦：如果您有关于 Yii2 的推广或视频教程制作方面的点子，欢迎加群或来信qiansen1386@gmail.com。祝搬砖快乐^_^
