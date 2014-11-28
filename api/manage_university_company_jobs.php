<?php
include_once 'util_global.php';
include_once 'util_data.php';

function manage_university_company_jobs($type, $companyid, $jobid, $title, $major, $education, $place, $salary, $total, $content)
//function manage_university_company_jobs()
{
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

  $type = isset($_POST["t"]) ? str2int($_POST["t"]) : 0;
  if ($type < 1 || $type > 4)
  {
    $type = 1;
  }
  $companyid = isset($_POST["ci"]) ? str2int($_POST["ci"]) : 0;
  if ($companyid <= 0)
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
  $jobid = isset($_POST["ji"]) ? str2int($_POST["ji"]) : 0;
  $title = isset($_POST["jt"]) ? $_POST["jt"] : null;
  $major = isset($_POST["m"]) ? $_POST["m"] : null;
  $education = isset($_POST["e"]) ? $_POST["e"] : null;
  $place = isset($_POST["p"]) ? $_POST["p"] : null;
  $salary = isset($_POST["s"]) ? $_POST["s"] : null;
  $total = isset($_POST["tt"]) ? $_POST["tt"] : null;
  $content = isset($_POST["c"]) ? $_POST["c"] : null;
*/
  global $db_host, $db_user, $db_pwd, $db_name, $errors;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");
  //mysqli_autocommit($con, false);

/*
  if ($type == 1)
  {
    mysqli_query($con, "LOCK TABLES university_company_jobs_unv_cmp_jb READ");
  }
  else
  {
    mysqli_query($con, "LOCK TABLES university_company_jobs_unv_cmp_jb WRITE");
  }
*/
  $json = "{\"result\":0,\"error\":".$errors["internal error"]."}";
  switch ($type)
  {
    case 1:
      $jtotal = 0;
      $jobs = "";

      $query = "SELECT COUNT(unv_cmp_jb_id) AS jtotal FROM university_company_jobs_unv_cmp_jb WHERE unv_cmp_jb_unv_cmp_id=".sqlstrval($companyid);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $jtotal = $row['jtotal'];
        mysqli_free_result($result);
      }
      if ($jtotal > 0)
      {
        $query = "SELECT unv_cmp_jb_id, unv_cmp_jb_title, unv_cmp_jb_major, unv_cmp_jb_edu, unv_cmp_jb_place, unv_cmp_jb_salary, unv_cmp_jb_total, unv_cmp_jb_content FROM university_company_jobs_unv_cmp_jb WHERE unv_cmp_jb_unv_cmp_id=".sqlstrval($companyid);
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result))
        {
          $unv_cmp_jb_id = $row['unv_cmp_jb_id'];
          $unv_cmp_jb_title = $row['unv_cmp_jb_title'];
          $unv_cmp_jb_major = $row['unv_cmp_jb_major'];
          $unv_cmp_jb_edu = $row['unv_cmp_jb_edu'];
          $unv_cmp_jb_place = $row['unv_cmp_jb_place'];
          $unv_cmp_jb_salary = $row['unv_cmp_jb_salary'];
          $unv_cmp_jb_total = $row['unv_cmp_jb_total'];
          $unv_cmp_jb_content = $row['unv_cmp_jb_content'];

          $jobs = $jobs.",{\"i\":".sqlstrval($unv_cmp_jb_id).",\"t\":".sqlstr($unv_cmp_jb_title).",\"m\":".sqlstr($unv_cmp_jb_major).",\"e\":".sqlstr($unv_cmp_jb_edu).",\"p\":".sqlstr($unv_cmp_jb_place).",\"s\":".sqlstr($unv_cmp_jb_salary).",\"tt\":".sqlstr($unv_cmp_jb_total).",\"c\":".sqlstr($unv_cmp_jb_content)."}";
        }
        mysqli_free_result($result);
        $jobs = substr($jobs, 1);
      }
      $json = "{\"t\":".$jtotal.",\"j\":[".$jobs."]}";;
      break;
    case 2:
      $query = "INSERT IGNORE INTO university_company_jobs_unv_cmp_jb (unv_cmp_jb_unv_cmp_id, unv_cmp_jb_title, unv_cmp_jb_major, unv_cmp_jb_edu, unv_cmp_jb_place, unv_cmp_jb_salary, unv_cmp_jb_total, unv_cmp_jb_content) VALUES (".sqlstrval($companyid).",".sqlstr($title).",".sqlstr($major).",".sqlstr($education).",".sqlstr($place).",".sqlstr($salary).",".sqlstrval($total).",".sqlstr($content).")";
      mysqli_query($con, $query);

      $query = "SELECT unv_cmp_jb_id FROM university_company_jobs_unv_cmp_jb WHERE unv_cmp_jb_unv_cmp_id=".sqlstrval($companyid)." AND unv_cmp_jb_title=".sqlstr($title);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $unv_cmp_jb_id = $row['unv_cmp_jb_id'];

        mysqli_free_result($result);
        $json = "{\"i\":".sqlstrval($unv_cmp_jb_id)."}";
      }
      else
      {
        $json = "{\"result\":0,\"error\":".$errors["db write failure"]."}";
      }
      break;
    case 3:
      $query = "UPDATE university_company_jobs_unv_cmp_jb SET unv_cmp_jb_major=".sqlstr($major).",unv_cmp_jb_edu=".sqlstr($education).",unv_cmp_jb_place=".sqlstr($place).",unv_cmp_jb_salary=".sqlstr($salary).",unv_cmp_jb_total=".sqlstrval($total).",unv_cmp_jb_content=".sqlstr($content)." WHERE unv_cmp_jb_unv_cmp_id=".sqlstrval($companyid)." AND unv_cmp_jb_id=".sqlstrval($jobid);
      if (!mysqli_query($con, $query))
      {
        $json = "{\"result\":0,\"error\":".$errors["db write failure"]."}";
      }
      else
      {
        $json = "{\"result\":1}";
      }
      break;
    case 4:
      $query = "DELETE FROM university_company_jobs_unv_cmp_jb WHERE unv_cmp_jb_unv_cmp_id=".sqlstrval($companyid)." AND unv_cmp_jb_id=".sqlstrval($jobid);
      if (!mysqli_query($con, $query))
      {
        $json = "{\"result\":0,\"error\":".$errors["db write failure"]."}";
      }
      else
      {
        $json = "{\"result\":1}";
      }
      break;
  }

  //mysqli_commit($con);
  //mysqli_rollback($con);
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

}

?>