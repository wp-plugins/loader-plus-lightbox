<?php 
  
/*
Plugin Name: Loader Plus Lightbox
Plugin URI: http://www.sksphpdev.com/plugins/
Description: This plugin provides an easy way to before all body 'Onload/Bodyload/Windowload/Pageload' first loading show animation and lightbox show . 
i.e. "Please Wait, Loading…"  animation image show for dom (document object model) or full body page/document load than show lightbox after content.
Version: 1.0
Author: SKSPHPDEV
Author URI: http://sksphodev.com/
Min WP Version: 3.6
Max WP Version: 4.0
*/
	
         /*********** Plugin URL Fetch **********************/
        define ( 'LPL_PLUGIN_URL', plugin_dir_url(__FILE__));

            /******** Load JS and CSS Scripts & Style  *******************/
                 function lpl_scripts_load_cdn()
                    {
                        /********** Load JS File *****************/
                        wp_register_script( 'lpl-script', plugins_url( '/js/popup.js', __FILE__ ), array( 'jquery' ) );
                        wp_enqueue_script( 'lpl-script' );
                        
                        /********** Load CSS File *****************/
                         wp_register_style( 'lpl-style', plugins_url( '/css/popup.css', __FILE__ ), array() );
                         wp_enqueue_style( 'lpl-style' );
                    }
                    
                add_action( 'wp_enqueue_scripts', 'lpl_scripts_load_cdn' );
                
        
        
            /******* Load WP Default JQuery ********************/
               function lpl_init_method() {
                    wp_enqueue_script('jquery');
                } 
                           
               add_action('init', 'lpl_init_method');
 
 
 
       /******* Load On Footer Front End ********************/
           function lpl_footer()
            { 
                        
                        if(get_option('lite_option')){
                            
                            $show_lite = "jQuery('#lightbox').show()";
                        
                        if(!get_option('front_onload_check_option'))
                        {?>
                             <script>
                              jQuery(document).ready(function() {
                                  <?php echo $show_lite;?>
                              });
                          </script>
                        <?php 
                        }
                        ?>
                                <style>
                                <?php if(get_option('bg_color_option')){?>
                                #lightbox #content { background: <?php echo esc_attr(get_option('bg_color_option'));?>;}
                                <?php }?>
                                </style>
                 
					<?php
					
					if(get_option('sh_option')){
					
						 
                        /******* Only Home Page Show Lightbox********************/
                         if(is_home() || is_front_page()){
						
							?>
						
							<div id="lightbox">
						   
								<div id="content">
								<p class="alignright boxClose">Click to close</p>
								  <h2><?php echo esc_attr(get_option('title_option'));?></h2><br />
								
								   <?php echo do_shortcode(stripslashes(get_option('short_title_option')));?><br />
							   
								</div>
							</div>
						
							<?php 
                             /******* Copyright Text Show ********************/
                            if(get_option('pb_option')){?>
			 <footer> 	<div class="aligncenter">Loader Plus Lightbox Plugin Developed by <a href='http://sksphpdev.com'>SKSPHPDEV Solutions</a></div></footer>
							<?php } ?>
					
								<?php 
						}
					}
					else
					{
                        /******* All Pages/Posts Show Lightbox********************/
							?>
						
							<div id="lightbox">
						      <div id="content">
								<p id="alignright boxClose">Click to close</p>
								  <h2><?php echo esc_attr(get_option('title_option'));?></h2><br />
								
								   <?php echo do_shortcode(stripslashes(get_option('short_title_option')));?><br />
							   
								</div>
							</div>
						
						<?php 
                         /******* Copyright Text Show ********************/
                        if(get_option('pb_option')){?>
		  <footer>  <div class="aligncenter">Loader Plus Lightbox Plugin Developed by <a href='http://sksphpdev.com'>SKSPHPDEV Solutions</a></div></footer>
							<?php
								} 
			
					}
				}
		
		/************** Onload Animation Show ***************************/
		
                if(get_option('front_onload_check_option')){ 
                    if(get_option('image_location_option'))
                    {
                        $load = get_option('image_location_option');   
                    }
                    else 
                    {
                        
                        $load = plugin_dir_url( __FILE__ ).'/img/loading.gif';
                    }
                
                        $load_color = 'rgb(249,249,249)';	
                    
                            ?>
                              <script>
                                  jQuery(window).load(function() {
                                       jQuery(".loader").fadeOut("slow").after(<?php echo $show_lite;?>);
                                  });
                              </script>
                              <style>.loader{ position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;
                              background: url('<?php echo $load;?>') 50% 50% no-repeat <?php echo  $load_color;?>;}</style>
                              <div class="loader"></div>
                            <?php 
                    }

                }
                
              add_action('wp_footer', 'lpl_footer');
    
      
      
       /******* Menu Laod on Dashboard ********************/
      add_action( 'admin_menu', 'register_lpl_load_menu_page' );

            function register_lpl_load_menu_page(){
                add_menu_page( 'LPL Load Menu', 'LPL Load', 'manage_options', 'lplloadpage', 'lpl_load_menu_page',
                 plugin_dir_url(__FILE__).'img/application.gif' ); 
            }
            
            /******* Function Menu Laod ********************/
            function lpl_load_menu_page(){
                
                if(is_admin()){
							
						wp_register_script( 'lpl-upload', LPL_PLUGIN_URL.'/js/upload.js', array('jquery','media-upload','thickbox') );
						
						wp_enqueue_script('thickbox');
						wp_enqueue_style('thickbox');
				 
						wp_enqueue_script('media-upload');
						wp_enqueue_script('lpl-upload');
						
               
                
                        if($_POST['submit'])
                        {
							
                         update_option( 'front_onload_check_option', $_REQUEST['front_onload_check'] );
                         update_option( 'image_location_option', $_REQUEST['image_location'] );   
                         update_option( 'bg_section_color_option', $_REQUEST['bg_section_color'] );

						   update_option( 'lite_option', $_REQUEST['lite'] );
                         update_option( 'title_option', $_REQUEST['title'] );   
                         update_option( 'bg_section_color_lite_option', $_REQUEST['bg_section_color_lite'] );
						 
						   update_option( 'sh_option', $_REQUEST['sh'] );
						   
						
                       	 update_option( 'short_title_option', $_REQUEST['short_title'] );   
							
						 
						 update_option( 'pb_option', $_REQUEST['pb'] );  
						 update_option( 'bg_color_option', $_REQUEST['bg_color'] ); 
                      
					     echo '<div id="message" class="updated">Update Settings was saved!</div>'; 
                       
					    }
                       
                        if($_POST['reset'] )
                        {
                            
                         update_option( 'front_onload_check_option', '' );
                         update_option( 'image_location_option', '' );   
                         update_option( 'bg_section_color_option', '' );
						 
						  update_option( 'lite_option', '' );
                         update_option( 'title_option', '' );   
                         update_option( 'bg_section_color_lite_option', '' );
						 
						  update_option( 'sh_option', '' );
                         update_option( 'short_title_option', '' );   
                         update_option( 'pb_option', '' );
						 update_option( 'bg_color_option', '' );
						 
                     
					    echo '<div id="message" class="error"> All Settings was reseted!</div>';
                     
					    }
                }
                
                	 wp_enqueue_script('wp-color-picker');
   					 wp_enqueue_style( 'wp-color-picker' );
              
                
                ?>   
                
                     <style>
                     #message { width:54%;margin:5px; padding:5px;}
                     
                        h2:before {
                                content: '\f160';
                                display: inline-block;
                                -webkit-font-smoothing: antialiased;
                                font: normal 29px/1 'dashicons';
                                vertical-align: middle;
                                margin-right: 0.3em;
                                }
                   </style>
                   
                 <div class="wrap">
                 
                 <div id="icon-edit" class="icon32"></div>
                
     <h2><?php _e( 'LPL - Loader Plus Lightbox', 'lpl' ); ?> (V.1.0) <a href="http://www.sksphpdev.com" target="_blank">SKSPHPDEV</a></h2>
              <hr />
            <!-- If we have any error by submiting the form, they will appear here -->
       <table class="form-table">
            <form id="lpl-options" action="" method="post" enctype="multipart/form-data">
      
                   <tr valign="top"> <td colspan="2" style="padding:0px;">
                   
                   <h3 class="title">1. Window Loading Animation</h3> </td></tr>
                  
                  
                 <tr valign="top"> <th scope="row"><label for="front_onload_check">Front load animation show:</label></th>
                    <td><input type="checkbox" id="front_onload_check" name="front_onload_check" <?php if(get_option('front_onload_check_option')){ echo 'checked'; } ?> >
                        Enabled/Disabled
                       </td></tr>
                     
                 <tr valign="top"> <th scope="row"><label for="image_location">Image Upload:</label></th>
                    <td> 
      <input id="image_location" type="text" name="image_location" value="<?php esc_attr_e(get_option('image_location_option'))?>" size="30" />
                  <input  class="lpl-upload-button button" type="button" value="Upload Image" /> <br>
                    <?php if(get_option('image_location_option')){?>   
                 <img src="<?php echo esc_attr_e(get_option('image_location_option'));?>" width="150" />
                 <?php } ?></td></tr>
            
            
                <tr valign="top"> <td colspan="2" style="padding:0px;">
                    <hr />
                   <h3 class="title">2. Lighbox Show</h3> </td></tr>
                   
                <tr valign="top"> <th scope="row">  <label for="lite">Front Lightbox show</label></th>
                   <td> <input type="checkbox" name="lite" <?php if(get_option('lite_option')){ echo 'checked'; } ?> >Enabled/Disabled</td></tr>
                   
                <tr valign="top"> <th scope="row"><label for="title">Title:</label></th>
                  <td><input type="text" id="title" name="title" value="<?php esc_attr_e(get_option('title_option'))?>"></td></tr>
                    
                <tr valign="top"> <th scope="row"><label for="bg_section_color">Choose BG color for lightbox </label></th>  
                    <td>  <input name="bg_section_color" type="text" id="bg_section_color" value="<?php echo get_option('bg_section_color_option');?>" data-default-color="#ffffff">
              </td></tr>
               
                <script type="text/javascript">
                jQuery(document).ready(function($) {   
                    $('#bg_section_color').wpColorPicker();
                });             
                </script>
    
                 <tr valign="top"> <th scope="row"><label for="bg_color">BG Color:</label></th>
                  <td><input type="text" id="bg_color" name="bg_color" value="<?php esc_attr_e(get_option('bg_color_option'))?>"></td></tr>
                  
                 <tr valign="top"> <th scope="row">  <label for="sh">Show only Home page </label></th>
                   <td> <input type="checkbox" name="sh" <?php if(get_option('sh_option')){ echo 'checked'; } ?> >
                  </td></tr>
                   
                 <tr valign="top"> <th scope="row"><label for="short_title">Short Code: </label></th>
                   <td> <input type="text" name="short_title" value="<?php echo esc_attr(stripslashes(get_option('short_title_option')));?>" > For example: "[abc]" Copy short code and paste on this text field.
            </td></tr>
                   
                 <tr valign="top"> <th scope="row"> <label for="pb">Powered by <a href="http://www.sksphpdev.com" target="_blank">SKSPHPDEV</a> </label></th>
                   <td> <input type="checkbox" name="pb" <?php if(get_option('pb_option')){ echo 'checked'; } ?> >
                   </td></tr>
                  
                    <tr valign="top">
                    <th scope="row"></th>
                    <td>
     <input name="submit" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'lpl'); ?>" />
                      <input name="reset" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'lpl'); ?>" />
                      </td></tr>
                     
                 </form>
          </table>
     
                      </div>
                <?php 
            }   