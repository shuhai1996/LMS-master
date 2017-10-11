<!-- BEGIN SAMPLE FORM PORTLET-->   

<div class="row">
<div class="col-md-6">
<?php if($label=='has_book') { ?>
<div class="alert alert-warning">
  <strong>Error!</strong>已经有此图书信息
</div>
<?php } ?>
<div class="portlet box green ">
  <div class="portlet-title">
    <div class="caption">
      <i class="fa fa-reorder"></i> Book Edit
    </div>
    <div class="tools">
      <a href="" class="collapse"></a>
      <a href="#portlet-config" data-toggle="modal" class="config"></a>
      <a href="" class="reload"></a>
      <a href="" class="remove"></a>
    </div>
  </div>
  <div class="portlet-body form">
    <form class="form-horizontal" role="form" method='post' action='/main/book/edit'>
      <div class="form-body">
        <div class="form-group">
          <label  class="col-md-3 control-label">图书 ID</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='id' value='<?php echo !empty($entity['bid']) ? htmlspecialchars($entity['bid']):''; ?>' placeholder="<?php echo !empty($entity['bid']) ? htmlspecialchars($entity['bid']):''; ?>" readonly>
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">图书编号</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='bookcode' value='<?php echo !empty($entity['bookcode']) ? htmlspecialchars($entity['bookcode']):''; ?>' placeholder="<?php echo !empty($entity['bookcode']) ? htmlspecialchars($entity['bookcode']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">图书名称</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='bookname' value='<?php echo !empty($entity['bookname']) ? htmlspecialchars($entity['bookname']):''; ?>' placeholder="<?php echo !empty($entity['bookname']) ? htmlspecialchars($entity['bookname']):''; ?>" >
          </div>
        </div>
        <div id='booktype' class="form-group">
          <label  class="col-md-3 control-label">类型</label>
           <div class="col-md-9">
            <select name='typeid' class="form-control">
              <?php foreach ($types as $v) {?>
              <option value="<?php echo htmlspecialchars($v['id'])?>"><?php echo htmlspecialchars($v['name'])?></option>
              <?php }?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">作者</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='author' value='<?php echo !empty($entity['author']) ? htmlspecialchars($entity['author']):''; ?>' placeholder="<?php echo !empty($entity['author']) ? htmlspecialchars($entity['author']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">出版社</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='from' value='<?php echo !empty($entity['from']) ? htmlspecialchars($entity['from']):''; ?>' placeholder="<?php echo !empty($entity['from']) ? htmlspecialchars($entity['from']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">馆藏</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='location' value='<?php echo !empty($entity['location']) ? htmlspecialchars($entity['location']):''; ?>' placeholder="<?php echo !empty($entity['location']) ? htmlspecialchars($entity['location']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">库存</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='stroge' value='<?php echo !empty($entity['stroge']) ? htmlspecialchars($entity['stroge']):''; ?>' placeholder="<?php echo !empty($entity['stroge']) ? htmlspecialchars($entity['stroge']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">页数</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='page' value='<?php echo !empty($entity['page']) ? htmlspecialchars($entity['page']):''; ?>' placeholder="<?php echo !empty($entity['page']) ? htmlspecialchars($entity['page']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">价格</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='price' value='<?php echo !empty($entity['price']) ? htmlspecialchars($entity['price']):''; ?>' placeholder="<?php echo !empty($entity['price']) ? htmlspecialchars($entity['price']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">入库时间</label>
          <div class="col-md-9">
            <input type="text" class="form-control intime"  name='in_time' value='<?php echo !empty($entity['in_time']) ? htmlspecialchars($entity['in_time']):''; ?>' placeholder="<?php echo !empty($entity['in_time']) ? htmlspecialchars($entity['in_time']):''; ?>" >
          </div>
        </div>
      </div>
      <div class="form-actions fluid">
        <div class="col-md-offset-3 col-md-9">
          <input type="submit" name="modify" value="Submit" class="btn green">
          <button id="cancel" type="button" class="btn default">Cancel</button>                              
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<!-- END SAMPLE FORM PORTLET-->

<!-- BEGIN PAGE LEVEL PLUGINS -->
 <link href="/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css"/>
  <script src="/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <script src="/assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>


<!-- END PAGE LEVEL PLUGINS -->

<script type='text/javascript'>
(function($){

	
    $('#booktype select').val('<?php echo isset($entity["typeid"]) ?  htmlspecialchars($entity["typeid"]) : "1";?>');

    $('#cancel').on("click",function(){
        location.href="/main/book/list";
    });

    //日期选择器
    $('.intime').datetimepicker({
   format: 'yyyy-mm-dd',//日期的格式
   autoclose:true,//日期选择完成后是否关闭选择框
   bootcssVer:3,//显示向左向右的箭头
   language:'zh-CN',//语言
   minView: "month",//表示日期选择的最小范围，默认是hour
	});
})(jQuery)
</script>
