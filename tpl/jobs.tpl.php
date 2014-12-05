<script>
  var company_id = <?php echo $company_id; ?>;
  var company_name = '<?php echo $company_name; ?>';
</script>
<style>
.table {
  table-layout:fixed;
}
.table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
#md-content{
  width:120%!important;
}
</style>
<h3><?php echo $company_name;?></h3>
<button id="search" class="btn btn-success" data-toggle="modal" data-target="#myModal">新岗位</button><br /><br />
<table class="table table-bordered table-striped table-responsive" id="jobs">
<thead>
<tr><th>岗位名</th><th>专业要求</th><th>学历要求</th><th>工作地</th><th>薪资待遇</th><th>招聘人数</th><th>岗位描述</th><th class="col-xs-1">更改</th><th class="col-xs-1">删除</th></tr>
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