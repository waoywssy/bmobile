<?php

function audit_job_complaint($id, $type, $result)
//function audit_job_complaint()
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

  $id = str2int($_GET["i"]);
  if ($id <= 0)
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
  $type = str2int($_GET["t"]);
  if ($type < 1 || $type > 3)
  {
    $type = 1;
  }
  $result = str2int($_GET["r"]);
  if ($result < 1 || $result > 3)
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
*/
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");
  mysqli_autocommit($con, false);

  $flag = true;

  //mysqli_query($con, "LOCK TABLES complaint_nearby_jobs_cnj WRITE, user_credits_ucr WRITE, nearby_job_info_nj WRITE, nearby_jobs_nj WRITE");
  if ($type == 2)
  {
    $query = "UPDATE complaint_nearby_jobs_cnj SET cnj_is_done=0 WHERE cnj_nj_id=".sqlstrval($id);
    $flag = mysqli_query($con, $query) != false;
  }
  else if ($type == 1)
  {
    $query = "UPDATE complaint_nearby_jobs_cnj SET cnj_is_done=null WHERE cnj_nj_id=".sqlstrval($id);
    $flag = mysqli_query($con, $query) != false;
  }
  else
  {
    if ($result == 1)
    {
      $query = "UPDATE complaint_nearby_jobs_cnj SET cnj_is_done=1, cnj_result=null WHERE cnj_nj_id=".sqlstrval($id);
      $flag = mysqli_query($con, $query) != false;
    }
    else if ($result == 2)
    {
      $query = "UPDATE complaint_nearby_jobs_cnj SET cnj_is_done=1, cnj_result=0 WHERE cnj_nj_id=".sqlstrval($id);
      $flag = mysqli_query($con, $query) != false;

      $query_1 = "SELECT cnj_openid FROM complaint_nearby_jobs_cnj WHERE cnj_nj_id=".sqlstrval($id);
      $result_1 = mysqli_query($con, $query_1);
      while ($row = mysqli_fetch_array($result_1))
      {
        $cnj_openid = $row['cnj_openid'];

        $query_2 = "SELECT ucr_credit FROM user_credits_ucr WHERE ucr_openid=".sqlstr($cnj_openid);
        $result_2 = mysqli_query($con, $query_2);
        if ($row = mysqli_fetch_array($result_2))
        {
          $ucr_credit = $row['ucr_credit'];
          mysqli_free_result($result_2);

          $query_3 = "UPDATE user_credits_ucr SET ucr_credit=".sqlstrval(downgrade_credit($ucr_credit))." WHERE ucr_openid=".sqlstr($cnj_openid);
          $flag = $flag && mysqli_query($con, $query_3) != false;
        }
      }
      mysqli_free_result($result_1);
    }
    else if ($result == 3)
    {
      $query = "UPDATE complaint_nearby_jobs_cnj SET cnj_is_done=1, cnj_result=1 WHERE cnj_nj_id=".sqlstrval($id);
      $flag = mysqli_query($con, $query) != false;

      $query_1 = "SELECT nj_openid FROM nearby_job_info_nj WHERE nj_id=".sqlstrval($id);
      $result_1 = mysqli_query($con, $query_1);
      if ($row = mysqli_fetch_array($result_1))
      {
        $nj_openid = $row['nj_openid'];
        mysqli_free_result($result_1);

        $query_2 = "SELECT ucr_credit FROM user_credits_ucr WHERE ucr_openid=".sqlstr($nj_openid);
        $result_2 = mysqli_query($con, $query_2);
        if ($row = mysqli_fetch_array($result_2))
        {
          $ucr_credit = $row['ucr_credit'];
          mysqli_free_result($result_2);

          $query_3 = "UPDATE user_credits_ucr SET ucr_credit=".sqlstrval(downgrade_credit($ucr_credit))." WHERE ucr_openid=".sqlstr($nj_openid);
          $flag = $flag && mysqli_query($con, $query_3) != false;

          $query_4 = "DELETE FROM nearby_job_info_nj WHERE nj_id=".sqlstrval($id);
          $flag = $flag && mysqli_query($con, $query_4) != false;

          $query_5 = "DELETE FROM nearby_jobs_nj WHERE nj_id=".sqlstrval($id);
          $flag = $flag && mysqli_query($con, $query_5) != false;
        }
      }
    }
  }
  if ($flag)
  {
    mysqli_commit($con);
    echo "{\"result\":1}";
  }
  else
  {
    mysqli_rollback($con);
    echo "{\"result\":0,\"error\":".$errors["db write failure"]."}";
  }
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

}

?>