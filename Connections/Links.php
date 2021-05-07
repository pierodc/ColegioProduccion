<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Links = "localhost";
$database_Links = "colegio_links1";
$username_Links = "colegio_colegio";
$password_Links = "colegio";
$Links = mysql_pconnect($hostname_Links, $username_Links, $password_Links) or die(mysql_error());
?>