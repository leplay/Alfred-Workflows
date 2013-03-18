require_once('workflows.php');
$w = new Workflows();
$query = {query};
$api = "Acukf2CoHeV4HYGAjtwU";
$url = "http://pm25.in/api/querys/pm2_5.json?token=Acukf2CoHeV4HYGAjtwU&city=$query";
$res = $w->request( $url );
$res = json_decode( $res );

$aqi = $res;

if(isset($res->error)) {
  	$w->result( '',
  				'',
			  	'糟糕…', 
			  	'没找到你所查询城市的空气污染指数',
			  	'sorry.png' );

} else {

	foreach($aqi as $q) {
		if(!$q->position_name) {
			continue;
		}
		$icon = $q->aqi < 300 ? floor($q->aqi/50) : 5; 
		$w->result( $query,
					$query,
					strip_tags('AQI: '.$q->aqi),
					$q->position_name.'监测站 ・ PM2.5: '.$q->pm2_5.' ・ 主要污染物：'.$q->primary_pollutant,
					$icon.'.png');
	}

}
echo $w->toxml();
