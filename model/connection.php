<?php

class Connection
{
  public static function conn()
  {
    $link = new PDO("mysql:host=localhost;dbname=db_volta", "root", "");
    $link->exec("set names utf8");
    return $link;
  }

}
