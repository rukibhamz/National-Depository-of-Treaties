<aside id="sidebar_main">

    <a href="pages_staff_dashboard.php">
        <div class="sidebar_main_header">
            <div class="sidebar_logo">
                <!-- <a href="pages_staff_dashboard.php" class="sSidebar_hide sidebar_logo_large">
                    <img class="logo_regular" src="../sudo/assets/img/new-logo.png" alt="" height="15" width="71"/>
                    <img class="logo_light" src="../sudo/assets/img/new-logo.png" alt="" height="15" width="71"/>
                </a>
                <a href="pages_staff_dashboard.php" class="sSidebar_show sidebar_logo_small">
                    <img class="logo_regular" src="../sudo/assets/img/new-logo.png" alt="" height="32" width="32"/>
                    <img class="logo_light" src="../sudo/assets/img/new-logo.png" alt="" height="32" width="32"/>
                </a> -->
            </div>
        </div>
    </a>

    <div class="menu_section">
        <ul>
            <!--Dashboard-->
            <li title="Dashboard">
                <a href="pages_staff_dashboard.php">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">Dashboard</span>
                </a>

            </li>

            <!--Book Inventory-->
            <li title="Books Inventory">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE8D2;</i></span>
                    <span class="menu_title">Treaty Inventory</span>
                </a>
                <ul>
                    <li><a href="pages_staff_new_book.php">Upload Treaty</a></li>
                    <li><a href="pages_staff_manage_books.php">Manage Treaty</a></li>
                </ul>

            </li>

            <!--Library Operations-->
            <li title="Library Operations">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE8C0;</i></span>
                    <span class="menu_title">iLibrary Operations</span>
                </a>
                <ul>
                    <li><a href="pages_staff_new_library_book_borrow_operation.php">Borrow Book</a></li>
                    <li><a href="pages_staff_new_library_book_return_operation.php">Return Book</a></li>
                    <li><a href="pages_staff_library_operations_lost_book.php">Lost Books</a></li>
                    <li><a href="pages_staff_library_operations_damanged_book.php">Damanged Books</a></li>
                    <li><a href="pages_staff_manage_library_operations.php">Manage Operations</a></li>

                </ul>

            </li>
            <!--Audits-->
            <li title="Audits">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                    <span class="menu_title">Audits</span>
                </a>
                <ul>
                    <li><a href="pages_staff_audit_treaty_categories.php">Treaty Categories</a></li>
                    <li><a href="pages_staff_audit_books_records.php">Treaty Records</a></li>


                </ul>

            </li>

            <!--password resets-->
            <li title="Password Resets">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">lock</i></span>
                    <span class="menu_title">Password Resets</span>
                </a>
            </li>
        </ul>
    </div>
</aside>