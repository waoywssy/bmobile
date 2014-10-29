<?php

//function get_users($type, $openid, $nickname, $order, $page)
function get_users()
{
  include_once 'util_global.php';
  include_once 'util_data.php';

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

  $type = str2int($_GET["t"]);
  if ($type != 1)
  {
    $type = 2;
  }

  if ($type == 2)
  {
    $openid = $_GET['oi'];
    $nickname = $_GET['nn'];
    if (is_null($openid) && is_null($nickname))
    {
      echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
      exit;
    }
  }

  $order = str2int($_GET["o"]);
  if ($order != 1)
  {
    $order = 0;
  }
  $page = str2int($_GET["p"], 1);
  if ($page <= 0)
  {
    $page = 1;
  }
  else if ($page > $max_pages)
  {
    $page = $max_pages;
  }

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");
  
  $total = 0;
  $start = ($page - 1) * $per_page;
  $order = $order == 1 ? "ASC" : "DESC";
  $users = "";
  $flag = true;
  $json = "";

  //mysqli_query($con, "LOCK TABLES users_u READ");
  if ($type == 1) // list
  {
    if ($page == 1)
    {
      $query_1 = "SELECT COUNT(*) AS total FROM users_u WHERE u_subscribe=1";

      $result = mysqli_query($con, $query_1);
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['total'];
        mysqli_free_result($result);
      }
    }

    if ($page > 1 || $total > 0)
    {
      $query_2 = "SELECT u_openid, u_nickname, u_sex, u_city, u_province, u_country, u_headimgurl, u_subscribe_time, u_unionid, ucr_credit 
      FROM users_u 
      LEFT OUTER JOIN user_credits_ucr ON u_openid = ucr_openid 
      WHERE u_subscribe=1 
      ORDER BY u_subscribe_time ".$order." LIMIT ".strval($start).",".strval($per_page);

      $result = mysqli_query($con, $query_2);
      while ($row = mysqli_fetch_array($result))
      {
        $u_openid = $row['u_openid'];
        $u_nickname = $row['u_nickname'];
        $u_sex = $row['u_sex'];
        $u_city = $row['u_city'];
        $u_province = $row['u_province'];
        $u_country = $row['u_country'];
        $u_headimgurl = $row['u_headimgurl'];
        $u_subscribe_time = $row['u_subscribe_time'];
        $u_unionid = $row['u_unionid'];
        $ucr_credit = $row['ucr_credit'];

        $users = $users.",{\"oi\":".jsonstr($u_openid).",\"nn\":".jsonstr($u_nickname).",\"sx\":".jsonstrval($u_sex).",\"ct\":".jsonstr($u_city).",\"pr\":".jsonstr($u_province).",\"cn\":".jsonstr($u_country).",\"hd\":".jsonstr($u_headimgurl).",\"st\":".jsonstr($u_subscribe_time).",\"ui\":".jsonstr($u_unionid).",\"cr\":".jsonstr($ucr_credit)."}";
      }
      mysqli_free_result($result);
      $users = substr($users, 1);
    }
  }
  else // type == 2 -> search
  {
    if ($page == 1)
    {
      $query_1 = "SELECT COUNT(*) AS total FROM users_u WHERE ";
      if (is_null($openid))
      {
        $query_1 = $query_1."u_nickname";
        $param = $nickname;
      }
      else
      {
        $query_1 = $query_1."u_openid";
        $param = $openid;
      }
      $query_1 = $query_1 . "='" . strval($param) ."' AND u_subscribe=1 LIMIT ".strval($start).",".strval($per_page);

      if ($result = mysqli_query($con, $query_1))
      {
        if ($row = mysqli_fetch_array($result))
        {
          $total = $row['total'];
          mysqli_free_result($result);
        }
        else
        {
          $json = "{\"result\":0,\"error\":".$errors["db read failure"]."}";
        }
      }
      else
      {
        $flag = false;
        $json = "{\"result\":0,\"error\":".$errors["internal error"]."}";
      }
    }

    if ($page > 1 || $total > 0)
    {
      $query_2 = "SELECT u_openid, u_nickname, u_sex, u_city, u_province, u_country, u_headimgurl, u_subscribe_time, u_unionid, ucr_credit  
                  FROM users_u 
                  LEFT OUTER JOIN user_credits_ucr ON u_openid = ucr_openid 
                  WHERE "; // u_subscribe=1 ORDER BY u_subscribe_time ".$order." LIMIT ".strval($start).",".strval($per_page);
      if (is_null($openid))
      {
        $query_2 = $query_2."u_nickname";
        $param = $nickname;
      }
      else
      {
        $query_2 = $query_2."u_openid";
        $param = $openid;
      }
      $query_2 = $query_2."='" . $param . "' AND u_subscribe=1 LIMIT ".strval($start).",".strval($per_page);

      if ($result = mysqli_query($con, $query_2))
      {
        if ($row = mysqli_fetch_array($result))
        {
          $u_openid = $row['u_openid'];
          $u_nickname = $row['u_nickname'];
          $u_sex = $row['u_sex'];
          $u_city = $row['u_city'];
          $u_province = $row['u_province'];
          $u_country = $row['u_country'];
          $u_headimgurl = $row['u_headimgurl'];
          $u_subscribe_time = $row['u_subscribe_time'];
          $u_unionid = $row['u_unionid'];
          $ucr_credit = $row['ucr_credit'];

          $users = $users.",{\"oi\":".jsonstr($u_openid).",\"nn\":".jsonstr($u_nickname).",\"sx\":".jsonstrval($u_sex).",\"ct\":".jsonstr($u_city).",\"pr\":".jsonstr($u_province).",\"cn\":".jsonstr($u_country).",\"hd\":".jsonstr($u_headimgurl).",\"st\":".jsonstr($u_subscribe_time).",\"ui\":".jsonstr($u_unionid).",\"cr\":".jsonstr($ucr_credit)."}";
        }
        mysqli_free_result($result);
        $users = substr($users, 1);
      }
      else
      {
        $json = "{\"result\":0,\"error\":".$errors["db read failure"]."}";
      }
    }
  }

  //mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  if ($flag)
  {
    $json = "{\"total\":".$total.",\"users\":[".$users."]}";
  }
  echo $json;
}

?>