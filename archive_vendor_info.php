<?php
/**
 * The template for displaying archive vendor info
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/archive_vendor_info.php
 *
 * @author      WC Marketplace
 * @package     WCMp/Templates
 * @version   2.2.0
 */
global $WCMp;
$vendor = get_wcmp_vendor($vendor_id);
$vendor_hide_address = apply_filters('wcmp_vendor_store_header_hide_store_address', get_user_meta($vendor_id, '_vendor_hide_address', true), $vendor->id);
$vendor_hide_phone = apply_filters('wcmp_vendor_store_header_hide_store_phone', get_user_meta($vendor_id, '_vendor_hide_phone', true), $vendor->id);
$vendor_hide_email = apply_filters('wcmp_vendor_store_header_hide_store_email', get_user_meta($vendor_id, '_vendor_hide_email', true), $vendor->id);
$template_class = get_wcmp_vendor_settings('wcmp_vendor_shop_template', 'vendor', 'dashboard', 'template1');
$template_class = apply_filters('can_vendor_edit_shop_template', false) && get_user_meta($vendor_id, '_shop_template', true) ? get_user_meta($vendor_id, '_shop_template', true) : $template_class;
?>
<div class="row">
<?php if ( is_user_logged_in() ) { ?>

<?php } else { ?>
<?php echo do_shortcode('[[woo-login-popup]'); ?>
  </div>


<?php } ?>
 <?php
            $vendor_fb_profile = get_user_meta($vendor_id, '_vendor_fb_profile', true);
            $vendor_twitter_profile = get_user_meta($vendor_id, '_vendor_twitter_profile', true);
            $vendor_linkdin_profile = get_user_meta($vendor_id, '_vendor_linkdin_profile', true);
            $vendor_google_plus_profile = get_user_meta($vendor_id, '_vendor_google_plus_profile', true);
            $vendor_youtube = get_user_meta($vendor_id, '_vendor_youtube', true);
            $vendor_instagram = get_user_meta($vendor_id, '_vendor_instagram', true);
            ?>
<div class="vendor_description_background col-sm-8 wcmp_vendor_banner_template <?php echo $template_class; ?>">
    <div class="wcmp_vendor_banner">
        <?php
            if($banner != ''){
        ?>
 
           <video width="100%" height="400"preload controls  poster="<?php echo $banner; ?>">
  <source src=" <?php echo esc_url($vendor_twitter_profile); ?>">" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">

</video>    
        <?php
            } else{
        ?>
  <video width="100%" height="400"preload controls  poster="?php echo $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg'; ?>">
  <source src=" <?php echo esc_url($vendor_twitter_profile); ?>">" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">

</video>    
          
        <?php        
            }
        ?>
   </div>          </div>    
