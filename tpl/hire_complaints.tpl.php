<script>
	var type = <?php echo $type; ?>;
</script>

<?php
global $base_url;
$module_path = drupal_get_path('module','mboryi');
//drupal_add_css($module_path . '/css/list.css');
drupal_add_js($module_path . '/js/complaints.js');
?>

<!--
<div id="hire">
<?php if ($type == "2"){ ?>
	处理中
<?php } else if ($type == "3"){ ?>
	已处理
<?php } else { ?>
	未处理
<?php } ?>
</div>
-->
<table class="table table-bordered table-striped table-responsive">
<thead>
<tr><th>职位名</th><th>举报类型</th><th>举报时间</th><th>处理</th></tr>
</thead>
<tbody>
<tr><td>123</td><td>213</td><td>231</td><td><button type="button" class="btn btn-default">处理</button></td></tr>
<tr><td>123</td><td>213</td><td>231</td><td><button type="button" class="btn btn-default">处理</button></td></tr>
<tr><td>123</td><td>213</td><td>231</td><td><button type="button" class="btn btn-default">处理</button></td></tr>
</tbody>
</table>
<ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">对话框标题</h3>
  </div>
  <div class="modal-body">
    <p>对话框主体内容 ...…</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button class="btn btn-primary">保存修改</button>
  </div>
</div>