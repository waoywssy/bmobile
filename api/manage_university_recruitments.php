<?php
//function manage_university_recruitments($type, $universityid, $companyid, $date, $place)
function manage_university_recruitments()
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

  $type = isset($_POST["t"]) ? str2int($_POST["t"]) : 0;
  if ($type < 1 || $type > 4)
  {
    $type = 1;
  }
  $universityid = isset($_POST["ui"]) ? str2int($_POST["ui"]) : 0;
  if ($universityid <= 0)
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
  $companyid = isset($_POST["ci"]) ? str2int($_POST["ci"]) : 0;
  $date = isset($_POST["d"]) ? str2datetime($_POST["d"]) : null;
  $place = isset($_POST["p"]) ? $_POST["p"] : null;

  //global $db_host, $db_user, $db_pwd, $db_name, $errors;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");
  //mysqli_autocommit($con, false);

  if ($type == 1)
  {
    mysqli_query($con, "LOCK TABLES university_recruitments_unv_rcr READ, university_companies_unv_cmp READ");
  }
  else
  {
    mysqli_query($con, "LOCK TABLES university_recruitments_unv_rcr WRITE");
  }
  $json = "{\"result\":0,\"error\":".$errors["internal error"]."}";
  switch ($type)
  {
    case 1:
      $total = 0;
      $recruitments = "";

      $query = "SELECT COUNT(unv_rcr_unv_cmp_id) AS total FROM university_recruitments_unv_rcr WHERE unv_rcr_unv_id=".sqlstrval($universityid)." AND unv_rcr_unv_cmp_id=".sqlstrval($companyid);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['total'];
        mysqli_free_result($result);
      }
      if ($total > 0)
      {
        $query = "SELECT unv_rcr_date, unv_rcr_place, unv_cmp_id, unv_cmp_name FROM university_recruitments_unv_rcr LEFT JOIN university_companies_unv_cmp ON unv_rcr_unv_cmp_id=unv_cmp_id WHERE unv_rcr_unv_id=".sqlstrval($universityid)." AND unv_rcr_unv_cmp_id=".sqlstrval($companyid);
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result))
        {
          $unv_rcr_date = $row['unv_rcr_date'];
          $unv_rcr_place = $row['unv_rcr_place'];
          $unv_cmp_id = $row['unv_cmp_id'];
          $unv_cmp_name = $row['unv_cmp_name'];

          $recruitments = $recruitments.",{\"i\":".jsonstr($unv_cmp_id).",\"n\":".jsonstr($unv_cmp_name).",\"d\":".jsonstr($unv_rcr_date).",\"p\":".jsonstr($unv_rcr_place)."}";
        }
        mysqli_free_result($result);
        $recruitments = substr($recruitments, 1);
      }
      $json = "{\"t\":".$total.",\"r\":[".$recruitments."]}";
      break;
    case 2:
      $query = "INSERT IGNORE INTO university_recruitments_unv_rcr (unv_rcr_unv_id, unv_rcr_date, unv_rcr_unv_cmp_id, unv_rcr_place) VALUES (".sqlstrval($universityid).",".sqlstr($date->format("Y-m-d\TH:i:sP")).",".sqlstrval($companyid).",".sqlstr($place).")";
      if (!mysqli_query($con, $query))
      {
        $json = "{\"result\":0,\"error\":".$errors["db write failure"]."}";
      }
      else
      {
        $json = "{\"result\":1}";
      }
      break;
    case 3:
      $query = "UPDATE university_recruitments_unv_rcr SET unv_rcr_date=".sqlstr($date->format("Y-m-d\TH:i:sP")).",unv_rcr_place=".sqlstr($place)." WHERE unv_rcr_unv_id=".sqlstrval($universityid)." AND unv_rcr_unv_cmp_id=".sqlstrval($companyid);
//      echo $query;
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
      $query = "DELETE FROM university_recruitments_unv_rcr WHERE unv_rcr_unv_id=".sqlstrval($universityid)." AND unv_rcr_unv_cmp_id=".sqlstrval($companyid);
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
  echo $json;
  //mysqli_commit($con);
  //mysqli_rollback($con);
  mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

}

?>