<table class="table responsive table-bordered table-responsive table-condensed">
    <thead>
    <tr>
        <h4 class="widgettitle" style="text-align: center;">商品圖片列表</h4>
    </tr>
    <tr>
        <th align="center">編號</th>
        <th align="center">商品名稱</th>
        <th align="center">封面圖</th>
        <th align="center">新增日期</th>
        <th align="center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $total=7; //預設每筆頁數
    $page=1; //預設初始頁數

    //--------以上兩樣即為 limit 0,3 ==($page,$total)

    if($page<1  || $page=="")
    {
        $page=1; //初始頁數
    }

    if(isset($_GET['page']))
    {
        $page=$_GET['page'];
    }
    $sql = "SELECT * FROM product ORDER BY id DESC";
    $res=mysql_query($sql);
    $row=mysql_num_rows($res); //透過mysql_num_rows()取得總頁數
    $maxpage=ceil($row/$total); //*計算總頁數=(總筆數/每頁筆數)後無條件進位避免 總筆數與總頁數除不盡時剩餘頁無法顯示

    if($page>$maxpage)
    {
        $page=$maxpage; //如果初始頁數大於總頁數就等於總頁數
    }

    $start=$total*($page-1); // 初始頁數 =每筆頁數*(頁預設數-1)
    $sql = "SELECT * FROM product ORDER BY id DESC LIMIT ".$start.",".$total;
    $res=mysql_query($sql); //將查詢資料存到 $result 中
    @$row=mysql_num_rows($res);
    for($i=1;$i<=$row;$i++)
    {
        $ary[$i]=mysql_fetch_array($res);
    }

    for($i=1;$i<=$row;$i++)
    {
        ?>
        <tr align="center">
            <td width="1%" align="center"><?php echo $ary[$i]['id']; ?></td>
            <td width="2%" align="center"><?php echo $ary[$i]['p_name']; ?></td>
            <td width="3%">
                <?php
                $sql2 = "SELECT * FROM product_img WHERE p_id='".$ary[$i]['id']."' AND is_main='1'";
                $res2 = mysql_query($sql2);
                $row2 = mysql_fetch_array($res2);
                ?>
                <img src="<?php echo $row2['picture']; ?>" width="150" height="150">
            </td>
            <td width="3%"><?php echo $row2['added_day']; ?></td>
            <td width="1%">
                <?php
                if($row2['id'] != "")
                {
                    ?>
                    <a href="javascript:void(0);" onclick="edit_fun(<?php echo $ary[$i]['id']; ?>)" class="btn span1"
                       style="color:#fff; background: green;">
                        <i class="iconsweets-bandaid iconsweets-white"></i>修改
                    </a>
                    <?php
                }
                else
                {
                    ?>
                    <a href="javascript:void(0);" onclick="insert_fun(<?php echo $ary[$i]['id']; ?>)" class="btn btn-primary span1"
                       style="color:#fff;">
                        <i class="iconsweets-bandaid iconsweets-white"></i>新增
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    <table width="90%">
        <tr>
            <td align="center">
                <br />
                <?php
                if($page==1){
                    ?>
                    上一頁&nbsp;&nbsp;
                    <?php
                }else{
                    ?>
                    <a style='text-decoration:none;' href="?url=product_img&page=<?php echo $page-1;?>">上一頁&nbsp;&nbsp;</a>
                <?php }?>

                <?php
                echo "<select onChange='location = this.options[this.selectedIndex].value;' class='span1'>";
                for($i=1;$i<=$maxpage;$i++)
                {
                    if($i==$page)
                    {
                        echo "<option selected='selected' value=".$i.">".$i."</option>";
                    }
                    else
                    {
                        echo "<option value=home.php?url=product_img&page=".$i.">".$i."</option>";
                    }
                }
                echo "</select>";
                ?>

                <?php
                if($page==$maxpage){
                    ?>
                    &nbsp;&nbsp;下一頁
                    <?php
                }else{
                    ?>
                    <a style='text-decoration:none;' href="?url=product_img&page=<?php echo $page+1;?>">&nbsp;&nbsp;下一頁</a>
                <?php }?>
                <br />
            </td>
        </tr>
    </table>
</table>

<script>
    function insert_fun(id)
    {
        location.href='home.php?url=add_img&id='+id;
    }

    function edit_fun(id)
    {
        location.href='home.php?url=edit_img&id='+id;
    }
</script>