<div class="col-sm-4 cont"><?php echo do_shortcode('[pojo-sidebar id="48"]'); ?> </div>    
 </div>        
        <?php if(apply_filters('wcmp_vendor_store_header_show_social_links', true, $vendor->id)) :?>
        <div class="wcmp_social_profile">
            <?php
            $vendor_fb_profile = get_user_meta($vendor_id, '_vendor_fb_profile', true);
            $vendor_twitter_profile = get_user_meta($vendor_id, '_vendor_twitter_profile', true);
            $vendor_linkdin_profile = get_user_meta($vendor_id, '_vendor_linkdin_profile', true);
            $vendor_google_plus_profile = get_user_meta($vendor_id, '_vendor_google_plus_profile', true);
            $vendor_youtube = get_user_meta($vendor_id, '_vendor_youtube', true);
            $vendor_instagram = get_user_meta($vendor_id, '_vendor_instagram', true);
            ?>
            <?php if ($vendor_fb_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_fb_profile); ?>"><i class="wcmp-font ico-facebook-icon"></i></a><?php } ?>
            <?php if ($vendor_twitter_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_twitter_profile); ?>"><i class="wcmp-font ico-twitter-icon"></i></a><?php } ?>
            <?php if ($vendor_linkdin_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_linkdin_profile); ?>"><i class="wcmp-font ico-linkedin-icon"></i></a><?php } ?>
            <?php if ($vendor_google_plus_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_google_plus_profile); ?>"><i class="wcmp-font ico-google-plus-icon"></i></a><?php } ?>
            <?php if ($vendor_youtube) { ?> <a target="_blank" href="<?php echo esc_url($vendor_youtube); ?>"><i class="wcmp-font ico-youtube-icon"></i></a><?php } ?>
            <?php if ($vendor_instagram) { ?> <a target="_blank" href="<?php echo esc_url($vendor_instagram); ?>"><i class="wcmp-font ico-instagram-icon"></i></a><?php } ?>
        </div>
        <?php endif; ?>

        <?php
            if($template_class == 'template1'){
        ?>
        <div class="row vendor_description">
       <div class="col-sm-4">   <div class="vendor_address">
                    <p class="wcmp_vendor_name"><?php echo $vendor->page_title ?></p>
                    <?php do_action('before_wcmp_vendor_information',$vendor_id);?>
                    <div class="wcmp_vendor_rating">
                        <?php
                        if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
                            $queried_object = get_queried_object();
                            if (isset($queried_object->term_id) && !empty($queried_object)) {
                                $rating_val_array = wcmp_get_vendor_review_info($queried_object->term_id);
                                $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
                            }
                        }
                        ?>      
                    </div>    </div>
     <div class="col-sm-8">   
            <div class="vendor_img_add2">
                <div class="img_div"><img height="400" width="200" src=<?php echo $profile; ?> /></div>
              
                    <?php if (!empty($location) && $vendor_hide_address != 'Enable') { ?><p class="wcmp_vendor_detail"><i class="wcmp-font ico-location-icon"></i><label><?php echo apply_filters('vendor_shop_page_location', $location, $vendor_id); ?></label></p><?php } ?>
                    <?php if (!empty($mobile) && $vendor_hide_phone != 'Enable') { ?><p class="wcmp_vendor_detail"><i class="wcmp-font ico-call-icon"></i><label><?php echo apply_filters('vendor_shop_page_contact', $mobile, $vendor_id); ?></label></p><?php } ?>
                    <?php if (!empty($email) && $vendor_hide_email != 'Enable') { ?><a href="mailto:<?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?>" class="wcmp_vendor_detail"><i class="wcmp-font ico-mail-icon"></i><?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?></a><?php } ?>
                    <?php
                    if (apply_filters('is_vendor_add_external_url_field', true, $vendor->id)) {
                        $external_store_url = get_user_meta($vendor_id, '_vendor_external_store_url', true);
                        $external_store_label = get_user_meta($vendor_id, '_vendor_external_store_label', true);
                        if (empty($external_store_label))
                            $external_store_label = __('External Store URL', 'dc-woocommerce-multi-vendor');
                        if (isset($external_store_url) && !empty($external_store_url)) {
                            ?><p class="external_store_url"><label><a style="color: white;" target="_blank" href="<?php echo apply_filters('vendor_shop_page_external_store', esc_url_raw($external_store_url), $vendor_id); ?>"><?php echo $external_store_label; ?></a></label></p><?php
                            }
                        }
                        ?>
                    <?php do_action('after_wcmp_vendor_information',$vendor_id);?>          
                    <?php
                        $vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor->id);
                        if (!$vendor_hide_description && !empty($description) && $template_class != 'template1') {
                    ?>
                    <div class="description_data"> 22
                        <?php echo htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES ); ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
  

    <?php
        if($template_class != 'template1'){
    ?>

</div></div>
  </div><div>
    <div class="vendor_description">
        <div class="row vendor_img_add2">
<div class="col-sm-4"> 
        
            <div class="vendor_address"> <p class="wcmp_vendor_name"><img src="https://feed-back.co.il/wp-content/uploads/2018/09/user.png"><?php echo $vendor->page_title ?></p>
                <?php do_action('before_wcmp_vendor_information',$vendor_id);?>
                <div class="wcmp_vendor_rating">
                    <?php
                    if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
                        $queried_object = get_queried_object();
                        if (isset($queried_object->term_id) && !empty($queried_object)) {
                            $rating_val_array = wcmp_get_vendor_review_info($queried_object->term_id);
                            $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
                        }
                    }
                    ?>      
                </div>  
                <?php if (!empty($location) && $vendor_hide_address != 'Enable') { ?><p class="wcmp_vendor_detail"><label><?php echo apply_filters('vendor_shop_page_location', $location, $vendor_id); ?></label></p><?php } ?>
                <?php if (!empty($mobile) && $vendor_hide_phone != 'Enable') { ?><p class="wcmp_vendor_detail"><img src="https://feed-back.co.il/wp-content/uploads/2018/09/telephone.png"><label><?php echo apply_filters('vendor_shop_page_contact', $mobile, $vendor_id); ?></label></p><?php } ?>
                <?php if (!empty($email) && $vendor_hide_email != 'Enable') { ?><p  class="wcmp_vendor_detail"><img src="https://feed-back.co.il/wp-content/uploads/2018/09/email.png"><label><?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?></label></p><?php } ?>
                <?php
                if (apply_filters('is_vendor_add_external_url_field', true, $vendor->id)) {
                    $external_store_url = get_user_meta($vendor_id, '_vendor_external_store_url', true);
                    $external_store_label = get_user_meta($vendor_id, '_vendor_external_store_label', true);
                    if (empty($external_store_label))
                        $external_store_label = __('External Store URL', 'dc-woocommerce-multi-vendor');
                    if (isset($external_store_url) && !empty($external_store_url)) {
                        ?><p class="external_store_url"><label><a style="color: white;" target="_blank" href="<?php echo apply_filters('vendor_shop_page_external_store', esc_url_raw($external_store_url), $vendor_id); ?>"><?php echo $external_store_label; ?></a></label></p><?php
                        }
                    }
                    ?>
