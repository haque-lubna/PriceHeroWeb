<?php
 date_default_timezone_set('Asia/Dhaka');
$date = date('m/d/Y    h:i:s a', time());
					$deadline = date('m/d/Y  h:i:s a',strtotime('+3 hour',strtotime($date)));
echo date('m/d/Y h:i:s a', time());
?>
