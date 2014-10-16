<?php

function backend()
{
  include_once 'util_global.php';
  include_once 'util_data.php';

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  remove_expired_jobs($con);
  remove_expired_hires($con);
  remove_expired_job_complaints($con);
  remove_expired_hire_complaints($con);
  optimize_tables($con);

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

}

function remove_expired_jobs($con)
{
  $today = (new DateTime)->format("Y-m-d");
  $noj_enabled = 1;

  $query_1 = "SELECT nj_id,nj_openid,nj_start,nj_end,nj_title,nj_type,nj_sex,nj_age_l,nj_age_h,nj_height_l,nj_height_h,nj_edu,nj_exp,nj_salary_l,nj_salary_h,nj_social_security,nj_housing_fund,nj_annual_vacations,nj_housing,nj_meals,nj_travel,nj_overtime,nj_nightshift,nj_requirement,nj_description,nj_benefit,nj_company,nj_phone,nj_email,nj_address,nj_views FROM nearby_job_info_nj WHERE nj_end<?";
  $query_2 = "SELECT nj_lat,nj_lng FROM nearby_jobs_nj WHERE nj_id=?";
  $query_3 = "INSERT INTO nearby_old_jobs_noj (noj_id,noj_openid,noj_start,noj_end,noj_lat,noj_lng,noj_enabled,noj_title,noj_type,noj_sex,noj_age_l,noj_age_h,noj_height_l,noj_height_h,noj_edu,noj_exp,noj_salary_l,noj_salary_h,noj_social_security,noj_housing_fund,noj_annual_vacations,noj_housing,noj_meals,noj_travel,noj_overtime,noj_nightshift,noj_requirement,noj_description,noj_benefit,noj_company,noj_phone,noj_email,noj_address,noj_views) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $query_4 = "DELETE FROM nearby_jobs_nj WHERE nj_id=?";
  $query_5 = "DELETE FROM nearby_job_info_nj WHERE nj_id=?";

  $stmt_1 = mysqli_prepare($con, $query_1);
  $stmt_2 = mysqli_prepare($con, $query_2);
  $stmt_3 = mysqli_prepare($con, $query_3);
  $stmt_4 = mysqli_prepare($con, $query_4);
  $stmt_5 = mysqli_prepare($con, $query_5);

  mysqli_stmt_bind_param($stmt_1, "s", $today);
  mysqli_stmt_bind_param($stmt_2, "i", $nj_id);
  mysqli_stmt_bind_param($stmt_3, "isssddisiiiiiiiiiiiiiiiiiisssssssi", $nj_id,$nj_openid,$nj_start,$nj_end,$nj_lat,$nj_lng,$noj_enabled,$nj_title,$nj_type,$nj_sex,$nj_age_l,$nj_age_h,$nj_height_l,$nj_height_h,$nj_edu,$nj_exp,$nj_salary_l,$nj_salary_h,$nj_social_security,$nj_housing_fund,$nj_annual_vacations,$nj_housing,$nj_meals,$nj_travel,$nj_overtime,$nj_nightshift,$nj_requirement,$nj_description,$nj_benefit,$nj_company,$nj_phone,$nj_email,$nj_address,$nj_views);
  mysqli_stmt_bind_param($stmt_4, "i", $nj_id);
  mysqli_stmt_bind_param($stmt_5, "i", $nj_id);

  //mysqli_query($con, "LOCK TABLES nearby_job_info_nj WRITE, nearby_jobs_nj WRITE, nearby_old_jobs_noj WRITE");

  mysqli_stmt_execute($stmt_1);
  $result_1 = mysqli_stmt_get_result($stmt_1);
  while ($row = mysqli_fetch_array($result_1))
  {
    $nj_id = $row['nj_id'];
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
    $nj_views = $row['nj_views'];

    mysqli_stmt_execute($stmt_2);
    $result_2 = mysqli_stmt_get_result($stmt_2);
    if ($row = mysqli_fetch_array($result_2))
    {
      $nj_lat = $row['nj_lat'];
      $nj_lng = $row['nj_lng'];
      mysqli_free_result($result_2);

      mysqli_stmt_execute($stmt_3);
    }
    mysqli_stmt_execute($stmt_4);
    mysqli_stmt_execute($stmt_5);
  }
  mysqli_free_result($result_1);

  mysqli_stmt_close($stmt_1);
  mysqli_stmt_close($stmt_2);
  mysqli_stmt_close($stmt_3);
  mysqli_stmt_close($stmt_4);
  mysqli_stmt_close($stmt_5);

  //mysqli_query($con, "UNLOCK TABLES");
}

