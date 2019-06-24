<?php
/**
 * The template for term archive: Artists.
 *
 * This displays the Artists Directory pages, listing Artists under a Category archive (e.g. "Artists: Literary").
 *
 * @package ArtsWestchester
 * @since ArtsWestchester 1.0
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<a href="<?php echo esc_url( home_url( '/artists/directory/' ) ); ?>" class="directory-crumb">&laquo;Back to directory</a><br />
			<?php $args = array( 'taxonomy' => 'artist' );
			$terms = get_terms('artist', $args);
			$count = count($terms); $i=0;
			if ($count > 0) {
			    $term_list = '<p class="list-term-archive">Categories: ';
			    foreach ($terms as $term) {
			        $i++;
			    	$term_list .= '<a href="' . get_term_link( $term ) . '" title="' . sprintf(__('View all Artists filed under %s', 'arts_west'), $term->name) . '">' . $term->name . '</a>';
			    	if ($count != $i) $term_list .= ' <span class="sep">-</span> '; else $term_list .= '</p>';
			    }
			    echo $term_list;
			} ?>
			<header class="page-header">
				<h1 class="entry-title"><?php printf( __( 'Artists: %s', 'arts_west' ), '' . single_cat_title( '', false ) . '' ); ?></h1>
			</header>
			<div class="entry-content">
				<ul class="profile-cats-list">
					<?php
					$term_id = get_queried_object_id();
					//print_r($term_id);
					$term = get_queried_object();
					//$args = array( 'order' => 'DESC', 'objects_per_page' => 5 );
					//$users = get_objects_in_term( $term_id, $term->taxonomy, $args );
					$users = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT * FROM wpaw_artist where tid = '%d'",$term_id)
						);
					$usercount = $wpdb->get_results(
						$wpdb->prepare(
							"count ID FROM wpaw_artist where tid = '%d'",$term_id)
						);
					//print_r($usercount);
					if ( !empty( $users ) ) {
					?>
						<?php 
						foreach($wpdb->get_results(
						$wpdb->prepare(
							"SELECT * FROM wpaw_artist where tid = '%d' order by display_name ASC;",$term_id)
						) as $key=>$row) {
					$user_id = $row->ID;
					$tid = $row->tid;
					$tname = $row->term;
					$nice_name = $row->nice_name;
					$display_name = $row->display_name;
					$email = $row->email;
					$role = $row->role;
					$taxonomy = $row->taxonomy;
					//print_r($user_id); 	
					?>

							<li class="profile-cat">
								<?php $profile_image = get_user_meta( $user_id, 'default_profile_image' );
									if ( $profile_image ) {
										foreach ( $profile_image as $attachment_id ) {
											$link = get_author_posts_url( $user_id );
											$medium = wp_get_attachment_image( $attachment_id, 'medium', 0, array('class'=>'alignleft') );
											printf( '<a class="img" href="%s">%s</a>', $link, $medium );
										}
									} ?>
								<h2 class="profile-directory"><a href="<?php echo esc_url( get_author_posts_url( $user_id ) ); ?>"><?php the_author_meta( 'display_name', $user_id ); ?></a></h2>
								<?php 
								$author_terms = wp_get_object_terms( $user_id, 'artist' );
								if(!empty($author_terms)){
									if(!is_wp_error( $author_terms )){
										echo '<h3 class="profile-directory">Category: ';
										foreach ($author_terms as $author_term) {
											echo '<a href="'.get_term_link($author_term->slug, 'artist').'">'.$author_term->name.'</a><span class="sep">, </span>';
										}
										echo '</h3>';
									}
								}
								$trim_length = 250;  //desired length of text to display
								$custom_field = 'artist_statement';
								$value = get_user_meta($user_id, $custom_field, true);
								$string = preg_replace('/\s+?(\S+)?$/', '', substr($value, 0, $trim_length));
								if ($value) {
								  echo '<p>' . $string . '...</p>';
								}
								?>
								<p><a class="directory-crumb" href="<?php echo esc_url( get_author_posts_url( $user_id ) ); ?>">View profile&raquo;</a></p>
							</li>

						<?php } ?>
						<?php arts_west_content_nav( 'nav-below' ); ?>
					<?php } ?>
				</ul>
			</div><!-- #entry-content -->
		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>