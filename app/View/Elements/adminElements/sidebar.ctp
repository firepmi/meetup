<!-- Main Sidebar -->
                <div id="sidebar">
                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Brand -->
                            <a href="#" class="sidebar-brand">
								<img  width="50px"  height="50px" src="<?php  echo $this->webroot;?>img/meetup_logo.png" alt="logo">
                                <i class="gi gi-flash"></i><span class="sidebar-nav-mini-hide"><strong>MeetUp</strong></span>
                            </a>
                            <!-- END Brand -->

                            <!-- User Info -->
                            <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                                <div class="sidebar-user-avatar">
                                    <a href="<?php echo $this->html->url('/admin/dashboard/index/', true);?>">
									    <img src="<?php  echo $this->webroot;?>img/placeholders/avatars/avatar2.jpg" alt="avatar">
                                    </a>
                                </div>
                                <div class="sidebar-user-name"><?php  if(isset($_SESSION['UserData']['name']) && !empty($_SESSION['UserData']['name'])) { echo $_SESSION['UserData']['name']; } ?></div>
                                <div class="sidebar-user-links">
                                    <a href="<?php echo $this->html->url('/admin/admin/logout/', true);?>" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="gi gi-exit"></i></a>
                                </div>
                            </div>
                            <!-- END User Info -->

                            <!-- Sidebar Navigation --> 
							<ul class="sidebar-nav">
								 <li>
                                    <a href="<?php echo $this->html->url('/admin/dashboard/index/', true);?>"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                                </li>
								<li  class="">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Users</span></a>
                                    <ul>
                                        <li>
                                           <a href="<?php echo $this->html->url('/admin/dashboard/manage_users/', true);?>">Manage Users</a>
                                            
                                        </li>
                                        
                                    </ul>
                                </li>
								<li  class="">
								
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Races</span></a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $this->html->url('/admin/dashboard/add_race/', true);?>">Add Race</a> 
                                            <a href="<?php echo $this->html->url('/admin/dashboard/manage_races/', true);?>">Manage Races</a> 
                                        </li>
                                        
                                    </ul>
                                </li>
								<li  class="">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Body Types</span></a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $this->html->url('/admin/dashboard/add_body_type/', true);?>"> Add Body Type</a> 
                                            <a href="<?php echo $this->html->url('/admin/dashboard/manage_body_types/', true);?>">Manage Body Types</a> 
                                        </li>
                                        
                                    </ul>
                                </li>
								<li  class="">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-envelope sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Contact Data</span></a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $this->html->url('/admin/dashboard/manage_contact_data/', true);?>">Manage Contact Data</a> 
                                        </li>
                                        
                                    </ul>
                                </li>
								<li  class="">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-file sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Pages</span></a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $this->html->url('/admin/dashboard/add_page/', true);?>">Add Page</a> 
                                            <a href="<?php echo $this->html->url('/admin/dashboard/manage_pages/', true);?>">Manage Pages</a> 
                                        </li>
                                        
                                    </ul>
                                </li>
                                <li  class="">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-envelope sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Email Users</span></a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $this->html->url('/admin/dashboard/email_users/', true);?>">Email Users</a> 
                                        </li>
                                        
                                    </ul>
                                </li>
								<li>
                                    <a href="<?php echo $this->html->url('/admin/admin/logout/', true);?>"><i class="gi gi-exit sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Logout</span></a>
                                </li>
								
								

								
								
								</ul>
                            <ul class="sidebar-nav hide">
                                <li>
                                    <a href="index.html" class=" active"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                                </li>
                                <li>
                                    <a href="index2.html"><i class="gi gi-leaf sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard 2</span></a>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-shopping_cart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">eCommerce</span></a>
                                    <ul>
                                        <li>
                                            <a href="page_ecom_dashboard.html">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="page_ecom_orders.html">Orders</a>
                                        </li>
                                        <li>
                                            <a href="page_ecom_order_view.html">Order View</a>
                                        </li>
                                        <li>
                                            <a href="page_ecom_products.html">Products</a>
                                        </li>
                                        <li>
                                            <a href="page_ecom_product_edit.html">Product Edit</a>
                                        </li>
                                        <li>
                                            <a href="page_ecom_customer_view.html">Customer View</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-header">
                                    <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Quick Settings"><i class="gi gi-settings"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Create the most amazing pages with the widget kit!"><i class="gi gi-lightbulb"></i></a></span>
                                    <span class="sidebar-header-title">Widget Kit</span>
                                </li>
                                <li>
                                    <a href="page_widgets_stats.html"><i class="gi gi-charts sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Statistics</span></a>
                                </li>
                                <li>
                                    <a href="page_widgets_social.html"><i class="gi gi-share_alt sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Social</span></a>
                                </li>
                                <li>
                                    <a href="page_widgets_media.html"><i class="gi gi-film sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Media</span></a>
                                </li>
                                <li>
                                    <a href="page_widgets_links.html"><i class="gi gi-link sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Links</span></a>
                                </li>
                                <li class="sidebar-header">
                                    <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Quick Settings"><i class="gi gi-settings"></i></a></span>
                                    <span class="sidebar-header-title">Design Kit</span>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-certificate sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">User Interface</span></a>
                                    <ul>
                                        <li>
                                            <a href="page_ui_grid_blocks.html">Grid &amp; Blocks</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_draggable_blocks.html">Draggable Blocks</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_typography.html">Typography</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_buttons_dropdowns.html">Buttons &amp; Dropdowns</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_navigation_more.html">Navigation &amp; More</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_horizontal_menu.html">Horizontal Menu</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_progress_loading.html">Progress &amp; Loading</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_preloader.html">Page Preloader</a>
                                        </li>
                                        <li>
                                            <a href="page_ui_color_themes.html">Color Themes</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-notes_2 sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Forms</span></a>
                                    <ul>
                                        <li>
                                            <a href="page_forms_general.html">General</a>
                                        </li>
                                        <li>
                                            <a href="page_forms_components.html">Components</a>
                                        </li>
                                        <li>
                                            <a href="page_forms_validation.html">Validation</a>
                                        </li>
                                        <li>
                                            <a href="page_forms_wizard.html">Wizard</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-table sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tables</span></a>
                                    <ul>
                                        <li>
                                            <a href="page_tables_general.html">General</a>
                                        </li>
                                        <li>
                                            <a href="page_tables_responsive.html">Responsive</a>
                                        </li>
                                        <li>
                                            <a href="page_tables_datatables.html">Datatables</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-cup sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Icon Sets</span></a>
                                    <ul>
                                        <li>
                                            <a href="page_icons_fontawesome.html">Font Awesome</a>
                                        </li>
                                        <li>
                                            <a href="page_icons_glyphicons_pro.html">Glyphicons Pro</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-show_big_thumbnails sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Page Layouts</span></a>
                                    <ul>
                                        <li>
                                            <a href="page_layout_static.html">Static</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_fixed_footer.html">Static + Fixed Footer</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_fixed_top.html">Fixed Top Header</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_fixed_top_footer.html">Fixed Top Header + Footer</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_fixed_bottom.html">Fixed Bottom Header</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_fixed_bottom_footer.html">Fixed Bottom Header + Footer</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_main_sidebar_mini.html">Mini Main Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_main_sidebar_partial.html">Partial Main Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_main_sidebar_visible.html">Visible Main Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_alternative_sidebar_partial.html">Partial Alternative Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_alternative_sidebar_visible.html">Visible Alternative Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_no_sidebars.html">No Sidebars</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_both_partial.html">Both Sidebars Partial</a>
                                        </li>
                                        <li>
                                            <a href="page_layout_static_animated.html">Animated Sidebar Transitions</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-header">
                                    <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Quick Settings"><i class="gi gi-settings"></i></a></span>
                                    <span class="sidebar-header-title">Develop Kit</span>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-brush sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Ready Pages</span></a>
                                    <ul>
                                        <li>
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Errors</a>
                                            <ul>
                                                <li>
                                                    <a href="page_ready_400.html">400</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_401.html">401</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_403.html">403</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_404.html">404</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_500.html">500</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_503.html">503</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Get Started</a>
                                            <ul>
                                                <li>
                                                    <a href="page_ready_blank.html">Blank</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_blank_alt.html">Blank Alternative</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="page_ready_search_results.html">Search Results (4)</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_article.html">Article</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_user_profile.html">User Profile</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_contacts.html">Contacts</a>
                                        </li>
                                        <li>
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>e-Learning</a>
                                            <ul>
                                                <li>
                                                    <a href="page_ready_elearning_courses.html">Courses</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_elearning_course_lessons.html">Course - Lessons</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_elearning_course_lesson.html">Course - Lesson Page</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Message Center</a>
                                            <ul>
                                                <li>
                                                    <a href="page_ready_inbox.html">Inbox</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_inbox_compose.html">Compose Message</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_inbox_message.html">View Message</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="page_ready_chat.html">Chat</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_timeline.html">Timeline</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_files.html">Files</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_tickets.html">Tickets</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_bug_tracker.html">Bug Tracker</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_tasks.html">Tasks</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_faq.html">FAQ</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_pricing_tables.html">Pricing Tables</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_invoice.html">Invoice</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_forum.html">Forum (3)</a>
                                        </li>
                                        <li>
                                            <a href="page_ready_coming_soon.html">Coming Soon</a>
                                        </li>
                                        <li>
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Login, Register &amp; Lock</a>
                                            <ul>
                                                <li>
                                                    <a href="login.html">Login</a>
                                                </li>
                                                <li>
                                                    <a href="login_full.html">Login (Full Background)</a>
                                                </li>
                                                <li>
                                                    <a href="login_alt.html">Login 2</a>
                                                </li>
                                                <li>
                                                    <a href="login.html#reminder">Password Reminder</a>
                                                </li>
                                                <li>
                                                    <a href="login_alt.html#reminder">Password Reminder 2</a>
                                                </li>
                                                <li>
                                                    <a href="login.html#register">Register</a>
                                                </li>
                                                <li>
                                                    <a href="login_alt.html#register">Register 2</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_lock_screen.html">Lock Screen</a>
                                                </li>
                                                <li>
                                                    <a href="page_ready_lock_screen_alt.html">Lock Screen 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-wrench sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Components</span></a>
                                    <ul>
                                        <li>
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>3 Level Menu</a>
                                            <ul>
                                                <li>
                                                    <a href="#">Link 1</a>
                                                </li>
                                                <li>
                                                    <a href="#">Link 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="page_comp_maps.html">Maps</a>
                                        </li>
                                        <li>
                                            <a href="page_comp_charts.html">Charts</a>
                                        </li>
                                        <li>
                                            <a href="page_comp_gallery.html">Gallery</a>
                                        </li>
                                        <li>
                                            <a href="page_comp_carousel.html">Carousel</a>
                                        </li>
                                        <li>
                                            <a href="page_comp_calendar.html">Calendar</a>
                                        </li>
                                        <li>
                                            <a href="page_comp_animations.html">CSS3 Animations</a>
                                        </li>
                                        <li>
                                            <a href="page_comp_syntax_highlighting.html">Syntax Highlighting</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- END Sidebar Navigation -->

                            <!-- Sidebar Notifications -->
                            <div class="sidebar-header sidebar-nav-mini-hide hide">
                                <span class="sidebar-header-options clearfix">
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Refresh"><i class="gi gi-refresh"></i></a>
                                </span>
                                <span class="sidebar-header-title">Activity hello</span>
                            </div>
                            <div class="sidebar-section sidebar-nav-mini-hide hide">
                                <div class="alert alert-success alert-alt">
                                    <small>5 min ago</small><br>
                                    <i class="fa fa-thumbs-up fa-fw"></i> You had a new sale ($10)
                                </div>
                                <div class="alert alert-info alert-alt">
                                    <small>10 min ago</small><br>
                                    <i class="fa fa-arrow-up fa-fw"></i> Upgraded to Pro plan
                                </div>
                                <div class="alert alert-warning alert-alt">
                                    <small>3 hours ago</small><br>
                                    <i class="fa fa-exclamation fa-fw"></i> Running low on space<br><strong>18GB in use</strong> 2GB left
                                </div>
                                <div class="alert alert-danger alert-alt">
                                    <small>Yesterday</small><br>
                                    <i class="fa fa-bug fa-fw"></i> <a href="javascript:void(0)"><strong>New bug submitted</strong></a>
                                </div>
                            </div>
                            <!-- END Sidebar Notifications -->
                        </div>
                        <!-- END Sidebar Content -->
                    </div>
                    <!-- END Wrapper for scrolling functionality -->
                </div>
                <!-- END Main Sidebar -->