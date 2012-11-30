<?php
return array(
	 

/* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
    'DB_HOST'               => 'localhost', // 服务器地址
    'DB_NAME'               => 'jianchi',          // 数据库名
    'DB_USER'               => 'root',      // 用户名
    'DB_PWD'                => '13525232487',          // 密码
    'DB_PORT'               => '3306',        // 端口
    'DB_PREFIX'             => 'jc_',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => false,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
	
	
    /* 数据缓存设置 */
    'DATA_CACHE_TIME'       => 1,      // 数据缓存有效期 0表示永久缓存	
	
	
	
    /* Cookie设置 */
    'COOKIE_EXPIRE'         => 0,    // Coodie有效期
    'COOKIE_DOMAIN'         => '',      // Cookie有效域名
    'COOKIE_PATH'           => '/',     // Cookie路径
    'COOKIE_PREFIX'         => '',      // Cookie前缀 避免冲突
	
	
	
	
	
    /* 模板引擎设置 */
    'TMPL_CONTENT_TYPE'     => 'text/html', // 默认模板输出类型
    'TMPL_ACTION_ERROR'     => THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   => THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   => THINK_PATH.'Tpl/think_exception.tpl',// 异常页面的模板文件
    'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
    'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
    'TMPL_FILE_DEPR'        =>  '/', //模板文件MODULE_NAME与ACTION_NAME之间的分割符，只对项目分组部署有效



    /* 错误设置 */
    'ERROR_MESSAGE'         => '页面错误！请稍后再试～',//错误显示信息,非调试模式有效
    'ERROR_PAGE'            => '',	// 错误定向页面
    'SHOW_ERROR_MSG'        => true,    // 显示错误信息

	/*加载公共类库里的 项目扩展类库 extend*/
	'APP_AUTOLOAD_PATH'     => 'Think.Util.,ORG.Util.',// 自动加载机制的自动搜索路径,注意搜索顺序


 	'URL_MODEL'             => 2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
    
	'APP_FILE_CASE'         => true,   // 是否检查文件的大小写 对Windows平台有效

);
?>