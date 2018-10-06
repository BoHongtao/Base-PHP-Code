<?php

class DBMysql
{
	public static function connect(){
		$dbc = new mysqli('127.0.0.1','root','root','beauty') OR die('Could not connected to MySQL: '.mysql_error());
		$dbc->query('SET NAMES utf8');
		return $dbc;
	}
}

