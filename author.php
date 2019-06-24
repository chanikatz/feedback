<?php get_header(); ?>

<div id="content" class="narrowcolumn">

<!-- This sets the $curauth variable -->

   <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>

    

 

    <ul>
<!-- The Loop -->

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


      <div class="col-sm-3">

<div class="moviebox mejs-overlay-button">
<div class="position:relative; width:100%; z-index:-1;"> <?php the_post_thumbnail(); ?></div>
<?php if ( is_user_logged_in() ) { ?><?php echo do_shortcode('[featured-video-plus]'); ?><div style="position:absolute;top:100px;width:210px; background:#e8e8e8;"><audio controls controlsList="nodownload">
  <source src="<?php the_field('audio_filed'); ?>" type="audio/mpeg">

</audio></div>
		<?php } else { ?>יש להרשם על מנת לצפות בסרט<?php } ?></div>
            
         <p style="text-align:center;"><a href="<?php the_permalink() ?> " target="_blank"><?php the_title(); ?></a></p>
       </div>

    <?php endwhile; else: ?>
        <p style="padding-right:5%;"><?php _e(''); ?>אין קבצים</p>

    <?php endif; ?>

<!-- End Loop -->

    </ul>
</div>
<!--<script>
function playItHere(e, link) {
  var audio = document.createElement("audio");
  var src = document.createElement("source");
  src.src = link.href;
  audio.appendChild(src);
  audio.play();
  e.preventDefault();
}
</script>-->

<?php get_footer(); ?>