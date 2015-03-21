<nav class="navigation">
        <ul class="main">
            <li class="main" ><a class="main" href="backend/config/index" title="Cấu hình hệ thống">Hệ thống</a>
                <ul class="item">
                    <li class="item"><a class="item" href="backend/config/index" title="Cấu hình hệ thống">Cấu hình</a></li>
                   <li class="item"><a class="item" href="backend/log/index" title="Nhật ký hệ thống">Nhật ký hệ thống</a></li>
                </ul>
            </li>
            <li class="main"><a class="main" href="backend/user/index" title="Thành viên">Thành viên</a>
                <ul class="item">
                    <li class="item"><a class="item" href="backend/user/group" title="Nhóm thành viên">Nhóm thành viên</a></li>
                    <li class="item"><a class="item" href="backend/user/index" title="Thành viên">Thành viên</a></li>
                </ul>
            </li>
            <li class="main"><a class="main">Module</a>
                <ul class="item">
                   	<li class="item" title="Menu"><a href="backend/menu/index" title="Menu" class="item">Menu</a></li>
                    <li class="item" title="Quảng cáo"><a title="Quảng cáo" class="item" href="backend/adv/index">Quảng cáo</a></li>
                    <li class="item" title="liên kết"><a href="backend/link/index" title="liên kết" class="item">Liên kết</a></li>
                   	<li class="item" title="đối tác"><a href="backend/partner/index" title="đối tác" class="item">Đối tác</a></li>
                   	<li class="item" title="Từ khóa"><a class="item" href="backend/tag/index" title="Từ khóa">Từ khóa</a></li>
                    <li class="item" title="Từ khóa"><a class="item" href="backend/video/index" title="video">Video</a></li>
                    <li class="item"><a class="item" href="#">Hỗ trợ trực tuyến</a></li>
                    <li class="item"><a class="item" href="backend/comment/index">Phản hồi</a></li>
                </ul>
            </li>
            <li class="main"><a class="main" href="backend/article/item" title="Bài viết">Bài viết</a>
                <ul class="item">
                    <li class="item"><a class="item" href="backend/article/category" title="Danh mục">Danh mục</a></li>
                    <li class="item"><a class="item" href="backend/article/item">Bài viết</a></li>
                </ul>
            </li>
            <li class="main"><a class="main" href="#">Sản phẩm</a>
                <ul class="item">
                    <li class="item"><a class="item" href="#">Danh mục</a></li>
                    <li class="item"><a class="item" href="#">Sản phẩm</a></li>
                </ul>
            </li>
            <li class="main"><a class="main" href="#">Phản hồi</a></li>
        </ul>
        <ul class="user-account">
            <li>Chào <strong><?php echo !empty($data['auth']['fullname']) ? $data['auth']['fullname'] : $data['auth']['username']; ?></strong></li>
            <li><a href="backend/account/info" title="Thông tin">Thông tin</a></li>
            <li><a href="backend/auth/logout" title="Đăng xuất">Đăng xuất</a></li>
        </ul>
</nav>