<?php
$messages = $this->get_messages();
?>
<div class="wrap">
    <h2><?= __( 'Messages', 'chilisearch' ) ?></h2>
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
                <label for="chilisearch-messages-sayt-init-message"><?= __( 'SAYT initial message', '' ) ?>
                    <input type="text" id="chilisearch-messages-sayt-init-message"
                           name="chilisearch_messages_settings[sayt-init-message]" class="large-text" size="70"
                           value="<?= $messages['sayt-init-message'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-form-submit-value"><?= __( 'Search form submit button', '' ) ?>
                    <input type="text" id="chilisearch-messages-form-submit-value"
                           name="chilisearch_messages_settings[form-submit-value]" class="large-text" size="70"
                           value="<?= $messages['form-submit-value'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-search-result-result-count"><?= __( 'Number of search results and time taken to find in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-search-result-result-count"
                           name="chilisearch_messages_settings[search-result-result-count]" class="large-text" size="70"
                           value="<?= $messages['search-result-result-count'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-next"><?= __( 'Next button in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-next"
                           name="chilisearch_messages_settings[next]" class="large-text" size="70"
                           value="<?= $messages['next'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-prev"><?= __( 'Previous button in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-prev"
                           name="chilisearch_messages_settings[prev]" class="large-text" size="70"
                           value="<?= $messages['prev'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-category"><?= __( 'Category filter in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-category"
                           name="chilisearch_messages_settings[category]" class="large-text" size="70"
                           value="<?= $messages['category'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-price"><?= __( 'Price filter in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-price"
                           name="chilisearch_messages_settings[price]" class="large-text" size="70"
                           value="<?= $messages['price'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-search-between"><?= __( 'Post type filter in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-search-between"
                           name="chilisearch_messages_settings[search-between]" class="large-text" size="70"
                           value="<?= $messages['search-between'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-published"><?= __( 'Published date filter conjunction in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-published"
                           name="chilisearch_messages_settings[published]" class="large-text" size="70"
                           value="<?= $messages['published'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-to"><?= __( 'Published date filter conjunction in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-to"
                           name="chilisearch_messages_settings[to]" class="large-text" size="70"
                           value="<?= $messages['to'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-all"><?= __( 'Search filter in search result page', '' ) ?>
                    <input type="text" id="chilisearch-messages-all"
                           name="chilisearch_messages_settings[all]" class="large-text" size="70"
                           value="<?= $messages['all'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-show-all-n-results"><?= __( 'Show all found result link', '' ) ?>
                    <input type="text" id="chilisearch-messages-show-all-n-results"
                           name="chilisearch_messages_settings[show-all-n-results]" class="large-text" size="70"
                           value="<?= $messages['show-all-n-results'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-voice-search-ready-to-listen"><?= __( 'Voice search ready to listen', '' ) ?>
                    <input type="text" id="chilisearch-messages-voice-search-ready-to-listen"
                           name="chilisearch_messages_settings[voice-search-ready-to-listen]" class="large-text"
                           size="70"
                           value="<?= $messages['voice-search-ready-to-listen'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-voice-search-error-no-result"><?= __( 'Voice search failed to understand', '' ) ?>
                    <input type="text" id="chilisearch-messages-voice-search-error-no-result"
                           name="chilisearch_messages_settings[voice-search-error-no-result]" class="large-text"
                           size="70"
                           value="<?= $messages['voice-search-error-no-result'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-voice-search-listening"><?= __( 'Voice search listening', '' ) ?>
                    <input type="text" id="chilisearch-messages-voice-search-listening"
                           name="chilisearch_messages_settings[voice-search-listening]" class="large-text" size="70"
                           value="<?= $messages['voice-search-listening'] ?>">
                </label>
            </p>

            <p class="description">
                <label for="chilisearch-messages-voice-search-got-it"><?= __( 'Voice search understood', '' ) ?>
                    <input type="text" id="chilisearch-messages-voice-search-got-it"
                           name="chilisearch_messages_settings[voice-search-got-it]" class="large-text" size="70"
                           value="<?= $messages['voice-search-got-it'] ?>">
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
