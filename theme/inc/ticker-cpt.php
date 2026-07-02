<?php
/**
 * ABC Nepal TV — Ticker News (Marquee) System
 * Add this entire block to functions.php
 *
 * Creates a custom post type "abc_ticker" so admins can add short
 * news items, order them, link them, and toggle them on/off.
 * Items show in the date bar marquee on the front end.
 */

/* ───────────────────────────────────────────────
   1. Register Custom Post Type
─────────────────────────────────────────────── */
function abc_register_ticker_cpt() {
    register_post_type( 'abc_ticker', array(
        'labels' => array(
            'name'               => __( 'Ticker News', 'abcnepal-tv' ),
            'singular_name'      => __( 'Ticker Item', 'abcnepal-tv' ),
            'add_new'            => __( 'Add Ticker Item', 'abcnepal-tv' ),
            'add_new_item'       => __( 'Add New Ticker Item', 'abcnepal-tv' ),
            'edit_item'          => __( 'Edit Ticker Item', 'abcnepal-tv' ),
            'all_items'          => __( 'Ticker News', 'abcnepal-tv' ),
            'menu_name'          => __( 'Ticker News', 'abcnepal-tv' ),
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-marker',
        'menu_position'      => 25,
        'supports'           => array( 'title' ),
        'capability_type'    => 'post',
        'hierarchical'       => false,
    ) );
}
add_action( 'init', 'abc_register_ticker_cpt' );

/* ───────────────────────────────────────────────
   2. Metabox: link URL + active toggle + manual order
─────────────────────────────────────────────── */
function abc_ticker_metabox() {
    add_meta_box(
        'abc_ticker_details',
        __( 'Ticker Item Details', 'abcnepal-tv' ),
        'abc_ticker_metabox_html',
        'abc_ticker',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'abc_ticker_metabox' );

function abc_ticker_metabox_html( $post ) {
    wp_nonce_field( 'abc_ticker_save', 'abc_ticker_nonce' );

    $link   = get_post_meta( $post->ID, '_abc_ticker_link', true );
    $order  = get_post_meta( $post->ID, '_abc_ticker_order', true );
    $active = get_post_meta( $post->ID, '_abc_ticker_active', true );
    if ( $active === '' ) $active = '1'; // default ON for new items
    ?>
    <p>
        <label for="abc_ticker_link"><strong><?php _e( 'Link URL (optional)', 'abcnepal-tv' ); ?></strong></label><br>
        <input type="url" id="abc_ticker_link" name="abc_ticker_link"
               value="<?php echo esc_attr( $link ); ?>"
               style="width:100%;" placeholder="https://example.com/full-article" />
    </p>
    <p>
        <label for="abc_ticker_order"><strong><?php _e( 'Display Order', 'abcnepal-tv' ); ?></strong></label><br>
        <input type="number" id="abc_ticker_order" name="abc_ticker_order"
               value="<?php echo esc_attr( $order !== '' ? $order : 10 ); ?>"
               style="width:120px;" step="1" />
        <span class="description"><?php _e( 'Lower numbers show first in the marquee.', 'abcnepal-tv' ); ?></span>
    </p>
    <p>
        <label>
            <input type="checkbox" name="abc_ticker_active" value="1" <?php checked( $active, '1' ); ?> />
            <strong><?php _e( 'Active (show in marquee)', 'abcnepal-tv' ); ?></strong>
        </label>
    </p>
    <?php
}

function abc_ticker_save( $post_id ) {
    if ( ! isset( $_POST['abc_ticker_nonce'] ) || ! wp_verify_nonce( $_POST['abc_ticker_nonce'], 'abc_ticker_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['abc_ticker_link'] ) ) {
        update_post_meta( $post_id, '_abc_ticker_link', sanitize_url( $_POST['abc_ticker_link'] ) );
    }
    if ( isset( $_POST['abc_ticker_order'] ) ) {
        update_post_meta( $post_id, '_abc_ticker_order', intval( $_POST['abc_ticker_order'] ) );
    }
    update_post_meta( $post_id, '_abc_ticker_active', isset( $_POST['abc_ticker_active'] ) ? '1' : '0' );
}
add_action( 'save_post_abc_ticker', 'abc_ticker_save' );

/* ───────────────────────────────────────────────
   3. Admin list columns — show order & status at a glance
─────────────────────────────────────────────── */
function abc_ticker_columns( $columns ) {
    $columns['abc_order']  = __( 'Order', 'abcnepal-tv' );
    $columns['abc_active'] = __( 'Active', 'abcnepal-tv' );
    return $columns;
}
add_filter( 'manage_abc_ticker_posts_columns', 'abc_ticker_columns' );

function abc_ticker_column_content( $column, $post_id ) {
    if ( $column === 'abc_order' ) {
        echo intval( get_post_meta( $post_id, '_abc_ticker_order', true ) );
    }
    if ( $column === 'abc_active' ) {
        $active = get_post_meta( $post_id, '_abc_ticker_active', true );
        echo $active === '1'
            ? '<span style="color:#1a7d1a;font-weight:600;">● ' . __( 'Active', 'abcnepal-tv' ) . '</span>'
            : '<span style="color:#a93226;">● ' . __( 'Hidden', 'abcnepal-tv' ) . '</span>';
    }
}
add_action( 'manage_abc_ticker_posts_custom_column', 'abc_ticker_column_content', 10, 2 );

/* Make the Order column sortable */
add_filter( 'manage_edit-abc_ticker_sortable_columns', function( $columns ) {
    $columns['abc_order'] = 'abc_order';
    return $columns;
});
add_action( 'pre_get_posts', function( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) return;
    if ( $query->get( 'post_type' ) !== 'abc_ticker' ) return;
    if ( $query->get( 'orderby' ) === 'abc_order' ) {
        $query->set( 'meta_key', '_abc_ticker_order' );
        $query->set( 'orderby', 'meta_value_num' );
    } else {
        // Default admin listing also sorted by order for convenience
        $query->set( 'meta_key', '_abc_ticker_order' );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'order', 'ASC' );
    }
});

/* ───────────────────────────────────────────────
   4. Front-end helper — fetch active ticker items, ordered
─────────────────────────────────────────────── */
function abc_get_ticker_items() {
    $items = get_posts( array(
        'post_type'      => 'abc_ticker',
        'post_status'    => 'publish',
        'posts_per_page' => 30,
        'meta_key'       => '_abc_ticker_order',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'   => '_abc_ticker_active',
                'value' => '1',
            ),
        ),
    ) );
    return $items;
}