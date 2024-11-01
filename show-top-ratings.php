<?php
/*
Plugin Name: Show Top Ratings
Version: 0.2
Plugin URI: http://www.perlworld.org.uk/plugins/show-top-ratings.phps
Author: Gary Turner
Author URI: http://www.perlworld.org.uk
Description: Retrieve a list of top rated posts
*/

/* Quick example 


	<li><?php _e('Top Rated Posts'); ?>
		<ul>
		<?php show_top_ratings(5); ?>
		</ul>
	</li>

*/

/*
GT	2004-11-26	added round() to get rid of those odd ratings
*/

/* Released under the GNU General Public License - http://www.gnu.org/licenses/gpl.html */

function show_top_ratings ($num_posts=5, $rating_first=true, $before='<li>', $after='</li>', $omit_last_after=false) {
if (0 >= $num_posts) { return; }
global $wpdb, $tableposts, $tablepostmeta;

$sql = "SELECT post_title,post_status, avg(meta_value) as rating ";
$sql .= "FROM $tableposts, $tablepostmeta ";
$sql .= "WHERE ID = post_id and meta_key = 'rating' and post_status = 'publish' ";
$sql .= "GROUP BY ID ";
$sql .= "ORDER BY rating DESC LIMIT $num_posts";
$top_posts = $wpdb->get_results($sql);
if (empty($top_posts)) return;

foreach ($top_posts as $post) {
echo $before;
if($rating_first==true) echo '(' . round($post->rating,1) . ') ';
echo '<a title="' . $post->post_title . '" href="' . get_permalink($post->ID). '">';
echo $post->post_title;
echo '</a>';
if($rating_first==false) echo ' (' . round($post->rating,1) . ')';
if (!$omit_last_after) echo $after;
echo "\n";
}
return;
} //end show_top_ratings()

?>

