<?php
/**
 * Plugin Name:	Arts Westchester User Taxonomies and Custom Post Types
 * Plugin URI:	http://tadpole.cc
 * Author:		Tadpole Collective LLC
 * Author URI:	http://tadpole.cc
 * Description:	Adds Artist, Teaching Artist and Cultural Orginzation (user) taxonomies.  Creates Artist Opportunities custom post type with its own custom taxonomy. Also modifies default 'author' slug.
 * Version:		0.5.1
 * License:		GPLv2
 *
 *
 * This is heavily inspired by previous work by Justin Tadlock
 * http://justintadlock.com/archives/2011/10/20/custom-user-taxonomies-in-wordpress
 *
 * Contributions by Damian Gostomski
 * http://gostomski.co.uk/code/wordpress-user-taxonomies
 *
 * Tadpole Collective gratefully acknowledges the work of the above developers for inspiration and guidance in this plugin.
 *
 */

/** 
 * Remove author slug, replace with 'profile', e.g. https://artswestchester.org/profile/demoartist/
 *
 */
function tc_author_base() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'profile';
}
add_action('init', 'tc_author_base');

/**
 * Registers the 'artist' taxonomy for users.  This is a taxonomy for the 'user' object type rather than a
 * post being the object type.
 */
add_action( 'init', 'tc_register_artist_taxonomy', 0 );

function tc_register_artist_taxonomy() {
	register_taxonomy(
		'artist',
		'user',
		array(
			'public' => true,
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Artist Categories' ),
				'singular_name' => __( 'Artist Category' ),
				'menu_name' => __( 'Artists Categories' ),
				'search_items' => __( 'Search Artist Categories' ),
				'popular_items' => __( 'Popular Artist Categories' ),
				'all_items' => __( 'All Artist Categories' ),
				'edit_item' => __( 'Edit Artist Category' ),
				'update_item' => __( 'Update Artist Category' ),
				'add_new_item' => __( 'Add New Artist Category' ),
				'new_item_name' => __( 'New Artist Category Name' ),
				'separate_items_with_commas' => __( 'Separate Artist Categories with commas' ),
				'add_or_remove_items' => __( 'Add or remove Artist Category' ),
				'choose_from_most_used' => __( 'Choose from the most popular Artist Categories' ),
			),
			'rewrite' => array(
				'with_front' => true,
				'slug' => 'artists/directory' // Careful with slugs :^)
			),
			'capabilities' => array(
				'manage_terms' => 'edit_artist', // Using 'edit_users' cap to keep this simple.
				'edit_terms'   => 'edit_artist',
				'delete_terms' => 'edit_artist',
				'assign_terms' => 'assign_artist',
			),
		)
	);
}
/**
 * Registers the 'teaching artist' taxonomy for users.  This is a taxonomy for the 'user' object type rather than a
 * post being the object type. Only admins can add these (designed to be one term).
 */
add_action( 'init', 'tc_register_teachingartist_taxonomy', 0 );
function tc_register_teachingartist_taxonomy() {
    register_taxonomy(
        'teaching_artist',
        'user',
        array(
            'public' => true,
            'hierarchical' => true,
            'labels' => array(
                    'name' => __( 'Teaching Artist Categories' ),
                    'singular_name' => __( 'Teaching Artist Category' ),
                    'menu_name' => __( 'Teaching Artist Categories' ),
                    'search_items' => __( 'Search Teaching Artist Categories' ),
                    'popular_items' => __( 'Popular Teaching Artist Categories' ),
                    'all_items' => __( 'All Teaching Artist Categories' ),
                    'edit_item' => __( 'Edit Teaching Artist Category' ),
                    'update_item' => __( 'Update Teaching Artist Category' ),
                    'add_new_item' => __( 'Add New Teaching Artist Category' ),
                    'new_item_name' => __( 'New Teaching Artist Category Name' ),
                    'separate_items_with_commas' => __( 'Separate Teaching Artists Categories with commas' ),
                    'add_or_remove_items' => __( 'Add or remove Teaching Artist Category' ),
                    'choose_from_most_used' => __( 'Choose from the most popular Teaching Artist Categories' ),
            ),
					'capabilities' => array(
                    'manage_terms' => 'edit_tartist', // Using 'edit_users' cap to keep this simple.
                    'edit_terms'   => 'edit_tartist',
                    'delete_terms' => 'edit_tartist',
                    'assign_terms' => 'manage_tartist',
            ),
        )
    );
}
/**
 * Registers the 'culturalorg' taxonomy for users.  This is a taxonomy for the 'user' object type rather than a
 * post being the object type.
 */
add_action( 'init', 'tc_register_culturalorg_taxonomy', 0 );

