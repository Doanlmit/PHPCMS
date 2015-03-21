<section class="itq-tab">
    <h1>Liên kết</h1>
    <ul>
        <li class="active"><a href="backend/link/index" title="liên kết">Liên kết</a></li>
        <li><a href="backend/link/add" title="Thêm liên kết">Thêm liên kết</a></li>
    </ul>
</section>
<section class="itq-wrapper">
    <section class="itq-view">
        <section class="advanced">
            <section class="search">
                <form method="get" action="backend/link/index">
                    <input type="text" maxlength="100" placeholder="Nhập từ khóa tìm kiếm..." name="keyword" class="text" value="<?php echo isset($_keyword) ? htmlentities($_keyword):'';//show ra keyword gõ vào ô Liên kết?>"/>
                    <input type="hidden" name="sort_field" value="<?php echo $_sort['field'];?>"/>
                    <input type="hidden" name="sort_value" value="<?php echo $_sort['value'];?>"/>
                    <input type="submit" class="submit" value="Tìm kiếm"/>	
                </form>
            </section><!--search-->
            <section class="tool">
                <?php if(isset($_list) && count($_list)) { ?>
                    <form method="post" action="">
                        <input type="button" name="order"value="Sắp xếp" onclick="document.getElementById('btnSort').click(); return false;"/>	
                    </form>
                <?php } ?>
            </section><!--tool-->
        </section><!--.advanced-->
        ﻿<section class="table">
            <form method="post">        
            <table cellpadding="0" cellspacing="0" class="main">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Tên liên kết', 'field'=>'title', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'url', 'field'=>'url', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Ngày tạo', 'field'=>'created', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Người tạo</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Vị trí', 'field'=>'orders', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Hiển thị', 'field'=>'publish', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Thao tác</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Mã', 'field'=>'id', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($_list) && count($_list)) { ?>
                    <?php foreach ($_list as $keyList => $valList) { ?>
                            <tr>
                                <td><?php echo (( $keyList + 1) + $_config['per_page'] * ($_page-1)); ?></td>
                                <td class="left"><?php echo $valList['title'];?></td>
                                <td><?php echo $valList['url'];?></td>
                                <td><?php echo ($valList['created'] != '0000-00-00 00:00:00') ? gmdate('H: i d/m/y', strtotime($valList['created']) + 7 * 3600) : '-'; ?></td>
                                <td><?php $user = get_user($valList['userid_created'], 'username');echo isset($user['username']) ? $user['username'] : '-';?></td>
                                <td><input type="input" name="order[<?php echo $valList['id']; ?>]" value="<?php echo $valList['orders'];?>" class="order"/></td>
                                <td><a href="backend/link/setlink/publish/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title="trạng thái"><image src="public/template/backend/images/<?php echo $valList['publish'] == 1 ? 'check':'uncheck'?>.png" title="trạng thái"/></a></td>
                                <td><a href="backend/link/dellink/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "xóa" onclick="return confirm('Bạn chắc chắn xóa?')"><img src="public/template/backend/images/delete.png" alt="delete" class="delete"/></a><a href="backend/link/editlink/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "sửa"><img src="public/template/backend/images/edit.png" alt="check" class="edit"/></a></td>
                                <td class="last"><a href="#"><?php echo $valList['id']; ?></a></td>
                            </tr>
            <?php } ?>
        <?php }else{?>
                <td class="last" colspan="9"><p>Dữ liệu trống</p></td>
        <?php } ?>
     </tbody>
    </table>
   <section class="display-none">
        <input type="submit" name="sort" value="Sắp xếp" id="btnSort"/> 
    </section>
</form><!--.form-->
</section><!--.itq-table-->
<?php echo (isset($pagination) && !empty($pagination)) ? '<section class = "pagination">' . $pagination . '.</section><!--.pagination-->' : ''; ?>
</section><!--.itq-view-->
</section><!--.itq-wraper-->