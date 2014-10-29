<?php

//function get_online_users($page)
function get_online_users()
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

  $page = str2float($_GET["p"], 1);
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
  $users = "";
  $json = "";
 
  //mysqli_query($con, "LOCK TABLES login_l READ, users_u READ");
  if ($page == 1)
  {
    $query_1 = "SELECT COUNT(*) AS total FROM login_l";

    $result = mysqli_query($con, $query_1);
    if ($row = mysqli_fetch_array($result))
    {
      $total = $row['total'];
      mysqli_free_result($result);
    }
  }

  if ($page > 1 || $total > 0)
  {
    $query_2 = "SELECT u_openid, u_nickname, u_sex, u_city, u_province, u_country, u_headimgurl, u_subscribe_time, u_unionid, l_latitude, l_longitude, ucr_credit  
                FROM login_l 
                LEFT JOIN users_u ON l_openid=u_openid 
                LEFT OUTER JOIN user_credits_ucr ON u_openid = ucr_openid 
                WHERE u_openid IS NOT NULL
                LIMIT ".strval($start).",".strval($per_page);

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
      $l_latitude = $row['l_latitude'];
      $l_longitude = $row['l_longitude'];
      $ucr_credit = $row['ucr_credit'];

      $users = $users.",{\"oi\":".jsonstr($u_openid).",\"nn\":".jsonstr($u_nickname).",\"sx\":".jsonstrval($u_sex).",\"ct\":".jsonstr($u_city).",\"pr\":".jsonstr($u_province).",\"cn\":".jsonstr($u_country).",\"hd\":".jsonstr($u_headimgurl).",\"st\":".jsonstr($u_subscribe_time).",\"ui\":".jsonstr($u_unionid).",\"lat\":".jsonstrval($l_latitude).",\"lng\":".jsonstrval($l_longitude).",\"cr\":".jsonstr($ucr_credit)."}";
    }
    mysqli_free_result($result);
    $users = substr($users, 1);
  }
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  $json = "{\"total\":".$total.",\"users\":[".$users."]}";
  echo $json;
}

?>