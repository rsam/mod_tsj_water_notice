<?php
// no direct access
defined('_JEXEC') or die;
?>

<div id="tsjwaternotice">
<?php
$_suf_days = array('день', 'дня', 'дней');

$today  = date('d');
//$today  = 30;
$full_today = date('Y-m-d');
//$full_today = date('Y-m-d',strtotime("2013-04-30"));
$ym_today = date('Y-m');

//echo 'today='. $full_today . '<br>';
//echo 'startday='. $parametors['water_startday'] . '<br>';
//echo 'stopday='. $parametors['water_stopday'] . '<br>';

// Интервалы в которых сдача показаний не доступна
// Сегодня 4. А сдача с 5 по 10
// Сегодня 4. А сдача с 5 по 2
// Сегодня 4. А сдача с 1 по 2
$fail_water = 0;

if(($today < $parametors['water_startday']) && ($today < $parametors['water_stopday'])){
	/*$startdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_startday']));
	$datetime1 = date_create($startdate);
	$datetime2 = date_create($full_today);
	$interval_water = date_diff($datetime1, $datetime2);*/
	$fail_water = 1;
}
if(($today > $parametors['water_startday']) && ($today > $parametors['water_stopday'])){
	if($parametors['water_startday'] < $parametors['water_stopday']){
		/*$startdate = date('Y-m-d', strtotime("+1 month", strtotime($ym_today.'-'.$parametors['water_startday'])) );
		$datetime1 = date_create($startdate);
		$datetime2 = date_create($full_today);
		$interval_water = date_diff($datetime1, $datetime2);*/
		$fail_water = 1;
	}
}
if(($today < $parametors['water_startday']) && ($today > $parametors['water_stopday'])){
	/*$startdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_startday']));
	$datetime1 = date_create($startdate);
	$datetime2 = date_create($full_today);
	$interval_water = date_diff($datetime1, $datetime2);*/
	$fail_water = 1;
}

$fail_gaz = 0;
if(($today < $parametors['gaz_startday']) && ($today < $parametors['gaz_stopday'])){
	$fail_gaz = 1;
}
if(($today > $parametors['gaz_startday']) && ($today > $parametors['gaz_stopday'])){
	if($parametors['gaz_startday'] < $parametors['gaz_stopday']){
		$fail_gaz = 1;
	}
}
if(($today < $parametors['gaz_startday']) && ($today > $parametors['gaz_stopday'])){
	$fail_gaz = 1;
}

$fail_electro = 0;
if(($today < $parametors['electro_startday']) && ($today < $parametors['electro_stopday'])){
	$fail_electro = 1;
}
if(($today > $parametors['electro_startday']) && ($today > $parametors['electro_stopday'])){
	if($parametors['electro_startday'] < $parametors['electro_stopday']){
		$fail_electro = 1;
	}
}
if(($today < $parametors['electro_startday']) && ($today > $parametors['electro_stopday'])){
	$fail_electro = 1;
}

if($fail_water == 0){
	if($today <= $parametors['water_stopday']){
		// например сегодня 25 число, а конец интервала 28 число
		$stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_stopday']));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);

		if(date('d',$sdt[2]) != date('d',$parametors['water_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_stopday']) + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime1 = date_create($stopdate);
		$datetime2 = date_create($full_today);
		$interval_water = date_diff($datetime1, $datetime2);
		//echo $interval_water->days;
	}
	else{
		// например сегодня 25 число, а конец интервала 20 число
		$stopdate = date('Y-m-d', strtotime("+1 month", strtotime($ym_today.'-'.$parametors['water_stopday']) ));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);
		//if(date('d',$std[2]) != date('d',$parametors['water_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_stopday']) + "+1 month" + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime1 = date_create($stopdate);
		$datetime2 = date_create($full_today);
		$interval_water = date_diff($datetime1, $datetime2);
	}

	if($interval_water->days == 0){
		// сообщение про последний день сдачи
		echo JText::_('MOD_TSJ_WATERS_NOTICE_1').'<br>';
	}else if($interval_water->days > 0){
		if($interval_water->days >= 3){
			// зеленое сообщение
			echo JText::_('MOD_TSJ_WATERS_NOTICE_2').'<span class="green">'. $interval_water->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_water->days)] .'<br></span>';
		}
		else{
			// красное сообщение
			echo JText::_('MOD_TSJ_WATERS_NOTICE_3').'<span class="red">'. $interval_water->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_water->days)] .'<br></span>';
		}
	}
}

