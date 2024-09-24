<?php


date_default_timezone_set('Asia/Shanghai'); 
ini_set('display_errors','On');
error_reporting(E_ALL);
define('SystemRoot',dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('IncDir',SystemRoot.'config'.DIRECTORY_SEPARATOR);
define('CacheDir',SystemRoot.'runtime'.DIRECTORY_SEPARATOR);
define('SystemDir','/');//网站程序目录,必须以/开始结束
define('SystemDomain','');//网站域名 多个域名用;分隔
define('AdminDir','app');//后台目录
define('UploadDir','uploads');//上传目录
define('TemplateDir','themes/wang-zhan-biao-ti');//模板目录
define('UrlRewrite',1);//启用伪静态,1为开启,0为关闭
define('IndexFile','index.php');//入口文件,无需修改
define('WapOpen',0);//手机访问页面时自动转换为手机版
define('WapDomain','');//手机版域名,访问此域名时自动转换为手机版 多个域名用;分隔
define('DbError',1);//是否显示数据库出错信息
define('MysqlEngine','InnoDB');//mysql默认引擎MyISAM,或InnoDB
define('TableEx','echo_');//表名前缀
define('ArticleTable',TableEx.'article');//默认文章表
define('SiteHash','d969eaca049f84a63222');//站点随机码,防止冲突
define('SiteCache',1);//开启缓存,必须开启缓存
define('TemplateTime',0);//模板缓存时间
define('TemplateStart','{{');//模板开始标签
define('TemplateEnd','}}');//模板结束标签
define('TemplateDebug',0);//模板开启调试
define('IndexCache',0);//首页缓存时间(秒)
define('AdminOpenid',1);//后台开启第三方登录
define('AdminFileedit',1);//后台开启文件修改功能
define('version','1.6');
$site_db = [
    'database' => 'mysqlpdo',
    'host' => '127.0.0.1',
    'dbname' => 'demo',
    'user' => 'demo',
    'password' => 'NsEzsaJ2FJbTY6LG',
];
require(IncDir.'func.php');
if (!defined('NoDb') && !isset($GLOBALS['db'])) {$GLOBALS['db'] = new db();$GLOBALS['db'] -> connect($site_db);}
_stripslashes();