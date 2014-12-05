<?php
function get_university_companies()
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

  $term = isset($_GET["term"]) ? $_GET["term"] : null;
  if (is_null($term))
  {
    echo "{\"result\":0,\"error\":".$errors["missing params"]."}";
    exit;
  }

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }

  mysqli_set_charset($con, "UTF8");

  mysqli_query($con, "LOCK TABLES university_companies_unv_cmp READ");

  $json = "{\"result\":0,\"error\":".$errors["internal error"]."}";
  
  $query = "SELECT unv_cmp_id, unv_cmp_name FROM university_companies_unv_cmp WHERE unv_cmp_name like  '%" . sqlescapequote($term) . "%'";

  if ($result = mysqli_query($con, $query)){
    $output = array();
    $json = "";
    while ($row = mysqli_fetch_array($result))
    {
      $jobs = $jobs.",{\"label\":".jsonstr($row['unv_cmp_name']).",\"value\":".jsonstr($row['unv_cmp_id'])."}";
    }
    $json = '[' . substr($jobs, 1) . ']';
  }
  mysqli_free_result($result);
  
  echo $json;
  //mysqli_commit($con);
  //mysqli_rollback($con);
  //mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
}

?>
