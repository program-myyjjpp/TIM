<?php

/**
 * PhpStorm
 * 开发时长两年半
 * 2023/12/25
 * 61468384@qq.com
 * 3.0
 * https://gpt.myyjjpp.com
 * 简单即是美 Simple is beautiful...
 **/


$functionname=$strarray[0];
if(!function_exists($functionname)) {
	echo($functionname.' 函数不存在,');
	htmlinput_error($inputarray['from'],$inputarray['id']);
}
$functionname('output',$inputname,$inputvalue);
?>