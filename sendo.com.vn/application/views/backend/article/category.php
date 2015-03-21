<section class="itq-tab">
    <h1>Danh mục</h1>
    <ul>
        <li class="active"><a href="backend/article/category" title="Danh mục">Danh mục</a></li>
        <li><a href="backend/article/addcategory" title="Thêm Danh mục">Thêm Danh mục</a></li>
    </ul>
</section>
<section class="itq-wrapper">
    <section class="itq-view">
        <section class="advanced">
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
                        <th>Tên Danh mục</th>
                        <th>Bài viết</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Người tạo</th>
                        <th>Người sửa</th>
                        <th>Vị trí</th>
                        <th>Menu</th>
                       	<th>Home_left</th>
                      	<th>Home_right</th>
                      
                        <th>Hiển thị</th>
                        <th>Thao tác</th>
                        <th>Mã</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($_list) && count($_list)) { ?>
                    <?php foreach ($_list as $keyList => $valList) { ?>
                            <tr>
                                <td><?php echo($keyList + 1);?></td>
                                <td class="left"><?php echo (str_repeat('|-----', $valList['level']). $valList['title']);?></td>
                                <td class="left"><?php echo get_count_item('article_item', array('parentid' => $valList['id']));?></td>
                                <td><?php echo ($valList['created'] != '0000-00-00 00:00:00') ? gmdate('H: i d/m/y', strtotime($valList['created']) + 7 * 3600) : '-'; ?></td>
                                <td><?php echo ($valList['updated'] != '0000-00-00 00:00:00') ? gmdate('H: i d/m/y', strtotime($valList['updated']) + 7 * 3600) : '-'; // cach in ra dang full datetime// echo gmdate('m-d-Y H: i: s', time() + $valList['updated'] + 7 * 3600);  ?></td>
                                <td><?php $user = get_user($valList['userid_created'], 'username'); echo isset($user['username'])?$user['username']:'-';?></td>
                                <td><?php $user = get_user($valList['userid_updated'], 'username');echo isset($user['username']) ? $user['username'] : '-';?></td>
                                <td><input type="input" name="order[<?php echo $valList['id']; ?>]" value="<?php echo $valList['orders'];?>" class="order"/></td>
                                <?php if($valList['level'] == 1){?>
                                <td><a href="backend/menu/setmenu/article_category/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title="Trạng thái"><img src="public/template/backend/images/<?php echo check_menu('article_category', $valList['id'])?>.png" title="Trạng thái"/></a></td>
                                <?php }else {echo '<td></td>';}?>
                                
                                
                                <?php if($valList['level'] == 1){?>
                               	<td><a href="backend/article/setcategory/home_left/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title="Trạng thái"><img src="public/template/backend/images/<?php echo $valList['home_left'] == 1 ? 'check':'uncheck'?>.png" title="Trạng thái"/></a></td>
                                <?php }else {echo '<td></td>';}?>
                                
                                <?php if($valList['level'] == 1){?>
                                
                                <td><a href="backend/article/setcategory/home_right/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title="Trạng thái"><img src="public/template/backend/images/<?php echo $valList['home_right'] == 1 ? 'check':'uncheck'?>.png" title="Trạng thái"/></a></td>
                                <?php } else {echo '<td></td>';}?>
                                
                                <td><a href="backend/article/setcategory/publish/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title="Trạng thái"><img src="public/template/backend/images/<?php echo $valList['publish'] == 1 ? 'check':'uncheck'?>.png" title="Trạng thái"/></a></td>
                                <td><a href="backend/article/delcategory/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "xóa" onclick="return confirm('Bạn chắc chắn xóa?')"><img src="public/template/backend/images/delete.png" alt="delete" class="delete"/></a><a href="backend/article/editcategory/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "sửa"><img src="public/template/backend/images/edit.png" alt="edit" class="edit"/></a></td>
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