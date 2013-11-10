<?php
// no direct access
defined('_JEXEC') or die;

// Include the whosonline functions only once
require_once dirname(__FILE__).'/helper.php';

// Получим параметры компонента вызвав метод модели getParams
$parametors = TSJ_Water_Notice::getParams();
//print_r($params);

//Подключаем CSS
jimport('joomla.document.html.html');
$document =&JFactory::getDocument();
$link = JURI::root().'modules/mod_tsj_water_notice/tmpl/css/style.css';
//$attribs = array('type' => 'text/css');
$document->addHeadLink(JRoute::_($link), 'stylesheet', 'rel', $attribs);

$linknames = $params->get('linknames', 0);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_tsj_water_notice', $params->get('layout', 'default'));

/*$template = JModuleHelper::getLayoutPath('mod_tsj_notice', $tmpl);
 if (file_exists($template)) {
 require($template);
 } else {
 echo JText::_('ERROR_TEMPLATE');
 }*/
?>