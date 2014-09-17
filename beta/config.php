<?php
//Այստեղ կդնես քո բազայի տվյալները
//բազայի վճարումների թեյբլի ստեղծիչը տես order_arca.sql ֆայլում
define(DBHOST, "localhost");
define(DBNAME, "test");
define(DBUSER, "root");
define(DBPASS, "root");

//Ադմինի էլ․փոստը, from և bcc-ի համար
$adminmail = "barehamb@hamb.damb";
$BACKURL = "http://localhost/processing.php?orderid=";


//Վճարային սիստեմի տվյալները, տեստային
$MERCHANTNUMBER = "118600118603000118604";
$baseURL = "https://91.199.226.7:7002/svpg/"; 
$BACKURL = urlencode($BACKURL);
$MERCHANTPASSWD="lazY2k";
$LANGUAGE="RU";
$DEPOSITFLAG=1;


