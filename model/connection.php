<?php

class Connection
{
  private static $link = null;

  public static function conn()
  {
    if (self::$link === null) {
      self::$link = new PDO("mysql:host=localhost;dbname=db_volta", "root", "");
      self::$link->exec("set names utf8");
    }
    return self::$link;
  }
}
