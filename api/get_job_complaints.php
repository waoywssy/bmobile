<?php

//function get_job_complaints($type, $page)
function get_job_complaints()
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
  $jobs = "";
  $json = "";
 
  //mysqli_query($con, "LOCK TABLES complaint_nearby_jobs_cnj READ, nearby_job_info_nj READ");
  if ($page == 1)
  {
    $query_1 = "SELECT COUNT(DISTINCT cnj_nj_id) AS total FROM complaint_nearby_jobs_cnj WHERE ";
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
    $query_2 = "SELECT DISTINCT cnj_nj_id FROM complaint_nearby_jobs_cnj WHERE ";

    if ($type > 1){
      $query_2 .= "cnj_is_done=".sqlstrval($type - 2);  
    } else {
      $query_2 .= "cnj_is_done IS NULL";  
    }
    $query_2 .= " ORDER BY cnj_time ASC LIMIT ".strval($start).",".strval($per_page);

    $result = mysqli_query($con, $query_2);
    while ($row = mysqli_fetch_array($result))
    {
      $cnj_nj_id = $row['cnj_nj_id'];

      $query_3 = "SELECT nj_openid, nj_start, nj_end, nj_title, nj_type, nj_sex, nj_age_l, nj_age_h, nj_height_l, nj_height_h, nj_edu, nj_exp, nj_salary_l, nj_salary_h, nj_social_security, nj_housing_fund, nj_annual_vacations, nj_housing, nj_meals, nj_travel, nj_overtime, nj_nightshift, nj_requirement, nj_description, nj_benefit, nj_company, nj_phone, nj_email, nj_address FROM nearby_job_info_nj WHERE nj_id=".sqlstrval($cnj_nj_id);

      $result_3 = mysqli_query($con, $query_3);
      if ($row = mysqli_fetch_array($result_3))
      {
        $nj_openid = $row['nj_openid'];
        $nj_start = $row['nj_start'];
        $nj_end = $row['nj_end'];
        $nj_title = $row['nj_title'];
        $nj_type = $row['nj_type'];
        $nj_sex = $row['nj_sex'];
        $nj_age_l = $row['nj_age_l'];
        $nj_age_h = $row['nj_age_h'];
        $nj_height_l = $row['nj_height_l'];
        $nj_height_h = $row['nj_height_h'];
        $nj_edu = $row['nj_edu'];
        $nj_exp = $row['nj_exp'];
        $nj_salary_l = $row['nj_salary_l'];
        $nj_salary_h = $row['nj_salary_h'];
        $nj_social_security = $row['nj_social_security'];
        $nj_housing_fund = $row['nj_housing_fund'];
        $nj_annual_vacations = $row['nj_annual_vacations'];
        $nj_housing = $row['nj_housing'];
        $nj_meals = $row['nj_meals'];
        $nj_travel = $row['nj_travel'];
        $nj_overtime = $row['nj_overtime'];
        $nj_nightshift = $row['nj_nightshift'];
        $nj_requirement = $row['nj_requirement'];
        $nj_description = $row['nj_description'];
        $nj_benefit = $row['nj_benefit'];
        $nj_company = $row['nj_company'];
        $nj_phone = $row['nj_phone'];
        $nj_email = $row['nj_email'];
        $nj_address = $row['nj_address'];
        mysqli_free_result($result_3);

        $job = "\"id\":".jsonstrval($cnj_nj_id).",\"s\":".jsonstr($nj_start).",\"e\":".jsonstr($nj_end).",\"t\":".jsonstr($nj_title).",\"ty\":".jsonstr($nj_type).",\"sx\":".jsonstrval($nj_sex).",\"al\":".jsonstrval($nj_age_l).",\"ah\":".jsonstrval($nj_age_h).",\"hl\":".jsonstrval($nj_height_l).",\"hh\":".jsonstrval($nj_height_h).",\"edu\":".jsonstrval($nj_edu).",\"exp\":".jsonstrval($nj_exp).",\"sl\":".jsonstrval($nj_salary_l).",\"sh\":".jsonstrval($nj_salary_h).",\"ss\":".jsonstrval($nj_social_security).",\"hf\":".jsonstrval($nj_housing_fund).",\"av\":".jsonstrval($nj_annual_vacations).",\"hs\":".jsonstrval($nj_housing).",\"ml\":".jsonstrval($nj_meals).",\"tr\":".jsonstrval($nj_travel).",\"ot\":".jsonstrval($nj_overtime).",\"ns\":".jsonstrval($nj_nightshift).",\"rqr\":".jsonstr($nj_requirement).",\"dsc\":".jsonstr($nj_description).",\"bnf\":".jsonstr($nj_benefit).",\"c\":".jsonstr($nj_company).",\"phn\":".jsonstr($nj_phone).",\"eml\":".jsonstr($nj_email).",\"add\":".jsonstr($nj_address);

        $complaints = "";

        $query_4 = "SELECT cnj_id, cnj_openid, cnj_time, cnj_is_done, cnj_result, cnj_type, cnj_content FROM complaint_nearby_jobs_cnj WHERE cnj_nj_id=".sqlstrval($cnj_nj_id)." ORDER BY cnj_time ASC";

        $result_4 = mysqli_query($con, $query_4);
        while ($row = mysqli_fetch_array($result_4))
        {
          $cnj_id = $row['cnj_id'];
          $cnj_openid = $row['cnj_openid'];
          $cnj_time = $row['cnj_time'];
          $cnj_is_done = $row['cnj_is_done'];
          $cnj_result = $row['cnj_result'];
          $cnj_type = $row['cnj_type'];
          $cnj_content = $row['cnj_content'];

          $complaints = $complaints.",{\"i\":".jsonstrval($cnj_id).",\"oi\":".jsonstr($cnj_openid).",\"tm\":".jsonstr($cnj_time).",\"d\":".jsonstrval($cnj_is_done).",\"r\":".jsonstrval($cnj_result).",\"tp\":".jsonstrval($cnj_type).",\"c\":\"".jsonstrval($cnj_content)."\"}";
        }
        mysqli_free_result($result_4);
        $complaints = substr($complaints, 1);

        $jobs = $jobs.",{".$job.",\"complaints\":[".$complaints."]}";
      }
    }
    mysqli_free_result($result);
    $jobs = substr($jobs, 1);
  }
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  $json = "{\"total\":".$total.",\"jobs\":[".$jobs."]}";
  echo $json;
}

?>