function remove_expired_hires($con)
{
  $today = (new DateTime)->format("Y-m-d");
  $noh_enabled = 1;

  $query_1 = "SELECT nh_id,nh_openid,nh_start,nh_end,nh_titles,nh_location,nh_content,nh_duration,nh_contact,nh_phone,nh_email,nh_address,nh_views FROM nearby_hire_info_nh WHERE nh_end<?";
  $query_2 = "SELECT nh_lat,nh_lng FROM nearby_hires_nh WHERE nh_id=?";
  $query_3 = "INSERT INTO nearby_old_hires_noh (noh_id,noh_openid,noh_start,noh_end,noh_lat,noh_lng,noh_enabled,noh_titles,noh_location,noh_content,noh_duration,noh_contact,noh_phone,noh_email,noh_address,noh_views) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $query_4 = "DELETE FROM nearby_hires_nh WHERE nh_id=?";
  $query_5 = "DELETE FROM nearby_hire_info_nh WHERE nh_id=?";

  $stmt_1 = mysqli_prepare($con, $query_1);
  $stmt_2 = mysqli_prepare($con, $query_2);
  $stmt_3 = mysqli_prepare($con, $query_3);
  $stmt_4 = mysqli_prepare($con, $query_4);
  $stmt_5 = mysqli_prepare($con, $query_5);

  mysqli_stmt_bind_param($stmt_1, "s", $today);
  mysqli_stmt_bind_param($stmt_2, "i", $nh_id);
  mysqli_stmt_bind_param($stmt_3, "isssddisssissssi", $nh_id,$nh_openid,$nh_start,$nh_end,$nh_lat,$nh_lng,$noh_enabled,$nh_titles,$nh_location,$nh_content,$nh_duration,$nh_contact,$nh_phone,$nh_email,$nh_address,$nh_views);
  mysqli_stmt_bind_param($stmt_4, "i", $nh_id);
  mysqli_stmt_bind_param($stmt_5, "i", $nh_id);

  //mysqli_query($con, "LOCK TABLES nearby_job_info_nj WRITE, nearby_jobs_nj WRITE, nearby_old_jobs_noj WRITE");

  mysqli_stmt_execute($stmt_1);
  $result_1 = mysqli_stmt_get_result($stmt_1);
  while ($row = mysqli_fetch_array($result_1))
  {
    $nh_id = $row['nh_id'];
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
    $nh_views = $row['nh_views'];

    mysqli_stmt_execute($stmt_2);
    $result_2 = mysqli_stmt_get_result($stmt_2);
    if ($row = mysqli_fetch_array($result_2))
    {
      $nh_lat = $row['nh_lat'];
      $nh_lng = $row['nh_lng'];
      mysqli_free_result($result_2);

      mysqli_stmt_execute($stmt_3);
    }
    mysqli_stmt_execute($stmt_4);
    mysqli_stmt_execute($stmt_5);
  }
  mysqli_free_result($result_1);

  mysqli_stmt_close($stmt_1);
  mysqli_stmt_close($stmt_2);
  mysqli_stmt_close($stmt_3);
  mysqli_stmt_close($stmt_4);
  mysqli_stmt_close($stmt_5);

  //mysqli_query($con, "UNLOCK TABLES");
}

function remove_expired_job_complaints($con)
{
  $today = new DateTime;
  $today = $today->sub(new DateInterval('P30D'));
  $today = $today->format("Y-m-d");

  $query_1 = "DELETE FROM complaint_nearby_jobs_cnj WHERE cnj_is_done=1 AND cnj_time<?";

  $stmt_1 = mysqli_prepare($con, $query_1);

  mysqli_stmt_bind_param($stmt_1, "s", $today);

  //mysqli_query($con, "LOCK TABLES complaint_nearby_jobs_cnj WRITE");

  mysqli_stmt_execute($stmt_1);

  mysqli_stmt_close($stmt_1);

  //mysqli_query($con, "UNLOCK TABLES");
}

function remove_expired_hire_complaints($con)
{
  $today = new DateTime;
  $today = $today->sub(new DateInterval('P30D'));
  $today = $today->format("Y-m-d");

  $query_1 = "DELETE FROM complaint_nearby_hires_cnh WHERE cnh_is_done=1 AND cnh_time<?";

  $stmt_1 = mysqli_prepare($con, $query_1);

  mysqli_stmt_bind_param($stmt_1, "s", $today);

  //mysqli_query($con, "LOCK TABLES complaint_nearby_hires_cnh WRITE");

  mysqli_stmt_execute($stmt_1);

  mysqli_stmt_close($stmt_1);

  //mysqli_query($con, "UNLOCK TABLES");
}

function optimize_tables($con)
{
  $query_1 = "OPTIMIZE TABLE login_l";
  $query_2 = "OPTIMIZE TABLE nearby_jobs_nj";
  $query_3 = "OPTIMIZE TABLE nearby_job_info_nj";
  $query_4 = "OPTIMIZE TABLE nearby_hires_nh";
  $query_5 = "OPTIMIZE TABLE nearby_hire_info_nh";
  $query_6 = "OPTIMIZE TABLE complaint_nearby_jobs_cnj";
  $query_7 = "OPTIMIZE TABLE complaint_nearby_hires_cnh";
  $query_8 = "OPTIMIZE TABLE user_credits_ucr";

  mysqli_query($con, $query_1);
  mysqli_query($con, $query_2);
  mysqli_query($con, $query_3);
  mysqli_query($con, $query_4);
  mysqli_query($con, $query_5);
  mysqli_query($con, $query_6);
  mysqli_query($con, $query_7);
  mysqli_query($con, $query_8);
}

backend();
?>