<!-- BEGIN EXAMPLE TABLE PORTLET-->
<form id='form1' name='search' method="post" action="result"> 
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
    <input type="submit" name="submit" value="搜索" />
  </td>
 <tr>
</form>

<!-- END SAMPLE FORM PORTLET-->





