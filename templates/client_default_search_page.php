<?php
get_header();
?>
    <div class="wrap">
        <main id="main" class="chilisearch-container" role="main">
            <?= do_shortcode( '[chilisearch_search_page]' ); ?>
        </main>
    </div>

    <style>
        .chilisearch-container {
            width: 100%;
            padding: 25px;
            margin: 60px auto;
            background: #fff;
            border-radius: 3px;
            border: 1px solid #eee;
        }

        @media (min-width: 576px) {
            .chilisearch-container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .chilisearch-container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .chilisearch-container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .chilisearch-container {
                max-width: 1140px;
            }
        }
    </style>

<?php
get_footer();
