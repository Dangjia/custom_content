<?php
use Cls\Comm;
$ip = Comm::ip();
if(in_array($ip,['127.0.0.1','::1'])){
	$c['host'] = '127.0.0.1';
	$c['db'] = 'aaa';
	$c['cmd'] = "/Library/WebServer/Documents/mongo/";
}else{
	error_reporting(0);
	
	$c['host'] = '127.0.0.1:19843';
	$c['db'] = 'website_qihetaiji';
	$c['cmd'] = "/data/mongodb/bin/";
}




return $c;