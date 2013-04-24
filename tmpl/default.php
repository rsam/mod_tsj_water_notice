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
$fail = 0;

if(($today < $parametors['water_startday']) && ($today < $parametors['water_stopday'])){
	$startdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_startday']));
	$datetime1 = date_create($startdate);
	$datetime2 = date_create($full_today);
	$interval = date_diff($datetime1, $datetime2);
	$fail = 1;
}
if(($today > $parametors['water_startday']) && ($today > $parametors['water_stopday'])){
	if($parametors['water_startday'] < $parametors['water_stopday']){
		$startdate = date('Y-m-d', strtotime("+1 month", strtotime($ym_today.'-'.$parametors['water_startday'])) );
		$datetime1 = date_create($startdate);
		$datetime2 = date_create($full_today);
		$interval = date_diff($datetime1, $datetime2);
		$fail = 1;
	}
}
if(($today < $parametors['water_startday']) && ($today > $parametors['water_stopday'])){
	$startdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_startday']));
	$datetime1 = date_create($startdate);
	$datetime2 = date_create($full_today);
	$interval = date_diff($datetime1, $datetime2);
	$fail = 1;
}

if($fail == 0){
	if($today <= $parametors['water_stopday']){
		// например сегодня 25 число, а конец интервала 28 число
		$stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_stopday']));

		// Поправка в случае если в месяце меньше дней чем число указанное в настройках
		$std = explode('-', $stopdate);

		if(date('d',$sdt[2]) != date('d',$parametors['water_stopday'])) $stopdate = date('Y-m-d', strtotime($ym_today.'-'.$parametors['water_stopday']) + "-1 day");

		//echo 'stopdate='. $stopdate . '<br>';

		$datetime1 = date_create($stopdate);
		$datetime2 = date_create($full_today);
		$interval = date_diff($datetime1, $datetime2);
		//echo $interval->days;
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
		$interval = date_diff($datetime1, $datetime2);
	}

	if($interval->days == 0){
		echo JText::_('MOD_TSJ_WATERS_NOTICE_1');// 'Сегодня<br><span class="red">последний</span><br>день сдачи показаний счетчиков воды в текущем периоде.';
	}else if($interval->days > 0){
		if($interval->days >= 3){
			echo JText::_('MOD_TSJ_WATERS_NOTICE_2').'<span class="green">'. $interval->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval->days)] .'</span>';
		}
		else{
			echo JText::_('MOD_TSJ_WATERS_NOTICE_3').'<span class="red">'. $interval->days .' '. $_suf_days[TSJ_Water_Notice::suf_type($interval->days)] .'</span>';
		}
	}
}
else{
	echo JText::_('MOD_TSJ_WATERS_NOTICE_4').'<br>'; //'Сегодня ввод показаний счетчиков недоступен';
	echo 'До начала сдачи показаний счетчиков : '.$interval->days.' '. $_suf_days[TSJ_Water_Notice::suf_type($interval->days)];
}

?>
</div>
