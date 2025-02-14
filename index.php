<?php
get_header(); ?>

<div class="search-results-container">
    <h1><?php printf(__('Search Results for: %s', 'my-wordpress-theme'), get_search_query()); ?></h1>

    <div class="taxonomy-tabs">
        <ul>
            <?php
            // Fetch parent taxonomies
            $parent_taxonomies = get_terms(['taxonomy' => 'resources', 'parent' => 0, 'hide_empty' => true]);
            foreach ($parent_taxonomies as $taxonomy) {
                echo '<li><a href="#' . esc_attr($taxonomy->slug) . '">' . esc_html($taxonomy->name) . '</a></li>';
            }
            ?>
        </ul>
    </div>

    <div class="search-results-content">
        <?php
        // Loop through each parent taxonomy and display results
        foreach ($parent_taxonomies as $taxonomy) {
            echo '<div id="' . esc_attr($taxonomy->slug) . '" class="taxonomy-group">';
            echo '<h2>' . esc_html($taxonomy->name) . '</h2>';

            // Fetch results for this taxonomy using SearchWP
            $results = searchwp_get_results(['taxonomy' => $taxonomy->slug]);
            if ($results) {
                echo '<div class="sorting-filters">';
                echo '<button class="sort-date">Sort by Date</button>';
                echo '<button class="sort-relevance">Sort by Relevance</button>';
                echo '</div>';

                echo '<ul class="results-list">';
                foreach ($results as $result) {
                    echo '<li><a href="' . esc_url(get_permalink($result->ID)) . '">' . esc_html(get_the_title($result->ID)) . '</a></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>' . __('No results found.', 'my-wordpress-theme') . '</p>';
            }
            echo '</div>'; // Close taxonomy-group
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>