function tc_register_culturalorg_taxonomy() {
	register_taxonomy(
		'culturalorg',
		'user',
		array(
			'public' => true,
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Cultural Organization Categories' ),
				'singular_name' => __( 'Cultural Organization Category' ),
				'menu_name' => __( 'Cultural Organization Categories' ),
				'search_items' => __( 'Search Cultural Organization Categories' ),
				'popular_items' => __( 'Popular Cultural Organization Categories' ),
				'all_items' => __( 'All Cultural Organization Categories' ),
				'edit_item' => __( 'Edit Cultural Organization Categories' ),
				'update_item' => __( 'Update Cultural Organization Category' ),
				'add_new_item' => __( 'Add New Cultural Organization Category' ),
				'new_item_name' => __( 'New Cultural Organization Category Name' ),
				'separate_items_with_commas' => __( 'Separate Cultural Organization Categories with commas' ),
				'add_or_remove_items' => __( 'Add or remove Cultural Organization Categories' ),
				'choose_from_most_used' => __( 'Choose from the most popular Cultural Organization Categories' ),
			),
			'rewrite' => array(
				'with_front' => true,
				'slug' => 'cultural-organizations/directory' // Careful with slugs :^)
			),
			'capabilities' => array(
				'manage_terms' => 'edit_culturalorg', // Using 'edit_users' cap to keep this simple.
				'edit_terms'   => 'edit_culturalorg',
				'delete_terms' => 'edit_culturalorg',
				'assign_terms' => 'assign_culturalorg',
			),
		)
	);
}

class DJG_UserTaxonomies {
	private static $taxonomies	= array();

	/**
	 * Register all the hooks and filters we can in advance
	 * Some will need to be registered later on, as they require knowledge of the taxonomy name
	 */
	public function __construct() {
		// Taxonomies
		add_action('registered_taxonomy',		array($this, 'registered_taxonomy'), 10, 3);

		// Menus
		add_action('admin_menu',				array($this, 'admin_menu'));
		add_filter('parent_file',				array($this, 'parent_menu'));

		// User Profiles
		add_action('show_user_profile',			array($this, 'user_profile'));
		add_action('edit_user_profile',			array($this, 'user_profile'));
		add_action('personal_options_update',	array($this, 'save_profile'));
		add_action('edit_user_profile_update',	array($this, 'save_profile'));
		add_filter('sanitize_user',				array($this, 'restrict_username'));
	}

	/**
	 * This is our way into manipulating registered taxonomies
	 * It's fired at the end of the register_taxonomy function
	 *
	 * @param String $taxonomy	- The name of the taxonomy being registered
	 * @param String $object	- The object type the taxonomy is for; We only care if this is "user"
	 * @param Array $args		- The user supplied + default arguments for registering the taxonomy
	 */
	public function registered_taxonomy($taxonomy, $object, $args) {
		global $wp_taxonomies;

		// Only modify user taxonomies, everything else can stay as is
		if($object != 'user') return;

		// We're given an array, but expected to work with an object later on
		$args	= (object) $args;

		// Register any hooks/filters that rely on knowing the taxonomy now
		add_filter("manage_edit-{$taxonomy}_columns",	array($this, 'set_user_column'));
		add_action("manage_{$taxonomy}_custom_column",	array($this, 'set_user_column_values'), 10, 3);

		// Set the callback to update the count if not already set
		if(empty($args->update_count_callback)) {
			$args->update_count_callback	= array($this, 'update_count');
		}

		// We're finished, make sure we save out changes
		$wp_taxonomies[$taxonomy]		= $args;
		self::$taxonomies[$taxonomy]	= $args;
	}

	/**
	 * We need to manually update the number of users for a taxonomy term
	 *
	 * @see	_update_post_term_count()
	 * @param Array $terms		- List of Term taxonomy IDs
	 * @param Object $taxonomy	- Current taxonomy object of terms
	 */
	public function update_count($terms, $taxonomy) {
		global $wpdb;

		foreach((array) $terms as $term) {
			$count	= $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term));

