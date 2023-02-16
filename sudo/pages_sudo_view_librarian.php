<?php
    session_start();
    include('assets/config/config.php');
    include('assets/config/checklogin.php');
    check_login();
?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<?php 
    include("assets/inc/head.php");
?>
<body class="disable_transitions sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
        <?php 
            include("assets/inc/nav.php");
        ?>
    <!-- main header end -->

    <!-- main sidebar -->
        <?php 
            include("assets/inc/sidebar.php");
        ?>
    <!-- main sidebar end -->
    <?php
        $librarian_number = $_GET['id'];
        $ret="SELECT * FROM  fmoj_staff WHERE number = ?"; 
        $stmt= $mysqli->prepare($ret) ;
        $stmt->bind_param('s', $librarian_number);
        $stmt->execute() ;//ok
        $res=$stmt->get_result();
        while($row=$res->fetch_object())
        {
            //display default profile picture
            if($row->pic == '')
            {
                $profile_pic = "<img src='assets/img/avatars/user_icon.png' alt='user avatar'/>";
            }
            else
            {
                $profile_pic = "<img src='assets/img/avatars/librarians/$row->pic' alt='user avatar'/>";
            }

            //use .danger, .warning, .success according to account status
            if($row->acc_status == 'Active')
            {
               $account_status = "<span class='md-list-heading uk-text-success'>$row->acc_status</span>";
               

            }
            elseif($row->acc_status == 'Pending')
            {
                $account_status = "<span class='md-list-heading uk-text-warning'>$row->acc_status</span>";
            }
            else
            {
                $account_status = "<span class='md-list-heading uk-text-danger'>$row->acc_status</span>";
            }
    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar hidden-print">
                    <ul id="breadcrumbs">
                        <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                        <li><a href="#">Librarians</a></li>
                        <li><a href="pages_sudo_manage_librarians.php">Manage Librarians</a></li>
                        <li><span><?php echo $row->staff_name;?> Account</span></li>
                    </ul>
                </div>
            <div id="page_content_inner">
                <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading user_heading_bg" style="background-image: url('assets/img/gallery/Image10.jpg')">
                                <div class="bg_overlay">
                                    <div class="user_heading_menu hidden-print">
                                        <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                                    </div>
                                    <div class="user_heading_avatar">
                                        <div class="thumbnail">
                                            <?php
                                                echo $pic;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?php echo $row->staff_name;?></span><span class="sub-heading">Librarian @iLibrary</span></h2>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md-card">
                            <div class="user_heading">
                                <div class="user_heading_menu hidden-print">
                                    <div class="uk-display-inline-block" data-uk-dropdown="{pos:'left-top'}">
                                    </div>
                                </div>
                            </div>
                            <div class="user_content">
                                <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                                    <li class="uk-active"><a href="#"><?php echo $row->staff_name;?> Profile</a></li>
                                    <!--
                                    <li><a href="#">Photos</a></li>
                                    <li><a href="#">Posts</a></li>
                                    -->
                                </ul>
                                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                                    <li>
                                        <?php echo $row->bio;?>
                                        <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                            <div class="uk-width-large-1-2">
                                                <h4 class="heading_c uk-margin-small-bottom">Contact And Personal Info</h4>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->email;?></span>
                                                            <span class="uk-text-small uk-text-muted">Email</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->phone;?></span>
                                                            <span class="uk-text-small uk-text-muted">Phone</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">add_location</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->adr;?></span>
                                                            <span class="uk-text-small uk-text-muted">Address</span>
                                                        </div>
                                                    </li>
                                                    
                                                </ul>
                                            </div>

                                            <div class="uk-width-large-1-2">
                                            <h4 class="heading_c uk-margin-small-bottom"></h4>
                                                <br>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">verified_user</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->number;?></span>
                                                            <span class="uk-text-small uk-text-muted">iLibrary Number</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">settings</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <?php echo $acc_status;?>
                                                            <span class="uk-text-small uk-text-muted">Account Status</span>
                                                        </div>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </li>

                                    <!--
                                    <li>
                                        <div id="user_profile_gallery" data-uk-check-display class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter: 4}">
                                            <div>
                                                <a href="assets/img/gallery/Image01.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image01.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image02.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image02.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image03.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image03.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image04.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image04.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image05.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image05.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image06.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image06.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image07.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image07.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image08.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image08.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image09.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image09.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image10.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image10.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image11.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image11.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image12.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image12.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image13.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image13.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image14.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image14.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image15.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image15.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image16.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image16.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image17.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image17.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image18.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image18.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image19.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image19.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image20.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image20.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image21.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image21.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image22.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image22.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image23.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image23.jpg" alt=""/>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="assets/img/gallery/Image24.jpg" data-uk-lightbox="{group:'user-photos'}">
                                                    <img src="assets/img/gallery/Image24.jpg" alt=""/>
                                                </a>
                                            </div>
                                        </div>
                                        <ul class="uk-pagination uk-margin-large-top">
                                            <li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>
                                            <li class="uk-active"><span>1</span></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><span>&hellip;</span></li>
                                            <li><a href="#">20</a></li>
                                            <li><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="md-list">
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Aut id cupiditate perspiciatis et tempora iste.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">16 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">24</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">119</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Ut fugiat iure iusto laboriosam corrupti.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">04 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">11</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">516</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Sunt aut corporis dolores reiciendis.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">14 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">3</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">305</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Est aspernatur quis odio a eum architecto.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">09 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">12</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">465</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Tempore quaerat in non totam qui ea animi.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">09 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">6</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">426</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Explicabo ad porro ut ut est et consectetur.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">10 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">5</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">271</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Illum error assumenda consequatur est rerum aut.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">09 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">24</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">928</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Vel est non doloremque animi nisi iusto incidunt.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">09 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">6</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">420</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Iure sint aut et quia amet rerum recusandae suscipit.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">23 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">27</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">776</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Autem minus consequatur illum quia odio incidunt beatae.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">23 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">25</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">987</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Cum consequuntur nihil voluptatem dolor omnis eligendi.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">05 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">17</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">267</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Culpa deserunt amet et.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">07 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">8</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">444</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Praesentium et consequatur eum ipsum.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">05 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">1</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">874</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Quo atque illo ad qui praesentium.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">28 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">13</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">539</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Eveniet quis id iste rerum fuga.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">13 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">14</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">317</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Reprehenderit quos quia eius omnis et sit.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">23 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">23</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">502</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Pariatur mollitia id necessitatibus voluptatem et.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">04 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">26</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">265</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Autem impedit nulla distinctio doloribus.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">21 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">25</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">661</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Aut dolor dicta labore numquam.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">19 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">10</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">661</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Ipsum nemo omnis quae omnis veritatis illum amet.</a></span>
                                                    <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">06 Mar 2019</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">20</span>
                                                    </span>
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">222</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--
                    <div class="uk-width-large-3-10 hidden-print">
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-margin-medium-bottom">
                                    <h3 class="heading_c uk-margin-bottom">Alerts</h3>
                                    <ul class="md-list md-list-addon">
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">Deleniti est.</span>
                                                <span class="uk-text-small uk-text-muted uk-text-truncate">Vero officia quos sed rerum repudiandae tempore dignissimos labore.</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">Dignissimos quo.</span>
                                                <span class="uk-text-small uk-text-muted uk-text-truncate">Esse provident qui et necessitatibus ea ipsa.</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">In ea aut.</span>
                                                <span class="uk-text-small uk-text-muted uk-text-truncate">Voluptatem voluptatem libero at deleniti et ut exercitationem.</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <h3 class="heading_c uk-margin-bottom">Friends</h3>
                                <ul class="md-list md-list-addon uk-margin-bottom">
                                    <li>
                                        <div class="md-list-addon-element">
                                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Mr. Aurelio Torphy</span>
                                            <span class="uk-text-small uk-text-muted">Et illum id.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Dr. Deshawn Collier</span>
                                            <span class="uk-text-small uk-text-muted">Explicabo consequatur inventore possimus placeat.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_06_tn.png" alt=""/>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Ressie Cruickshank II</span>
                                            <span class="uk-text-small uk-text-muted">Dignissimos fugit et tempore labore porro.</span>
                                        </div>
                                    </li>
                                </ul>
                                <a class="md-btn md-btn-flat md-btn-flat-primary" href="#">Show all</a>
                            </div>
                        </div>
                    </div>
                    -->

                </div>
            </div>
        </div>
    <?php }?>
    <!--Footer-->
    <?php require_once('assets/inc/footer.php');?>
    <!--Footer-->

    <!-- google web fonts -->
    <!-- <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script> -->

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <!-- <script src="assets/js/altair_admin_common.min.js"></script> -->


    <!-- <script>
        $(function() {
            if(isHighDensity()) {
                $.getScript( "assets/js/custom/dense.min.js", function(data) {
                    // enable hires images
                    altair_helpers.retina_images();
                });
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script> -->
</body>

</html>