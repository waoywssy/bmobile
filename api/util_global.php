<?php
global $user;

// database
$db_host = "localhost";
$db_user = "root";
$db_pwd = "";
$db_name = "b_site";

// products displaying / listing
$max_pages = 50;
$per_page = 20;

// convert string to interger with default value
function str2int($str, $default = 0)
{
  if (is_null($str) || strlen($str) == 0)
  {
    $value = $default;
  }
  else
  {
    $value = intval($str);
  }
  return $value;
}

// convert string to float with default value
function str2float($str, $default = 0)
{
  if (is_null($str) || strlen($str) == 0)
  {
    $value = $default;
  }
  else
  {
    $value = floatval($str);
  }
  return $value;
}

// convert string to datetime with default value
function str2datetime($str, $default = null)
{
  if (!is_null($str) && strlen($str) != 0)
  {
    try
    {
      $value = new DateTime($str);
    }
    catch (Exception $e)
    {
      $value = $default;
    }
  }
  else
  {
    $value = $default;
  }
  return $value;
}

// check if the user is a manager
function is_manager()
{
  return $user->uid == 0 ||
    (is_array($user->roles) && in_array('manager', $user->roles));
}

// check if the user is the super-administrator
function is_administrator()
{
  return is_array($user->roles) && in_array('administrator', $user->roles);
}

function jsonstr($str)
{
  return (is_null($str) || empty($str)) ? "null" : "\"".str_replace("\"", "\\\"", $str)."\"";
}

function jsonstrval($val)
{
  return is_null($val) ? "null" : strval($val);
}

function sqlstr($str)
{
  return (is_null($str) || empty($str)) ? "null" : "'".str_replace("'", "\\'", $str)."'";
}

function sqlstrval($val)
{
  return is_null($val) ? "null" : strval($val);
}

function downgrade_credit($credit)
{
  if ($credit >= 400)
  {
    $credit = 150;
  }
  else if ($credit >= 150)
  {
    $credit = 50;
  }
  else if ($credit >= 50)
  {
    $credit = 0;
  }
  else if ($credit >= 10)
  {
    $credit = -1;
  }
  else
  {
    $credit -= 10;
  }
  return $credit;
}

?>