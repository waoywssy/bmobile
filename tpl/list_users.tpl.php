<?php
global $base_url;
$module_path = drupal_get_path('module','mboryi');
//drupal_add_css($module_path . '/css/list.css');
drupal_add_js($module_path . '/js/list_users.js');
?>

<?php if ($type == "3"){ ?>
<form class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="radio" name="results" id="result1" value="0" checked="">OPENID
    <input type="radio" name="results" id="result2" value="1" checked="">昵称
  </div>
  <div class="form-group">
    <input type="text" class="form-control" placeholder="搜索">
  </div>
<button type="submit" class="btn btn-default">搜索</button>
</form>
<br />
<br />
<?php } ?>


<table class="table table-bordered table-striped table-responsive">
<thead>
<tr><th>昵称</th><th>性别</th><th>城市</th><th>省份</th><th>国家</th><th>关注时间</th><th>积分</th><th>更改</th></tr>
</thead>
<tbody>
<tr><td>Soony</td><td>男</td><td>长沙</td><td>湖南</td><td>中国</td><td>2014-09-12 13:00:09</td><td>1250</td><td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">更改</button></td></tr>
<tr><td>Soony00</td><td>男</td><td>乌鲁木齐</td><td>新疆</td><td>中国</td><td>2014-09-12 13:00:09</td><td>0</td><td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">更改</button></td></tr>
<tr><td>Soony01</td><td>男</td><td>上海</td><td>上海</td><td>中国</td><td>2014-09-12 13:00:09</td><td>100</td><td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">更改</button></td></tr>
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
        <h4 class="modal-title" id="myModalLabel">积分更改窗口</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-responsive">
        <thead>
          <tr><th>OPENID</th><th>昵称</th><th>目前积分</th></tr>
        </thead>
        <tbody>
          <tr><td>oFIixt0nt2a5lh9ZDBnPo3XJ440o</td><td>Soony</td><td>1250</td></tr>
        </tbody>
        </table>
        <form role="form">
          <div class="form-group">
            <label for="result">增加积分</label>
            <div id="result" class="btn-group btn-group-justified">
              <select>
                <option value="0">-</option>
                <option value="50">50</option>
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
        <button type="button" class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>