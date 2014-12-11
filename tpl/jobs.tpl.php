<script>
  var company_id = <?php echo $company_id; ?>;
  var company_name = '<?php echo $company_name; ?>';
</script>
<style>
.table {
  table-layout:fixed;
}
.table td {
}
.light-gray{
  color:#999
}
/*
  overflow: hidden;
  text-overflow: ellipsis;
*/
#md-content{
  width:120%!important;
}
</style>
<h3><?php echo $company_name;?></h3>
<button id="search" class="btn btn-success" data-toggle="modal" data-target="#myModal">
  <span class="glyphicon glyphicon-plus"></span> 
</button><br /><br />
<div id="msg" class="alert alert-warning fade in" role="alert" style="display:none"></div>
<div id="info" class="alert alert-success fade in" role="alert" style="display:none"></div>
<table class="table table-bordered table-striped table-responsive" id="jobs">
<thead>
<tr><th class="col-xs-5">岗位名 <span class="badge">人数</span> / 工作地</th><th class="col-xs-2">学历</th><th>专业</th><th class="col-xs-1">更改</th><th class="col-xs-1">删除</th></tr>
</thead>
<tbody>
</tbody>
</table>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">工作职位</h4>
      </div>
      <div class="modal-body">
        <div id="modal-msg" class="alert alert-warning fade in" role="alert" style="display:none"></div>
        <div id="modal-info" class="alert alert-success fade in" role="alert" style="display:none"></div>
      <?php
        $form = drupal_get_form('mboryi_job_form');
        hide($form['actions']['submit']);
        echo drupal_render($form);
      ?>
      </div>
      <div class="modal-footer">
      <?php
        $form['actions']['submit']['#attributes']['class'][] = "btn-primary";
        print render($form['actions']['submit']);
      ?>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
      </div>
    </div>
  </div>
</div>