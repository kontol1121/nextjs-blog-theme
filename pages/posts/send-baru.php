<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-M-d');
$day = date('D', strtotime($tanggal));
$dayList = array('Sun' => 'minggu','Mon' => 'senin','Tue' => 'selasa','Wed' => 'rabu','Thu' => 'kamis','Fri' => 'jumat','Sat' => 'sabtu');
$Waktu = time();
$Jam = date("G",$Waktu);
if ($Jam>=5 && $Jam<=10)
{
$ucapan = "pagi";
}
elseif ($Jam >=11 && $Jam<=14)
{
$ucapan = "siang ";
}
elseif ($Jam>=15 && $Jam<=17)
{
$ucapan = "sore ";
}
elseif ($Jam >=18 && $Jam<=23)
{
$ucapan = "malam";
}
elseif ($Jam >=24 && $Jam<=4)
{
$ucapan = "dini hari";
}
//pengaturan tanggal

function sendMessage($chatID, $messaggio, $token) {
$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
$url = $url . "&text=" . urlencode($messaggio);
$ch = curl_init();
$optArray = array(
CURLOPT_URL => $url,
CURLOPT_RETURNTRANSFER => true);
curl_setopt_array($ch, $optArray);
$result = curl_exec($ch);
curl_close($ch);
return $result;
}
//Batas function auto send telegram

function bacaURL($url){
$session = curl_init(); 
curl_setopt($session, CURLOPT_URL, $url);
curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
$hasil = curl_exec($session);
curl_close($session);
return $hasil;
}
$link = 'https://eztekno.com/satu-post-saja/';
//get link
$sumbersize =  bacaURL($link);
$splitsize = explode('<h2 class="post-title"><a href="', $sumbersize);
$splitLagisize = explode('">', $splitsize[1]);
$linknya = $splitLagisize[0];
//get judul
$splitver = explode('<a aria-label="', $sumbersize);
$splitLagiver = explode('"', $splitver[1]);
$judulnya = $splitLagiver[0];

$pesan = $judulnya."\n".$linknya;
$token = "1005291650:AAGv3Sn1CLmcdX86tk0ps34gZItLG-l68bA";
$chatid = "@eztekno";
sendMessage($chatid, $pesan, $token);
//Batas konfigurasi telegram

$consumerKey    = '3WFtexcaLSiNyTg2bfhR3AphA';
$consumerSecret = 'vVfA9muOvuADxXC76eFyolym6iGvMYYFZKOg7nmJvslMWleZnG';
$oAuthToken     = '1570770624-K5QsWHysIRNgi9NvxJLh8bLNl2aMYREOgnWR5sE';
$oAuthSecret    = 'DazJDWJBWtY6UhbxtUWxuSKBWxyFnugluuYS0LmVYjhq4'; 
require_once('twitteroauth/twitteroauth.php');
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
//Batas konfigurasi twitter

$NumberOfTags=1; 
$GeoLocleID="23424846";
$statues = $tweet->get("trends/place", ["id" => $GeoLocleID]);
$stringgerr="";
$i=1;
foreach($statues as $hash){
$inner=$hash->trends;
foreach($inner as $in)
{
$stringgerr =$in->name;
if($i==$NumberOfTags)
break;
$i++;
}
if($i==$NumberOfTags)
break;
}
//Mengambil trending indonesia

//setup
$twit = 'Sekarang hari '.$dayList[$day].' jam '.$Jam.' '.$ucapan.' sedang trending '.$stringgerr. "\n".$judulnya.' '.$linknya;
$t = $tweet->post('statuses/update', array('status' => $twit));
file_put_contents("logs.ini", $judulnya." - ".$stringgerr."\n", FILE_APPEND);
curl_close ($ch);
//Membuat laporan ndan

?> 