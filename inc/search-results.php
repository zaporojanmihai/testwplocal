<?php
function display_search_results() {
    if (isset($_GET['s'])) {
        $search_query = sanitize_text_field($_GET['s']);
        
        // Fetch results using SearchWP
        $results = searchwp()->search($search_query);
        
        // Group results by parent taxonomies
        $grouped_results = [];
        
        foreach ($results as $result) {
            $terms = wp_get_post_terms($result['post']->ID, 'resources');
            foreach ($terms as $term) {
                $parent_term = get_term($term->parent, 'resources');
                if ($parent_term) {
                    $grouped_results[$parent_term->slug][$result['post']->ID] = $result;
                }
            }
        }
        
        // Output results grouped by parent taxonomies
        if (!empty($grouped_results)) {
            echo '<div class="search-results">';
            foreach ($grouped_results as $parent_slug => $posts) {
                echo '<h2>' . esc_html($parent_slug) . '</h2>';
                echo '<div class="tab-content">';
                foreach ($posts as $post_id => $post) {
                    setup_postdata($post['post']);
                    echo '<div class="result-item">';
                    echo '<h3><a href="' . esc_url(get_permalink($post_id)) . '">' . get_the_title($post_id) . '</a></h3>';
                    echo '<p>' . get_the_excerpt($post_id) . '</p>';
                    echo '</div>';
                }
                wp_reset_postdata();
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No results found for your search.</p>';
        }
    }
}
?>