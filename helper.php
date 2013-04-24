<?php 
defined('_JEXEC') or die;

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class TSJ_Water_Notice {
		
	public function getParams()
	{
		$params = array();

		$db	=& JFactory::getDBO();
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'water_StartDay';" );
		$row =& $db->loadResult();

		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['water_startday'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'water_StopDay';" );
		$row =& $db->loadResult();

		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['water_stopday'] = $row;
		
	return $params;
	}
	
	function suf_type($day) {
      return ($day%10==1 && $day%100!=11 ? 0 :
      		 ($day%10>=2 && $day%10<=4 && ($day%100<10 || $day%100>=20) ? 1 :
      		 2));
   }
}

?>