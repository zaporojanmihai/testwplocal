<?php
/**
 * Template for displaying search results grouped by parent taxonomies.
 */

get_header(); ?>

<div class="search-results-container">
    <h1><?php printf( esc_html__( 'Search Results for: %s', 'my-wordpress-theme' ), get_search_query() ); ?></h1>

    <div class="taxonomy-tabs">
        <?php
        // Fetch parent taxonomies
        $parent_taxonomies = get_terms( array(
            'taxonomy' => 'resources', // Adjust to your parent taxonomy
            'parent' => 0,
            'hide_empty' => true,
        ) );

        if ( ! empty( $parent_taxonomies ) && ! is_wp_error( $parent_taxonomies ) ) : ?>
            <ul class="tabs">
                <?php foreach ( $parent_taxonomies as $taxonomy ) : ?>
                    <li><a href="#<?php echo esc_attr( $taxonomy->slug ); ?>"><?php echo esc_html( $taxonomy->name ); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="search-results-content">
        <?php
        // Loop through each parent taxonomy
        foreach ( $parent_taxonomies as $taxonomy ) :
            $args = array(
                'post_type' => 'resource', // Adjust to your custom post type
                'tax_query' => array(
                    array(
                        'taxonomy' => 'resources',
                        'field'    => 'slug',
                        'terms'    => $taxonomy->slug,
                    ),
                ),
                's' => get_search_query(),
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) : ?>
                <div id="<?php echo esc_attr( $taxonomy->slug ); ?>" class="taxonomy-group">
                    <h2><?php echo esc_html( $taxonomy->name ); ?></h2>
                    <div class="sorting-filters">
                        <button class="sort-date">Sort by Date</button>
                        <button class="sort-relevance">Sort by Relevance</button>
                    </div>
                    <ul class="results-list">
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <span class="date"><?php echo get_the_date(); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif;

            wp_reset_postdata();
        endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>