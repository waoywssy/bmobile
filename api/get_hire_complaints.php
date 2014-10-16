<?php

//function get_hire_complaints($type, $page)
function get_hire_complaints()
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
  if ($type < 1 || $type > 3)
  {
    $type = 1;
  }
  $page = str2int($_GET["p"]);
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
  $hires = "";
  $json = "";
 
  //mysqli_query($con, "LOCK TABLES complaint_nearby_hires_cnh READ, nearby_hire_info_nh READ");
  if ($page == 1)
  {
    $query_1 = "SELECT COUNT(DISTINCT cnh_nh_id) AS total FROM complaint_nearby_hires_cnh WHERE ";
    if ($type > 1){
      $query_1 .= "cnj_is_done=".sqlstrval($type - 2);  
    } else {
      $query_1 .= "cnj_is_done IS NULL";  
    }

    $result = mysqli_query($con, $query_1);
    if ($row = mysqli_fetch_array($result))
    {
      $total = $row['total'];
      mysqli_free_result($result);
    }
  }

  if ($page > 1 || $total > 0)
  {
    $query_2 = "SELECT DISTINCT cnh_nh_id FROM complaint_nearby_hires_cnh WHERE ";
    if ($type > 1){
      $query_2 .= "cnj_is_done=".sqlstrval($type - 2);
    } else {
      $query_2 .= "cnj_is_done IS NULL";  
    }
    $query_2 .= " ORDER BY cnh_time ASC LIMIT ".strval($start).",".strval($per_page);

    $result = mysqli_query($con, $query_2);
    while ($row = mysqli_fetch_array($result))
    {
      $cnh_nh_id = $row['cnh_nh_id'];

      $query_3 = "SELECT nh_openid, nh_start, nh_end, nh_titles, nh_location, nh_content, nh_duration, nh_contact, nh_phone, nh_email, nh_address FROM nearby_hire_info_nh WHERE nh_id=".sqlstrval($cnh_nh_id);

      $result_3 = mysqli_query($con, $query_3);
      if ($row = mysqli_fetch_array($result_3))
      {
        $nh_openid = $row['nh_openid'];
        $nh_start = $row['nh_start'];
        $nh_end = $row['nh_end'];
        $nh_titles = $row['nh_titles'];
        $nh_location = $row['nh_location'];
        $nh_content = $row['nh_content'];
        $nh_duration = $row['nh_duration'];
        $nh_contact = $row['nh_contact'];
        $nh_phone = $row['nh_phone'];
        $nh_email = $row['nh_email'];
        $nh_address = $row['nh_address'];
        mysqli_free_result($result_3);

        $hire = "\"id\":".jsonstrval($cnh_nh_id).",\"s\":".jsonstr($nh_start).",\"e\":".jsonstr($nh_end).",\"t\":".jsonstr($nh_titles).",\"l\":".jsonstrval($nh_location).",\"c\":".jsonstrval($nh_content).",\"d\":".jsonstrval($nh_duration).",\"cnt\":".jsonstr($nh_contact).",\"phn\":".jsonstr($nh_phone).",\"eml\":".jsonstr($nh_email).",\"add\":".jsonstr($nh_address);

        $complaints = "";

        $query_4 = "SELECT cnh_id, cnh_openid, cnh_time, cnh_is_done, cnh_result, cnh_type, cnh_content FROM complaint_nearby_hires_cnh WHERE cnh_nh_id=".sqlstrval($cnh_nh_id)." ORDER BY cnh_time ASC";

        $result_4 = mysqli_query($con, $query_4);
        while ($row = mysqli_fetch_array($result_4))
        {
          $cnh_id = $row['cnh_id'];
          $cnh_openid = $row['cnh_openid'];
          $cnh_time = $row['cnh_time'];
          $cnh_is_done = $row['cnh_is_done'];
          $cnh_result = $row['cnh_result'];
          $cnh_type = $row['cnh_type'];
          $cnh_content = $row['cnh_content'];

          $complaints = $complaints.",{\"i\":".jsonstrval($cnh_id).",\"oi\":".jsonstr($cnh_openid).",\"tm\":".jsonstr($cnh_time).",\"d\":".jsonstrval($cnh_is_done).",\"r\":".jsonstrval($cnh_result).",\"tp\":".jsonstrval($cnh_type).",\"c\":\"".jsonstrval($cnh_content)."\"}";
        }
        mysqli_free_result($result_4);
        $complaints = substr($complaints, 1);

        $hires = $hires.",{".$hire.",\"complaints\":[".$complaints."]}";
      }
    }
    mysqli_free_result($result);
    $hires = substr($hires, 1);
  }
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  $json = "{\"total\":".$total.",\"hires\":[".$hires."]}";
  echo $json;
}

?>