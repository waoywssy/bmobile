<?php

function set_user_credit($openid, $credit)
//function set_user_credit()
{
  include_once 'util_global.php';
  include_once 'util_data.php';
/*
  if ($user->uid <= 0)
  {
    echo "{\"result\":0,\"error\":".$errors["not authenticated"]."}";
    exit;
  }
  if (!is_manager())
  {
    echo "{\"result\":0,\"error\":".$errors["no privileges"]."}";
    exit;
  }
  $usr_id = $user->uid;

  $openid = $_GET["oi"];
  if (is_null($openid))
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
  $credit = str2int($_GET["c"]);
*/
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");
 
  //mysqli_query($con, "LOCK TABLES user_credits_ucr WRITE");
  $query = "UPDATE user_credits_ucr SET ucr_credit=ucr_credit+".sqlstrval($credit)." WHERE ucr_openid=".sqlstr($openid);
  $flag = mysqli_query($con, $query) != false;
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  if ($flag)
  {
    echo "{\"result\":1}";
  }
  else
  {
    echo "{\"result\":0,\"error\":".$errors["db write failure"]."}";
  }
}

?>