<!-- BEGIN EXAMPLE TABLE PORTLET-->
<form id='form1' name='search' method="post" action="result"> 
  <div hidden>
  <input type="text" name="uid" value="<?php echo htmlspecialchars($this->userInfo["uid"]);?>"/>
  </div>
 <tr>
  <td>关键字&nbsp;:
     <select name="keyword">
         <?php
           $keyword=array('索书号','书名');
           foreach($keyword as $value){
           echo "<option value='".$value."'".($value=="索书号"?"selected":"").">".$value."</option>";
           }
         ?>
      </select>
  </td>
  <td>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="searchword" />
  </td>
  <td>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input id="search" type="button" name="search" value="搜索" />
  </td>
 <tr>
</form>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" style="margin-top:20px !important;">
    <div class="portlet-title">
        <div class="caption"><i class="fa fa-edit"></i>图书</div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-responsive table-hover" id="datatable">
            <thead>
                <tr>
                    <th>编号</th>
                    <th>索书号</th>
                    <th>书名</th>
                    <th>作者</th>
                    <th>出版社</th>
                    <th>类型</th>
                    <th>库存</th>
                    <th>馆藏</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- END SAMPLE FORM PORTLET-->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link rel="stylesheet" href="/assets/plugins/data-tables/DT_bootstrap.css" />
<script type="text/javascript" src="/assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="/assets/plugins/data-tables/DT_bootstrap.js"></script><!-- data table -->

<script src="assets/scripts/table-ajax.js"></script> 
<!-- END PAGE LEVEL PLUGINS -->
<script>
(function($){

  $("#search").click(function(){
    var code="",name="";
    if($("select[ name='keyword' ] ").val()=='索书号')
       code=$(" input[ name='searchword' ] ").val();
    else name=$(" input[ name='searchword' ] ").val();
    $('#datatable').dataTable().fnDestroy();
  var oTable = $('#datatable').dataTable({
        "sDom" : "<'row'<'col-md-6 col-sm-12'l><'col-md-12 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", //default layout without horizontal scroll(remove this setting to enable horizontal scroll for the table)
        "aLengthMenu": [
            [10, 25, 50, 100, -1], // value for ajax
            [10, 25, 50, 100, "All"] // name show on page
        ], // 单页显示行数的下拉列表
        "bProcessing": true, // 打开处理中标签
        "bServerSide": true, // 打开ajax方式获取数据
        "sAjaxSource": "/site/listajax?",
           //如果加上下面这段内容，则使用post方式传递数据
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
            "dataType": 'json',
            "type": "POST",
            "url": sSource,
            "data": {aoData,"code":code,"name":name},
            "success": fnCallback
            } );
           },
        // set the initial value
         // 单页行数的初始值
        "sPaginationType": "bootstrap",
        // oLangeuage 是各个地方的显示形式
        "oLanguage": {
            "sProcessing": '<i class="fa fa-coffee"></i>&nbsp;Please wait...',
            "sLengthMenu": "_MENU_ records",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            },
            "sSearch": "Search All Columns:_INPUT_ "
        },
        // 单列处理
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
        }],
        "aoColumns": [
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          { "bSearchable": true}
        ] ,
       "bFilter":false
       
    });


    });

       //借阅图书jquery
       $('#datatable').delegate('a#btncont','click', function (e) {
        e.preventDefault();

        if (confirm("你确定要借阅这本书吗?") == false) {
            return;
        }

         var reader = $("input[name='uid']").val();
         var bid=$(this).data("id");
         var mydate=new Date();
         var str = "" + mydate.getFullYear() + "-";
            str += (mydate.getMonth()+1) + "-";
            str += mydate.getDate();
         var rentdate=str;
         var backdate=AddDays(mydate,30);

         function AddDays(date,days){
            var nd = new Date(date);
            nd = nd.valueOf();
            nd = nd + days * 24 * 60 * 60 * 1000;
             nd = new Date(nd);
             //alert(nd.getFullYear() + "年" + (nd.getMonth() + 1) + "月" + nd.getDate() + "日");
            var y = nd.getFullYear();
            var m = nd.getMonth()+1;
            var d = nd.getDate();
            if(m <= 9) m = "0"+m;
            if(d <= 9) d = "0"+d; 
            var cdate = y+"-"+m+"-"+d;
            return cdate;
            }

         //alert(backdate);
        //  var jqxhr =$.post(
        //     "/main/borrow/add", 
        //     {"reader": reader,"bid":bid,"rentdate":rentdate,"backdate":backdate},
        //     function(msg) {
        //       $(".result").html(msg);
        //   var data='';
        //   if(msg!=''){
        //     data = eval("("+msg+")");    //将返回的json数据进行解析，并赋给data
        //   }
            
        //      console.log(data); 
        //     //callback(data);  
        //     }, 
        //     "post",
        //     "text",

        // );
        // 
        
        $.ajax({
                    url: "/main/borrow/add",  
                    type: "POST",
                    dataType:"json",
                    async:false,
                    data:{"reader": reader,"bid":bid,"rentdate":rentdate,"backdate":backdate},
                    success: function(data){  
                        var result=data['success'];
                         if(result)alert('成功借阅！');else alert("操作失败或者已借阅该图书！");
                                   },
                    error: function(){  
                        alert('Error loading XML document');  
                    },                   
                   /* ,  
                    success: function(data,status){//如果调用php成功    
                        alert(unescape(data));//解码，显示汉字
                    } */
                });


        // function callback(data) {  
        //     //解析json格式数据  
        //     var result = eval('(' + data.d + ')');  
        //     alert(result.code);  
        // }  
<<<<<<< HEAD
       window.location.href="/main/myborrow/list"
=======
       //window.location.href="/main/myborrow/list"
>>>>>>> bfb691040fd594646e6933b7c65fd8c42f33b25e
    });


  })(jQuery);
</script>










