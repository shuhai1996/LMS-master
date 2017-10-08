
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue">
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
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<!-- BEGIN PAGE LEVEL PLUGINS -->
<link rel="stylesheet" href="/assets/plugins/data-tables/DT_bootstrap.css" />
<script type="text/javascript" src="/assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="/assets/plugins/data-tables/DT_bootstrap.js"></script><!-- data table -->

<script src="assets/scripts/table-ajax.js"></script> 
<!-- END PAGE LEVEL PLUGINS -->

<script>
(function($){
   
    var oTable = $('#datatable').dataTable({
        "sDom" : "<'row'<'col-md-6 col-sm-12'l><'col-md-12 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", //default layout without horizontal scroll(remove this setting to enable horizontal scroll for the table)
        "aLengthMenu": [
            [10, 25, 50, 100, -1], // value for ajax
            [10, 25, 50, 100, "All"] // name show on page
        ], // 单页显示行数的下拉列表
        "bProcessing": true, // 打开处理中标签
        "bServerSide": true, // 打开ajax方式获取数据
        "sAjaxSource": "/site/listajax/",
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
          { "bSearchable": true}
        ] ,
       //"bFilter":false
       
    });
})(jQuery);


</script>