if($fail_gaz == 0){
	if($today <= $parametors['gaz_stopday']){
		// например сегодня 25 число, а конец интервала 28 число
		$stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['gaz_stopday']));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);

		if(date('d',$sdt[2]) != date('d',$parametors['gaz_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['gaz_stopday']) + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime_gaz_1 = date_create($stopdate);
		$datetime_gaz_2 = date_create($full_today);
		$interval_gaz = date_diff($datetime_gaz_1, $datetime_gaz_2);
		//echo $interval_gaz->days;
	}
	else{
		// например сегодня 25 число, а конец интервала 20 число
		$stopdate = date('Y-m-d', strtotime("+1 month", strtotime($ym_today.'-'.$parametors['gaz_stopday']) ));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);
		//if(date('d',$std[2]) != date('d',$parametors['gaz_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['gaz_stopday']) + "+1 month" + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime_gaz_1 = date_create($stopdate);
		$datetime_gaz_2 = date_create($full_today);
		$interval_gaz = date_diff($datetime_gaz_1, $datetime_gaz_2);
	}

	if($interval_gaz->days == 0){
		// сообщение про последний день сдачи
		echo JText::_('MOD_TSJ_GAZS_NOTICE_1').'<br>';
	}else if($interval_gaz->days > 0){
		if($interval_gaz->days >= 3){
			// зеленое сообщение
			echo JText::_('MOD_TSJ_GAZS_NOTICE_2').'<span class="green">'. $interval_gaz->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_gaz->days)] .'<br></span>';
		}
		else{
			// красное сообщение
			echo JText::_('MOD_TSJ_GAZS_NOTICE_3').'<span class="red">'. $interval_gaz->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_gaz->days)] .'<br></span>';
		}
	}
}

if($fail_electro == 0){
	if($today <= $parametors['electro_stopday']){
		// например сегодня 25 число, а конец интервала 28 число
		$stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['electro_stopday']));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);

		if(date('d',$sdt[2]) != date('d',$parametors['electro_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['electro_stopday']) + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime1 = date_create($stopdate);
		$datetime2 = date_create($full_today);
		$interval_electro = date_diff($datetime1, $datetime2);
		//echo $interval_electro->days;
	}
	else{
		// например сегодня 25 число, а конец интервала 20 число
		$stopdate = date('Y-m-d', strtotime("+1 month", strtotime($ym_today.'-'.$parametors['electro_stopday']) ));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);
		//if(date('d',$std[2]) != date('d',$parametors['electro_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['electro_stopday']) + "+1 month" + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime1 = date_create($stopdate);
		$datetime2 = date_create($full_today);
		$interval_electro = date_diff($datetime1, $datetime2);
	}

	if($interval_electro->days == 0){
		// сообщение про последний день сдачи
		echo JText::_('MOD_TSJ_ELECTROS_NOTICE_1').'<br>';
	}else if($interval_electro->days > 0){
		if($interval_electro->days >= 3){
			// зеленое сообщение
			echo JText::_('MOD_TSJ_ELECTROS_NOTICE_2').'<span class="green">'. $interval_electro->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_electro->days)] .'<br></span>';
		}
		else{
			// красное сообщение
			echo JText::_('MOD_TSJ_ELECTROS_NOTICE_3').'<span class="red">'. $interval_electro->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_electro->days)] .'<br></span>';
		}
	}
}

if($fail_water != 0){
	echo JText::_('MOD_TSJ_WATERS_NOTICE_4').'<br>'; //'Сегодня ввод показаний счетчиков недоступен';
	echo 'До начала сдачи показаний счетчиков воды : '.$interval_water->days.' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_water->days)];
}

if($fail_gaz != 0){
	echo JText::_('MOD_TSJ_GAZS_NOTICE_4').'<br>'; //'Сегодня ввод показаний счетчиков недоступен';
	echo 'До начала сдачи показаний счетчиков газа : '.$interval_gaz->days.' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_gaz->days)];
}

if($fail_electro != 0){
	echo JText::_('MOD_TSJ_ELECTROS_NOTICE_4').'<br>'; //'Сегодня ввод показаний счетчиков недоступен';
	echo 'До начала сдачи показаний счетчиков электроэнергии : '.$interval_electro->days.' '. $_suf_days[TSJ_Water_Notice::suf_type($interval_electro->days)];
}

?>
</div>
