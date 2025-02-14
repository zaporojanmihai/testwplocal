<?php
// Custom functions for enhancing theme functionality

/**
 * Get the parent taxonomies for the resources.
 *
 * @param string $taxonomy
 * @return array
 */
function get_parent_taxonomies($taxonomy) {
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'parent' => 0,
        'hide_empty' => true,
    ]);
    return $terms;
}

/**
 * Sort search results by date or relevance.
 *
 * @param array $results
 * @param string $sort_by
 * @return array
 */
function sort_search_results($results, $sort_by) {
    if ($sort_by === 'date') {
        usort($results, function($a, $b) {
            return strtotime($b->post_date) - strtotime($a->post_date);
        });
    } elseif ($sort_by === 'relevance') {
        // Assuming SearchWP returns results sorted by relevance by default
        // No additional sorting needed
    }
    return $results;
}

/**
 * Display the sorting filter options.
 *
 * @return string
 */
function display_sorting_filter() {
    ob_start();
    ?>
    <select id="sorting-filter" onchange="sortResults(this.value)">
        <option value="relevance">Sort by Relevance</option>
        <option value="date">Sort by Date</option>
    </select>
    <?php
    return ob_get_clean();
}

/**
 * Enqueue scripts and styles for the search results page.
 */
function enqueue_search_results_scripts() {
    if (is_search()) {
        wp_enqueue_script('search-results-script', get_template_directory_uri() . '/assets/js/script.js', ['jquery'], null, true);
        wp_enqueue_style('search-results-style', get_template_directory_uri() . '/assets/css/style.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_search_results_scripts');
?>