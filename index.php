<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');

$appPath  = dirname(__FILE__);
$rootPath = dirname($appPath);


//-- répertoires et chargement des classes
set_include_path($appPath
    . PATH_SEPARATOR . $appPath.'/application/models/'
    . PATH_SEPARATOR . $appPath.'/library/'
    . PATH_SEPARATOR . get_include_path());
require_once "Zend/Loader/Autoloader.php";
Zend_Loader_Autoloader::getInstance();

//-- config
$config = new Zend_Config_Ini($appPath.'/conf/config.ini', 'general');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);
// -- cache
$backOptions  = array();
$frontOptions = array('lifetime' => $config->cache->lifetime,
            'automatic_serialization'=>true);
$cache = Zend_Cache::factory('Core', 'FILE', $frontOptions, $backOptions);
//-- database
try {
	$db = Zend_Db::factory($config->db);
	Zend_Registry::set('dbdefault', $db);
	$db->getConnection();
	Zend_Db_Table::setDefaultAdapter($db);
	Zend_Db_Table::setDefaultMetadataCache($cache);
}
catch (Zend_Exception $ex ) {
	exit($ex);
}

//-- Acl
//$acl     = new AclIni($appPath.'/conf/acl.ini'); //version fichier ini
/*$acl = new AclDb( $config->app->code); // version db
$registry->set('acl', $acl);
//-- menu
//$menu = new Zend_Config_Ini($appPath.'/conf/menu.ini', 'menu'); //version fichier ini
/*$menu = menuini::setDbMenus( '$config->app->code');
$registry->set('menu', $menu);*/

//-- PAGINATOR
Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginer.phtml');
//-- MVC
$vr = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
$vr->setViewScriptPathSpec(":controller/:action.:suffix");
//-- controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
//$frontController->registerPlugin(new BlM_PlugAuth($acl, $config->app->code,$config->db->params->dbname));
$frontController->setControllerDirectory($appPath.'/application/controllers');
Zend_Layout::startMvc(array('layoutPath'=>$appPath.'/application/layouts'));
$frontController->setBaseUrl($config->site->baseurl);
$frontController->dispatch();




/*ini_set('display_errors', '1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');

$appPath  = dirname(__FILE__);
$rootPath = dirname($appPath);

//-- répertoires et chargement des classes
set_include_path($appPath
    . PATH_SEPARATOR . $appPath.'/application/models/'
    . PATH_SEPARATOR . $appPath.'/library/'
    . PATH_SEPARATOR . get_include_path());
require_once "Zend/Loader/Autoloader.php";
$load = Zend_Loader_Autoloader::getInstance();

//-- config
$config = new Zend_Config_Ini($appPath.'/conf/config.ini', 'general');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);
// -- cache
$backOptions  = array();
$frontOptions = array('lifetime' => $config->cache->lifetime,
            'automatic_serialization'=>true);
$cache = Zend_Cache::factory('Core', 'FILE', $frontOptions, $backOptions);
//-- database
try {
	$db = Zend_Db::factory($config->db);
	Zend_Registry::set('dbdefault', $db);
	$db->getConnection();
	Zend_Db_Table::setDefaultAdapter($db);
	Zend_Db_Table::setDefaultMetadataCache($cache);
}
catch (Zend_Exception $ex ) {
	exit($ex);
}

//-- MVC
$vr = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
$vr->setViewScriptPathSpec(":controller/:action.:suffix");
//-- controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->setControllerDirectory($appPath.'/application/controllers');
Zend_Layout::startMvc(array('layoutPath'=>$appPath.'/application/layouts'));
$frontController->setBaseUrl($config->site->baseurl);
$frontController->dispatch();

/* //index.php
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Application.php';

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();*/

/* //application.ini
[production]
phpSettings.display_startup_errors = 0
phpSettings.display_errors = 0
includePaths.library = APPLICATION_PATH "/../library"
bootstrap.path = APPLICATION_PATH "/Bootstrap.php"
bootstrap.class = "Bootstrap"
appnamespace = "Application"
resources.frontController.controllerDirectory = APPLICATION_PATH "/controllers"
resources.frontController.params.displayExceptions = 0
resources.layout.layoutPath = APPLICATION_PATH "/layouts/scripts/"
resources.view[] =

[staging : production]

[testing : production]
phpSettings.display_startup_errors = 1
phpSettings.display_errors = 1

[development : production]
phpSettings.display_startup_errors = 1
phpSettings.display_errors = 1
resources.frontController.params.displayExceptions = 1
 */

/* //.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
 */

?>