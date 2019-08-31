
<p>
<div><?= $detail;?></div>
</p>
<?php
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
$textUrl = '';
if (preg_match($reg_exUrl, $url)) {
    $textUrl = $url;
} 
?>
 