</div>  </div>  <div class="img_div col-sm-8"><img height="400" width="200" src=<?php echo $profile; ?> />
                <?php do_action('after_wcmp_vendor_information',$vendor_id);?>          
                <?php
                    $vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor->id);
                    if (!$vendor_hide_description && !empty($description) && $template_class != 'template1') {
                ?>
                <div class="description_data"> 
                    <?php echo htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES ); ?>

                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
        }
    ?>

    <?php
        $vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor->id);
        if (!$vendor_hide_description && !empty($description) && $template_class == 'template1') {
    ?>
    <div class="description_data"> 
        <?php echo htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES ); ?>---------------------------
    </div>
    <?php } ?> 
</div>  
-----
<?php echo do_shortcode('[tabby title="תיק עבודות" class="tik"]'); ?>
<div class="autorlooppost row">
<iframe src="https://feed-back.co.il/author/<?php $vendor_userdata = get_userdata( $vendor_id);
echo $vendor_userdata->user_nicename;?><?php echo get_user_meta( $vendor_id, 'user_nicename', true); ?>/" scrolling="no" width="110%" style="overflow-y:hidden!important;" height="800"></iframe>

<a href="https://feed-back.co.il/author/<?php $vendor_userdata = get_userdata( $vendor_id);
echo $vendor_userdata->user_nicename;?>" style="opacity:0;">g</a>
<?php echo get_user_meta( $vendor_id, 'user_nicename', true); ?>
<?php echo $vendor->page_title ?>
<a href="#woo-login-popup-sc-login">התחבר למערכת </a>

</div>
<?php echo do_shortcode('[tabby title="מוצרים" open="yes"]'); ?>

<!--
<div class="tabb"><div class="tik">תיק עבודות</div><div class="mu">מוצרים
</div><div class="fid">פידבק</div><div class="tabbline">----------------</div></div>-->