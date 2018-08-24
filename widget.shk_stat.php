<?php
/*	
	Статистика заказов
	*/

$modx->addPackage('shopkeeper', MODX_CORE_PATH.'components/shopkeeper/model/');

$modx->getService('lexicon','modLexicon');
$modx->lexicon->load($modx->config['manager_language'].':shopkeeper:widget');

$q_where = "`date` + INTERVAL ".date('j')." DAY > NOW()";

//Статистика за текущий месяц

$chunkArr = array(
    'lang' => $modx->config['manager_language'],
    'new_count' => $modx->getCount('SHKorder',array(array('status' => 0),$q_where)),
    'canceled_count' => $modx->getCount('SHKorder',array(array('status' => 4),$q_where)),
    'done_count' => $modx->getCount('SHKorder',array(array('status' => 3),$q_where)),
    'all_count' => $modx->getCount('SHKorder',array($q_where))
);

$current_month = date('n');

//Статистика по месяцам

/*
*/

$stat_month = array();

$sql = "SELECT month(`date`) AS `order_month`, count(*) AS `order_count`
FROM ".$modx->getTableName('SHKorder')."
WHERE year(`date`) = ".date('Y')."
GROUP BY month(`date`)
ORDER BY month(`date`)
LIMIT 24";

//echo $sql; die();

$stmt = $modx->prepare($sql);

if ($stmt && $stmt->execute()) {
    
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$stat_month[] = array("name"=>$modx->lexicon('shk.month'.$row['order_month']),"count"=>$row['order_count']);
    }
    $stmt->closeCursor();
}

$chunkArr['stat_month'] = json_encode($stat_month);

// оборот (месяц, год, всего)

$table = 'sv_shopkeeper_orders';
$current_month = date('n');
$current_year = date('Y');

$sql = "SELECT sum(`price`) FROM `".$table."`
WHERE month(`date`) = '".$current_month."'
AND year(`date`) = '".$current_year."' 
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_month = ceil($row['sum(`price`)']);
	}
}


$sql = "SELECT sum(`price`) FROM `".$table."` 
WHERE `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_total = ceil($row['sum(`price`)']);
	}
}

// 2014 count

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2014'";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_year_2014 = $row['count(*)'];
	}
}

// 2014 count complete

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2014'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_complete_year_2014 = $row['count(*)'];
	}
}

// 2014 revenue

$sql = "SELECT sum(`price`) FROM `".$table."` 
WHERE year(`date`) = '2014'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_year_2014 = ceil($row['sum(`price`)']);
	}
}

// 2015 count

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2015'";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_year_2015 = $row['count(*)'];
	}
}

// 2015 count complete

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2015'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_complete_year_2015 = $row['count(*)'];
	}
}

// 2015 revenue

$sql = "SELECT sum(`price`) FROM `".$table."` 
WHERE year(`date`) = '2015'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_year_2015 = ceil($row['sum(`price`)']);
	}
}

// 2016 count

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2016';";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_year_2016 = $row['count(*)'];
	}
}

// 2016 count complete

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2016'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_complete_year_2016 = $row['count(*)'];
	}
}

// 2016 revenue

$sql = "SELECT sum(`price`) FROM `".$table."` 
WHERE year(`date`) = '2016'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_year_2016 = ceil($row['sum(`price`)']);
	}
}

// 2017 count

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2017';";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_year_2017 = $row['count(*)'];
	}
}

// 2017 count complete

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2017'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_complete_year_2017 = $row['count(*)'];
	}
}

// 2017 revenue

$sql = "SELECT sum(`price`) FROM `".$table."` 
WHERE year(`date`) = '2017'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_year_2017 = ceil($row['sum(`price`)']);
	}
}


// 2018 count

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2018'";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_year_2018 = $row['count(*)'];
	}
}

// 2018 count complete

$sql = "SELECT count(*) FROM `".$table."`
WHERE year(`date`) = '2018'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$count_complete_year_2018 = $row['count(*)'];
	}
}

// 2018 revenue

$current_year = date('Y');

$sql = "SELECT sum(`price`) FROM `".$table."` 
WHERE year(`date`) = '".$current_year."'
AND `status` = 3;";
$query = new xPDOCriteria($modx, $sql);
if ($query->prepare() && $query->stmt->execute()){
$res = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $row){
		$rev_year_2018 = ceil($row['sum(`price`)']);
	}
}




$tpl .= '<table border="1" width="100%" class="shk_stats_table">
<tr>
	<td style="padding:4px;"><strong>ГОД</strong></td>
	<td style="padding:4px;"><strong>КОЛИЧЕСТВО ЗАКАЗОВ</strong></td>
	<td style="padding:4px;"><strong>КОЛИЧЕСТВО ВЫПОЛНЕННЫХ ЗАКАЗОВ</strong></td>
	<td style="padding:4px;"><strong>ОБОРОТ</strong></td>
</tr>
<tr>
	<td style="padding:4px;" colspan="4">
		<br />
	</td>
</tr>
<tr>
	<td style="padding:4px;">
		<strong>2018</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_year_2018.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_complete_year_2018.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$rev_year_2018.' руб.</strong>
	</td>
</tr>
<tr>
	<td style="padding:4px;">
		<strong>2017</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_year_2017.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_complete_year_2017.'</strong>
	</td>	
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$rev_year_2017.' руб. </strong>
	</td>
</tr>
<tr>
	<td style="padding:4px;">
		<strong>2016</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_year_2016.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_complete_year_2016.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$rev_year_2016.' руб. </strong>
	</td>
</tr>
<tr>
	<td style="padding:4px;">
		<strong>2015</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_year_2015.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_complete_year_2015.'</strong>
	</td>	
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$rev_year_2015.' руб. </strong>
	</td>
</tr>
<tr>
	<td style="padding:4px;">
		<strong>2014</strong>
	</td>	
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_year_2014.'</strong>
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$count_complete_year_2014.'</strong>
	</td>	
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$rev_year_2014.' руб. </strong>
	</td>
</tr>
<tr>
	<td style="padding:4px;" colspan="4">		
		<br />
	</td>
</tr>
<tr>
	<td style="padding:4px;">
		<strong>Всего</strong>
	</td>
	<td style="padding:4px;" colspan="2">
	</td>
	<td style="padding:4px;">
		<strong style="font-size: 1.2em;">'.$rev_total.' руб.</strong><br />
	</td>
</tr>
</table>

<br />

&rarr; <a href="/manager/?a=79" target="_blank">Все заказы</a>

&rarr; <a href="/manager/?a=security/user" target="_blank">Пользователи</a>

<br />

';



$chunk = $modx->newObject('modChunk');
$chunk->fromArray(array('name'=>"INLINE-".uniqid(),'snippet'=>$tpl));
$chunk->setCacheable(false);

$output = $chunk->process($chunkArr);

return $output;
?>