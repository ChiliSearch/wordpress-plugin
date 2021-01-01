<?php
get_header();
?>
<div class="wrap">
	<main id="main" class="searchili-container" role="main">
        <?= do_shortcode( '[searchili_search_page]' ); ?>
	</main>
</div>

<style>
    .searchili-container {
        width: 100%;
        padding: 25px;
        margin: 60px auto;
        background: #fff;
        border-radius: 3px;
        border: 1px solid #eee;
    }

    @media (min-width: 576px) {
        .searchili-container {
            max-width: 540px;
        }
    }

    @media (min-width: 768px) {
        .searchili-container {
            max-width: 720px;
        }
    }

    @media (min-width: 992px) {
        .searchili-container {
            max-width: 960px;
        }
    }

    @media (min-width: 1200px) {
        .searchili-container {
            max-width: 1140px;
        }
    }
</style>

<?php
get_footer();
