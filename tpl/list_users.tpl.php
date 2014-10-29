<script>
  var type = <?php echo $type; ?>;
  var genders = ["-", "男", "女"]; 
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

<?php
$module_path = drupal_get_path('module','mboryi');
drupal_add_js($module_path . '/js/complaint_types.js');
drupal_add_js($module_path . '/js/jquery.simplePagination.js');
drupal_add_js($module_path . '/js/list_users.js');
?>

<?php if ($type == "3"){ ?> 
<div class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="radio" name="by" id="by1" value="0" checked="">OPENID
    <input type="radio" name="by" id="by2" value="1" checked="">昵称
  </div>
  <div class="form-group">
    <input id="target" type="text" class="form-control" placeholder="搜索">
  </div>
<button class="btn btn-default" id="search">搜索</button>
</div>
<br />
<br />
<?php } ?>

<table class="table table-bordered table-striped table-responsive" id="users">
<thead>
<tr><th>昵称</th><th>性别</th><th>城市</th><th>省份</th><th>国家</th><th>关注时间</th><th>积分</th><th>更改</th></tr>
</thead>
<tbody>
</tbody>
</table>

<ul class="pagination" id="pagination"></ul>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">积分更改窗口</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-responsive" id="credits">
        <thead>
          <tr><th>OPENID</th><th>昵称</th><th>目前积分</th></tr>
        </thead>
        </table>
        <form role="form">
          <div class="form-group">
            <label for="result">增加积分</label>
            <div id="result" class="btn-group btn-group-justified">
              <select>
                <option value="50" selected="selected">50</option>
                <option value="100">100</option>
                <option value="150">150</option>
                <option value="250">250</option>
                <option value="350">350</option>
                <option value="400">400</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="confirm">确认</button>
      </div>
    </div>
  </div>
</div>