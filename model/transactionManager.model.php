<?php

require_once "connection.php";

class TransactionManager
{
  private static $isTransactionActive = false;

  public static function mdlIniciarTransaccion()
  {
    $conn = Connection::conn();
    if (!self::$isTransactionActive) {
      $conn->beginTransaction();
      self::$isTransactionActive = true;
    }
  }

  public static function mdlFinalizarTransaccion()
  {
    $conn = Connection::conn();
    if (self::$isTransactionActive) {
      $conn->commit();
      self::$isTransactionActive = false;
    }
  }

  public static function mdlCancelarTransaccion()
  {
    $conn = Connection::conn();
    if (self::$isTransactionActive) {
      $conn->rollBack();
      self::$isTransactionActive = false;
    }
  }
}
