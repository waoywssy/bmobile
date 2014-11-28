<?php
include_once 'util_global.php';
include_once 'util_data.php';

function manage_university_company($type, $id, $name, $overview, $benefit, $process, $phone, $email, $web, $address)
//function manage_university_company()
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
  if ($type < 1 || $type > 3)
  {
    $type = 1;
  }
  $id = isset($_POST["i"]) ? str2int($_POST["i"]) : 0;
  if ($type == 3 && $id <= 0)
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
  $name = isset($_POST["n"]) ? $_POST["n"] : null;
  if ($type < 3 && is_null($name))
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }
  $overview = isset($_POST["o"]) ? $_POST["o"] : null;
  $benefit = isset($_POST["b"]) ? $_POST["b"] : null;
  $process = isset($_POST["p"]) ? $_POST["p"] : null;
  $phone = isset($_POST["phn"]) ? $_POST["phn"] : null;
  $email = isset($_POST["eml"]) ? $_POST["eml"] : null;
  $web = isset($_POST["web"]) ? $_POST["web"] : null;
  $address = isset($_POST["add"]) ? $_POST["add"] : null;
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
    mysqli_query($con, "LOCK TABLES university_companies_unv_cmp READ");
  }
  else 
  {
    mysqli_query($con, "LOCK TABLES university_companies_unv_cmp WRITE");
  }
*/
  $json = "{\"result\":0,\"error\":".$errors["internal error"]."}";
  switch ($type)
  {
    case 1:
      $query = "SELECT unv_cmp_id, unv_cmp_overview, unv_cmp_benefit, unv_cmp_process, unv_cmp_phone, unv_cmp_email, unv_cmp_web, unv_cmp_address FROM university_companies_unv_cmp WHERE unv_cmp_name=".sqlstr($name);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $unv_cmp_id = $row['unv_cmp_id'];
        $unv_cmp_overview = $row['unv_cmp_overview'];
        $unv_cmp_benefit = $row['unv_cmp_benefit'];
        $unv_cmp_process = $row['unv_cmp_process'];
        $unv_cmp_phone = $row['unv_cmp_phone'];
        $unv_cmp_email = $row['unv_cmp_email'];
        $unv_cmp_web = $row['unv_cmp_web'];
        $unv_cmp_address = $row['unv_cmp_address'];

        mysqli_free_result($result);

        $json = "{\"i\":".sqlstrval($unv_cmp_id).",\"o\":".sqlstr($unv_cmp_overview).",\"b\":".sqlstr($unv_cmp_benefit).",\"p\":".sqlstr($unv_cmp_process).",\"phn\":".sqlstr($unv_cmp_phone).",\"eml\":".sqlstr($unv_cmp_email).",\"web\":".sqlstr($unv_cmp_web).",\"add\":".sqlstr($unv_cmp_address)."}";
      }
      break;
    case 2:
      $query = "INSERT IGNORE INTO university_companies_unv_cmp (unv_cmp_name, unv_cmp_overview, unv_cmp_benefit, unv_cmp_process, unv_cmp_phone, unv_cmp_email, unv_cmp_web, unv_cmp_address) VALUES (".sqlstr($name).",".sqlstr($overview).",".sqlstr($benefit).",".sqlstr($process).",".sqlstr($phone).",".sqlstr($email).",".sqlstr($web).",".sqlstr($address).")";
      mysqli_query($con, $query);

      $query = "SELECT unv_cmp_id FROM university_companies_unv_cmp WHERE unv_cmp_name=".sqlstr($name);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $unv_cmp_id = $row['unv_cmp_id'];

        mysqli_free_result($result);
        $json = "{\"i\":".sqlstrval($unv_cmp_id)."}";
      }
      else
      {
        $json = "{\"result\":0,\"error\":".$errors["db write failure"]."}";
      }
      break;
    case 3:
      $query = "UPDATE university_companies_unv_cmp SET unv_cmp_overview=".sqlstr($overview).",unv_cmp_benefit=".sqlstr($benefit).",unv_cmp_process=".sqlstr($process).",unv_cmp_phone=".sqlstr($phone).",unv_cmp_email=".sqlstr($email).",unv_cmp_web=".sqlstr($web).",unv_cmp_address=".sqlstr($address)." WHERE unv_cmp_id=".sqlstrval($id);
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
