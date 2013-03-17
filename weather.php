require_once('workflows.php');
$w = new Workflows();
$query = {query};
$lang = 'CN';
$country = 'CN';
$api = "d90ac25ff4afbab2";
$url = "http://api.wunderground.com/api/$api/forecast/lang:$lang/q/$country/$query.json";
$res = $w->request( $url );
$res = json_decode( $res );
// $conditions = $res->current_observation;
$forecast = $res->forecast->simpleforecast->forecastday;


if(isset($res->response->error) && $res->response->error->type==='querynotfound') {
  	$w->result( '',
  				'',
			  	'糟糕…', 
			  	'没找到你所查询城市的天气',
			  	'nt_sleet.gif' );

} else {

	foreach($forecast as $f) {
		$w->result( $query,
					$query,
					strip_tags($f->date->weekday.' / '.$f->date->year.'-'.$f->date->month.'-'.$f->date->day),
					ucfirst($query).' ・ '.$f->conditions.' ・ 最高 '.$f->high->celsius.' ℃ ・ 最低 '.$f->low->celsius.' ℃ ・ '.$f->avewind->dir.'风 '.$f->avewind->kph.' km/h'.' ・ 湿度 '.$f->avehumidity.'%',
					$f->icon.'.gif');
	}

}
echo $w->toxml();