<?php
$siteInfo       = ChiliSearch::getInstance()->get_website_info();
$documentsCount = isset( $siteInfo['documentsCount'] ) ? esc_html( $siteInfo['documentsCount'] ) : __( 'N/A', 'chilisearch' );
?>
<style>
    .search_page_holder {
        width: 65%;
        margin: 20px auto;
    }
</style>
<div>
    <?php if ( isset( $_GET['get-started'] ) ): ?>
        <div class="notice notice-success is-dismissible" style="margin-top: 20px;">
            <p>
                <strong><?= sprintf( __( '%s documents are indexed and ready to be searched. Here you can try out the power of search!', 'chilisearch' ), $documentsCount ) ?></strong>
            </p>
        </div>
    <?php endif ?>
    <div class="search_page_holder">
        <?= do_shortcode("[chilisearch_search_page]") ?>
    </div>
</div>