			do_action('edit_term_taxonomy', $term, $taxonomy);
			$wpdb->update($wpdb->term_taxonomy, compact('count'), array('term_taxonomy_id'=>$term));
			do_action('edited_term_taxonomy', $term, $taxonomy);
		}
	}

	/**
	 * Add each of the taxonomies to the Users menu
	 * They will behave in the same was as post taxonomies under the Posts menu item
	 * Taxonomies will appear in alphabetical order
	 */
	public function admin_menu() {
		// Put the taxonomies in alphabetical order
		$taxonomies	= self::$taxonomies;
		ksort($taxonomies);

		foreach($taxonomies as $key=>$taxonomy) {
			add_users_page(
				$taxonomy->labels->menu_name,
				$taxonomy->labels->menu_name,
				$taxonomy->cap->manage_terms,
				"edit-tags.php?taxonomy={$key}"
			);
		}
	}

	/**
	 * Fix a bug with highlighting the parent menu item
	 * By default, when on the edit taxonomy page for a user taxonomy, the Posts tab is highlighted
	 * This will correct that bug
	 */
	function parent_menu($parent = '') {
		global $pagenow;

		// If we're editing one of the user taxonomies
		// We must be within the users menu, so highlight that
		if(!empty($_GET['taxonomy']) && $pagenow == 'edit-tags.php' && isset(self::$taxonomies[$_GET['taxonomy']])) {
			$parent	= 'users.php';
		}

		return $parent;
	}

	/**
	 * Correct the column names for user taxonomies
	 * Need to replace "Posts" with "Users"
	 */
	public function set_user_column($columns) {
		unset($columns['posts']);
		$columns['users']	= __('Users');
		return $columns;
	}

	/**
	 * Set values for custom columns in user taxonomies
	 */
	public function set_user_column_values($display, $column, $term_id) {
		if('users' === $column) {
			$term	= get_term($term_id, $_GET['taxonomy']);
			echo $term->count;
		}
	}

	/**
	 * Add the taxonomies to the user view/edit screen
	 *
	 * @param Object $user	- The user of the view/edit screen
	 */
	public function user_profile($user) {
		// Using output buffering as we need to make sure we have something before outputting the header
		// But we can't rely on the number of taxonomies, as capabilities may vary
		ob_start();

		foreach(self::$taxonomies as $key=>$taxonomy):
			// Check the current user can assign terms for this taxonomy
			if(!current_user_can($taxonomy->cap->assign_terms)) continue;

			// Get all the terms in this taxonomy
			$terms = get_terms($key, array('hide_empty'=>false,'parent'=>'0'));
			 
								
			?>
			<table class="form-table">
				<tr>
					<th><label for=""><?php _e("Select {$taxonomy->labels->singular_name}")?></label></th>
					<td>
						<?php if(!empty($terms)):?>
							<?php foreach($terms as $term):?>
								<?php $termchildren = get_term_children( $term->term_id,$term->taxonomy ); ?>
								<label for="<?php echo "{$key}-{$term->slug}"?>">
								<input type="checkbox" name="<?php echo $key?>[]" id="<?php echo "{$key}-{$term->slug}"?>" value="<?php echo $term->slug?>" <?php checked(true, is_object_in_term($user->ID, $key, $term->term_id))?> />
								<?php echo $term->name?></label>
								<?php foreach ( $termchildren as $child ):?>
									<?php $tchild = get_term_by('id',$child,$term->taxonomy);?>
									<label for="<?php echo "{$key}-{$tchild->slug}"?>">
									<input type="checkbox" style="margin-left: 15px;" name="<?php echo $key?>[]" id="<?php echo "{$key}-{$tchild->slug}"?>" value="<?php echo $tchild->slug?>" <?php checked(true, is_object_in_term($user->ID, $key, $tchild->term_id))?> />
									<?php echo $tchild->name?></label>
								<?php endforeach; // Children ?>							
							<?php endforeach; // Terms?>
						<?php else:?>
							<?php _e("There are no {$taxonomy->labels->name} available.")?>
						<?php endif?>
					</td>
				</tr>
			</table>
			<?php
		endforeach; // Taxonomies

		// Output the above if we have anything, with a heading
		$output	= ob_get_clean();
		if(!empty($output)) {
			echo '<h3>', __('Directory Categories'), '</h3>';
			echo $output;
		}
	}

/**
 * Save the custom user taxonomies when saving a users profile
 *
 * @param Integer $user_id	- The ID of the user to update
 */
public function save_profile($user_id) {
	foreach(self::$taxonomies as $key => $taxonomy) {
		// Check the current user can edit this user and assign terms for this taxonomy
		if(!current_user_can('edit_user', $user_id) && current_user_can($taxonomy->cap->assign_terms)) return false;
		// Save the data
		$user_terms = ! is_array($_POST[$key]) ? array($_POST[$key]) : $_POST[$key];
		wp_set_object_terms($user_id, $user_terms, $key, false);
		clean_object_term_cache($user_id, $key);
	}
}

	/**
	 * Usernames can't match any of our user taxonomies
	 * As otherwise it will cause a URL conflict
	 * This method prevents that happening
	 */
	public function restrict_username($username) {
		if(isset(self::$taxonomies[$username])) return '';

		return $username;
	}
}

new DJG_UserTaxonomies;