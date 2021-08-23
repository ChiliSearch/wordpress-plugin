<?php
$messages = $this->get_messages();
?>
<div class="wrap">
    <form method="post" action="options.php" id="messages_config">
        <?php wp_nonce_field( 'chilisearch_messages_settings_group-options' ); ?>
        <fieldset>
            <legend><?= __( 'You can edit phrases and messages used in various situations here.', 'chilisearch' ) ?></legend>

            <p class="description">
                <label for="chilisearch-messages-no-result-message"><?= __( '*SAYT message when no relevant result is found', '' ) ?>
                    <input type="text" id="chilisearch-messages-no-result-message"
                           name="chilisearch_messages_settings[no-result-message]" class="large-text" size="70"
                           value="<?= $messages['no-result-message'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-error-message-head"><?= __( 'SAYT message head when there is an error', '' ) ?>
                    <input type="text" id="chilisearch-messages-error-message-head"
                           name="chilisearch_messages_settings[error-message-head]" class="large-text" size="70"
                           value="<?= $messages['error-message-head'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-error-message-body"><?= __( 'SAYT message body when there is an error', '' ) ?>
                    <input type="text" id="chilisearch-messages-error-message-body"
                           name="chilisearch_messages_settings[error-message-body]" class="large-text" size="70"
                           value="<?= $messages['error-message-body'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-input-placeholder"><?= __( 'Search input field placeholder', '' ) ?>
                    <input type="text" id="chilisearch-messages-input-placeholder"
                           name="chilisearch_messages_settings[input-placeholder]" class="large-text" size="70"
                           value="<?= $messages['input-placeholder'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-n-to-m-from-t-results"><?= __( 'Number of search results', '' ) ?>
                    <input type="text" id="chilisearch-messages-n-to-m-from-t-results"
                           name="chilisearch_messages_settings[n-to-m-from-t-results]" class="large-text" size="70"
                           value="<?= $messages['n-to-m-from-t-results'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-results"><?= __( 'Results column header', '' ) ?>
                    <input type="text" id="chilisearch-messages-results"
                           name="chilisearch_messages_settings[results]" class="large-text" size="70"
                           value="<?= $messages['results'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-categories"><?= __( 'Categories facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-categories"
                           name="chilisearch_messages_settings[facet-categories]" class="large-text" size="70"
                           value="<?= $messages['facet-categories'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-tags"><?= __( 'Tags facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-tags"
                           name="chilisearch_messages_settings[facet-tags]" class="large-text" size="70"
                           value="<?= $messages['facet-tags'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-author"><?= __( 'Author facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-author"
                           name="chilisearch_messages_settings[facet-author]" class="large-text" size="70"
                           value="<?= $messages['facet-author'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-brand"><?= __( 'Brand facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-brand"
                           name="chilisearch_messages_settings[facet-brand]" class="large-text" size="70"
                           value="<?= $messages['facet-brand'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-type"><?= __( 'Type facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-type"
                           name="chilisearch_messages_settings[facet-type]" class="large-text" size="70"
                           value="<?= $messages['facet-type'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-price"><?= __( 'Price facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-price"
                           name="chilisearch_messages_settings[facet-price]" class="large-text" size="70"
                           value="<?= $messages['facet-price'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-publishedAt"><?= __( 'Published At facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-publishedAt"
                           name="chilisearch_messages_settings[facet-publishedAt]" class="large-text" size="70"
                           value="<?= $messages['facet-publishedAt'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-facet-status"><?= __( 'Status facet', '' ) ?>
                    <input type="text" id="chilisearch-messages-facet-status"
                           name="chilisearch_messages_settings[facet-status]" class="large-text" size="70"
                           value="<?= $messages['facet-status'] ?>">
                </label>
            </p>
        </fieldset>
        <p>
            <?= __( '*SAYT is standing for Search As You Type.', 'chilisearch' ) ?>
        </p>
        <input type="hidden" name="action" value="admin_ajax_messages_config">
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary"
                   value="<?= __( 'Save Changes' ) ?>">
            <span style="float: none;margin-top: -3px;display: none;" id="spinner" class="spinner is-active"></span>
            <span id="save_result" style="display: none;"></span>
        </p>
    </form>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        let spinner = jQuery('#spinner');
        let save_result = jQuery('#save_result');
        let form = jQuery('#messages_config');
        form.submit(function (e) {
            e.preventDefault();
            spinner.show();
            save_result.hide();
            window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'})
            jQuery('#messages_config button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                form.serialize(),
                function (response) {
                    spinner.hide();
                    jQuery('#messages_config button[type="submit"]').prop('disabled', false);
                    if (response.status) {
                        save_result.text('<?= __( 'Saved!', 'chilisearch' ) ?>').css('color', '#077907').show();
                    } else {
                        save_result.text(response.message).css('color', '#dc0f0f').show();
                    }
                }
            );
            return false;
        });
    });
</script>
