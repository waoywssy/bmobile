<script>
	var type = <?php echo $type; ?>;
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
</style>

<?php
global $base_url;
$module_path = drupal_get_path('module','mboryi');
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
<tr><th>职位名</th><th>处理</th></tr>
</thead>
<tbody>
<tr><td>软件测试员</td><td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">处理</button></td></tr>
<tr><td>厨师</td><td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">处理</button></td></tr>
<tr><td>挖掘机司机培训，美容美发</td><td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">处理</button></td></tr>
</tbody>
</table>

<ul class="pagination">
  <li class="disabled"><a href="#">&laquo;</a></li>
  <li class="active"><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">举报处理</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-responsive">
        <thead>
          <tr><th>举报编码</th><th>举报类型</th><th>举报内容</th><th>举报时间</th></tr>
        </thead>
        <tbody>
          <tr><td>213</td><td>虚假信息</td><td>123举报内容123举报内容123举报内容123举报内容123举报内容123举报内容123举报内容123举报内容123</td><td>2014-09-20</td></tr>
          <tr><td>213</td><td>骗子</td><td></td><td>2014-09-20</td></tr>
          <tr><td>213</td><td>重复发布</td><td>234234</td><td>2014-09-20</td></tr>
          <tr><td>213</td><td>重复发布</td><td><a href="#" class="tooltip-test" title="举报内容123" data-original-title="举报内容123">虚假...</a></td><td>2014-09-20</td></tr>
          <tr><td>213</td><td>重复发布</td><td>234234</td><td>2014-09-20</td></tr>
        </tbody>
        </table>
        <form role="form">
          <div class="form-group">
            <label for="result">处理结果</label>
            <div id="result" class="btn-group btn-group-justified">
              <div class="radio">
                <label>
                  <input type="radio" name="results" id="result1" value="1" checked="">
                  同意
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="results" id="result2" value="2" checked="">
                  拒绝
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="results" id="result3" value="3" checked="">
                  都不是
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>