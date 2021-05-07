<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_BaseDatos = "localhost";
$database_BaseDatos = "colegio_db";
$username_BaseDatos = "colegio_colegio";
$password_BaseDatos = "sfda";
$BaseDatos = mysql_pconnect($hostname_BaseDatos, $username_BaseDatos, $password_BaseDatos) or die(mysql_error());
?>