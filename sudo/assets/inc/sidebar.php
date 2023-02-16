<aside id="sidebar_main">

    <a href="pages_sudo_dashboard.php">
        <div class="sidebar_main_header">
            <div class="sidebar_logo">
                <!-- <a href="pages_sudo_dashboard.php" class="sSidebar_hide sidebar_logo_large">
                    <img class="logo_regular" src="assets/img/new-logo.png" alt="" height="60" width="71" />
                    <img class="logo_light" src="assets/img/new-logo.png" alt="" height="60" width="71" />
                </a>
                <a href="pages_sudo_dashboard.php" class="sSidebar_show sidebar_logo_small">
                    <img class="logo_regular" src="assets/img/new-logo.png" alt="" height="50" width="32" />
                    <img class="logo_light" src="assets/img/new-logo.png" alt="" height="50" width="32" />
                </a> -->
            </div>
        </div>
    </a>

    <div class="menu_section">
        <ul>
            <!--Dashboard-->
            <li title="Dashboard">
                <a href="pages_sudo_dashboard.php">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">Dashboard</span>
                </a>

            </li>
            <li title="Treaties">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE8D4;</i></span>
                    <span class="menu_title">Treaties</span>
                </a>
                <ul>
                    <li><a href="treaty_sudo_submitted_treaties.php">Submitted</a></li>
                    <li><a href="treaty_sudo_published_treaties.php">Published</a></li>
                    <li><a href="treaty_sudo_unpublished_treaties.php">Unpublished</a></li>
                    <li><a href="treaty_sudo_rejected_treaties.php">Rejected</a></li>
                    <li><a href="treaty_sudo_upload_treaties.php">Upload Treaty</a></li>
                </ul>
            </li>
            <!--Upload Access-->
            <li title="Upload Access">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE2C3;</i></span>
                    <span class="menu_title">Upload Access</span>
                </a>
                <ul>
                    <li><a href="treaty_sudo_upload_add_access.php">Add</a></li>
                    <li><a href="treaty_sudo_upload_manage_access.php">Manage</a></li>
                </ul>
            </li>
            <!--Manage Category-->
            <li title="Category Access">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE8D2;</i></span>
                    <span class="menu_title">Treaty Categories</span>
                </a>
                <ul>
                    <li><a href="treaty_sudo_add_category.php">Add</a></li>
                    <li><a href="pages_sudo_manage_categories.php">Manage</a></li>
                </ul>
            </li>
            <!--password resets-->
            <li title="Password Resets">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">lock</i></span>
                    <span class="menu_title">Password Resets</span>
                </a>
                <ul>
                    <li><a href="pages_sudo_manage_staff_password_resets.php">Manage uploader</a></li>
                </ul>
            </li>
        </ul>
    </div>
</aside>