<style>
    .timeline {
        list-style: none;
        padding: 20px 0;
        position: relative;
        margin-top: 30px;
    }
    .timeline:before {
        top: 50px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #e5e5e5;
        left: 0;
        margin-left: -1px;
    }
    .timeline>li {
        margin-bottom: 20px;
        position: relative;
    }
    .timeline>li:after, .timeline>li:before {
        content: " ";
        display: table;
    }
    .timeline>li:after {
        clear: both;
    }
    .timeline>li>.timeline-panel:before {
        position: absolute;
        top: 26px;
        left: -15px;
        right: auto;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 0;
        border-right: 15px solid #e4e4e4;
        border-bottom: 15px solid transparent;
        content: " ";
    }
    .timeline>li>.timeline-panel:after {
        position: absolute;
        top: 27px;
        left: -14px;
        right: auto;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 0;
        border-right: 14px solid #fff;
        border-bottom: 14px solid transparent;
        content: " ";
    }
    .timeline>li>.timeline-badge.danger {
        background-color: #f44336;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(244,67,54,.4);
    }
    .timeline>li>.timeline-badge.success {
        background-color: #4caf50;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(76,175,80,.4);
    }
    .timeline>li>.timeline-badge.info {
        background-color: #00bcd4;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(0,188,212,.4);
        padding: 0;
    }
    .timeline>li>.timeline-badge.warning {
        background-color: #ff9800;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(255,152,0,.4);
    }
    .timeline-heading {
        margin-bottom: 15px;
    }
    .timeline>li>.timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 51px;
        font-size: 1.4em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 0;
        margin-left: -24px;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .timeline>li>.timeline-badge [class=material-icons] {
        line-height: inherit;
    }
    .timeline>li>.timeline-panel {
        margin-left: 45px;
        width: fill-available;
        width: -moz-fill-available;
        width: -webkit-fill-available;
        float: left;
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
        box-shadow: 0 1px 4px 0 rgba(0,0,0,.14);
        border-radius: 6px;
        color: rgba(0,0,0,.87);
        background: #fff;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-12 offset-lg-2 mt-5">
            <div class="card" style="max-width: 100%;">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= __('Index', 'searchili') ?></h4>
                    <p class="card-category"><?= __('Checking the post index status and indexing missing posts.', 'searchili') ?></p>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li id="get_list_of_ids_from_searchili">
                            <div class="timeline-badge info">
                                <i class="material-icons">cloud_download</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5><?= __('Getting list of already indexed content', 'searchili') ?></h5>
                                </div>
                                <div class="timeline-body">
                                    <p><?= __('First we check the content which is already index in SearChili.', 'searchili') ?></p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width:0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="get_list_of_content_need_to_be_indexed">
                            <div class="timeline-badge info">
                                <i class="material-icons">library_books</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5><?= __('Getting list of contents need to be indexed', 'searchili') ?></h5>
                                </div>
                                <div class="timeline-body">
                                    <p><?= __('Here we check the posts/pages on your website which needs to be indexed in SearChili.', 'searchili') ?></p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width:0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="delete_content_should_not_be_indexed">
                            <div class="timeline-badge info">
                                <i class="material-icons">delete_sweep</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5><?= __('Delete content which shouldn\'t be indexed', 'searchili') ?></h5>
                                </div>
                                <div class="timeline-body">
                                    <p><?= __('In case there are some content which are indexed but no longer exist on your website or unpublished, they should be deleted from SearChili.', 'searchili') ?></p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width:0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="index_missing_content">
                            <div class="timeline-badge info">
                                <i class="material-icons">cloud_upload</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5><?= __('Index content which are not indexed', 'searchili') ?></h5>
                                </div>
                                <div class="timeline-body">
                                    <p><?= __('Here we index the content which is publicly available on your website, but not indexed in SearChili.', 'searchili') ?></p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width:0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="reindex_existing_content">
                            <div class="timeline-badge info">
                                <i class="material-icons">cached</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5><?= __('Reindex existing content', 'searchili') ?></h5>
                                </div>
                                <div class="timeline-body">
                                    <p><?= __('In case there are some content which are not updated with the last changes you can reindex them to get the last update.', 'searchili') ?></p>
                                    <div class="progress d-none">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width:0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <a class="btn btn-round btn-success disabled" id="go_home_button" href="<?= esc_url(admin_url('admin.php?page=searchili')) ?>"><?= __('Go Home', 'searchili') ?></a>
                                    <a class="btn btn-round btn-info disabled" id="reindex_button" href="#reindex_existing_content" onclick="reindexExistingContent(this); return false;"><?= __('Reindex', 'searchili') ?></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var alreadyIndexedEntities = []
    var wordpressPublicEntities = []

    function getListOfIDsFromSearChili() {
        let progressbar = jQuery('#get_list_of_ids_from_searchili .progress-bar')
        let timeline_badge = jQuery('#get_list_of_ids_from_searchili>.timeline-badge')
        let timeline_body = jQuery('#get_list_of_ids_from_searchili .timeline-body')
        progressbar.css('width', '5%').attr('aria-valuenow', 5)
        jQuery.post(
            ajaxurl,
            {
                'action': 'admin_ajax_get_list_of_ids_from_searchili',
            },
            function (response, status) {
                if (status === "success" && response.status) {
                    progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
                    timeline_badge.removeClass('info').addClass('success');
                    alreadyIndexedEntities = alreadyIndexedEntities.concat(response.entities)
                    // if (alreadyIndexedEntities.length === 0) {
                    //     timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There\'s no content indexed yet.</small></div>')
                    // } else {
                    //     timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There are already ' + alreadyIndexedEntities.length + ' posts indexed.</small></div>')
                    // }
                    getListOfContentNeedToBeIndexed()
                } else {
                    alert('<?= __('Failed to load list of indexed content in SearChili. please refresh the page and try again.', 'searchili') ?>');
                }
            }
        ).fail(function () {
            alert('<?= __('Failed to load list of indexed content in SearChili. please refresh the page and try again.', 'searchili') ?>');
        });
    }
    function getListOfContentNeedToBeIndexed() {
        let progressbar = jQuery('#get_list_of_content_need_to_be_indexed .progress-bar')
        let timeline_badge = jQuery('#get_list_of_content_need_to_be_indexed>.timeline-badge')
        let timeline_body = jQuery('#get_list_of_content_need_to_be_indexed .timeline-body')
        progressbar.css('width', '5%').attr('aria-valuenow', 5)
        jQuery.post(
            ajaxurl,
            {
                'action': 'admin_ajax_get_list_of_content_need_to_be_indexed',
            },
            function (response, status) {
                if (status === "success" && response.status) {
                    progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
                    timeline_badge.removeClass('info').addClass('success');
                    wordpressPublicEntities = wordpressPublicEntities.concat(response.posts)
                    // if (wordpressPublicEntities.length === 0) {
                    //     timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There\'s no content need to be indexed yet. Make sure you have public posts and pages and check configurations and make sure you want to index posts and pages.</small></div>')
                    // } else {
                    //     timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There are ' + wordpressPublicEntities.length + ' posts and pages need to be indexed.</small></div>')
                    // }
                    setTimeout(function() {
                        deleteContentShouldNotBeIndexed();
                    }, 100);
                } else {
                    alert('<?= __('Failed to load list of content need to be indexed in SearChili. please refresh the page and try again.', 'searchili') ?>');
                }
            }
        ).fail(function () {
            alert('<?= __('Failed to load list of content need to be indexed in SearChili. please refresh the page and try again.', 'searchili') ?>');
        });
    }
    function deleteContentShouldNotBeIndexed() {
        let progressbar = jQuery('#delete_content_should_not_be_indexed .progress-bar')
        let timeline_badge = jQuery('#delete_content_should_not_be_indexed>.timeline-badge')
        let timeline_body = jQuery('#delete_content_should_not_be_indexed .timeline-body')
        progressbar.css('width', '0%').attr('aria-valuenow', 0)
        let needToBeDeletedEntities = alreadyIndexedEntities.filter(x => !wordpressPublicEntities.includes(x));
        if (needToBeDeletedEntities.length === 0) {
            progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
            timeline_badge.removeClass('info').addClass('success');
            // timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There\'s no content need to be deleted from SearChili.</small></div>')
            indexMissingContent()
        } else {
            let successfulDeletes = 0;
            // timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There are ' + needToBeDeletedEntities.length + ' indexes need to be deleted.</small></div>')
            function deleteEntityFromSearChili(index, retry = 0) {
                if (!(index in needToBeDeletedEntities)) {
                    progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
                    timeline_badge.removeClass('info').addClass('success');
                    timeline_body.append('<div class="alert alert-success p-2 mt-2"><small><?= __('Successfully deleted {successfulDeletes} unneeded index.', 'searchili') ?></small></div>'.searChiliFormat({successfulDeletes: successfulDeletes}))
                    indexMissingContent()
                    return
                }
                jQuery.post(
                    ajaxurl,
                    {
                        'action': 'admin_ajax_delete_content_should_not_be_indexed',
                        'entityId': needToBeDeletedEntities[index],
                    },
                    function (response, status) {
                        if (status === "success" && response.status) {
                            successfulDeletes++
                            let progressPercentage = (index / needToBeDeletedEntities.length) * 100
                            progressbar.css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage)
                            deleteEntityFromSearChili(index+1)
                        } else {
                            if (retry < 2) {
                                deleteEntityFromSearChili(index, retry + 1)
                            } else {
                                timeline_body.append('<div class="alert alert-danger p-2 mt-2"><small><?= __('Failed to delete post/page #{entityId}:', 'searchili') ?> {message}</small></div>'.searChiliFormat({entityId: needToBeDeletedEntities[index], message: ('message' in response?response.message:'')}))
                                deleteEntityFromSearChili(index+1)
                            }
                        }
                    }
                ).fail(function () {
                    if (retry < 2) {
                        deleteEntityFromSearChili(index, retry + 1)
                    } else {
                        timeline_body.append('<div class="alert alert-danger p-2 mt-2"><span><small><?= __('Failed to delete post/page #{entityId}:', 'searchili') ?> server error!</small></span></div>'.searChiliFormat({entityId: needToBeDeletedEntities[index]}))
                        deleteEntityFromSearChili(index+1)
                    }
                });
            }
            deleteEntityFromSearChili(0)
        }
    }
    function indexMissingContent() {
        let progressbar = jQuery('#index_missing_content .progress-bar')
        let timeline_badge = jQuery('#index_missing_content>.timeline-badge')
        let timeline_body = jQuery('#index_missing_content .timeline-body')
        progressbar.css('width', '0%').attr('aria-valuenow', 0)
        let needToBeIndexedEntities = wordpressPublicEntities.filter(x => !alreadyIndexedEntities.includes(x));
        if (needToBeIndexedEntities.length === 0) {
            progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
            timeline_badge.removeClass('info').addClass('success');
            jQuery('#reindex_existing_content #go_home_button').removeClass('disabled')
            jQuery('#reindex_existing_content #reindex_button').removeClass('disabled')
            // timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There\'s no new content need to be indexed in SearChili.</small></div>')
        } else {
            let successfulIndexed = 0;
            // timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There are ' + needToBeIndexedEntities.length + ' new content need to be indexed.</small></div>')
            function indexEntityInSearChili(index, retry = 0) {
                if (!(index in needToBeIndexedEntities)) {
                    progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
                    timeline_badge.removeClass('info').addClass('success');
                    timeline_body.append('<div class="alert alert-success p-2 mt-2"><small><?= __('Successfully indexed {successfulIndexed} new content.', 'searchili') ?></small></div>'.searChiliFormat({successfulIndexed: successfulIndexed}))
                    jQuery('#reindex_existing_content #go_home_button').removeClass('disabled')
                    jQuery('#reindex_existing_content #reindex_button').removeClass('disabled')
                    return
                }
                jQuery.post(
                    ajaxurl,
                    {
                        'action': 'admin_ajax_index_missing_content',
                        'entityId': needToBeIndexedEntities[index],
                    },
                    function (response, status) {
                        if (status === "success" && response.status) {
                            successfulIndexed++
                            let progressPercentage = (index / needToBeIndexedEntities.length) * 100
                            progressbar.css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage)
                            indexEntityInSearChili(index+1)
                        } else {
                            if (retry < 2) {
                                indexEntityInSearChili(index, retry + 1)
                            } else {
                                timeline_body.append('<div class="alert alert-danger p-2 mt-2"><small><?= __('Failed to index post/page #{entityId}:', 'searchili') ?> {message}</small></div>'.searChiliFormat({entityId: needToBeIndexedEntities[index], message: ('message' in response?response.message:'')}))
                                indexEntityInSearChili(index+1)
                            }
                        }
                    }
                ).fail(function () {
                    if (retry < 2) {
                        indexEntityInSearChili(index, retry + 1)
                    } else {
                        timeline_body.append('<div class="alert alert-danger p-2 mt-2"><span><small><?= __('Failed to index post/page #{entityId}:', 'searchili') ?>: server error!</small></span></div>'.searChiliFormat({entityId: needToBeIndexedEntities[index]}))
                        indexEntityInSearChili(index+1)
                    }
                });
            }
            indexEntityInSearChili(0)
        }
    }
    function reindexExistingContent(button) {
        jQuery(button).addClass('disabled')
        let progressbar = jQuery('#reindex_existing_content .progress-bar')
        let timeline_badge = jQuery('#reindex_existing_content>.timeline-badge')
        let timeline_body = jQuery('#reindex_existing_content .timeline-body')
        progressbar.css('width', '0%').attr('aria-valuenow', 0)
        progressbar.parent().removeClass('d-none')
        if (wordpressPublicEntities.length === 0) {
            progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
            timeline_badge.removeClass('info').addClass('success');
            // timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There\'s no new content need to be indexed in SearChili.</small></div>')
        } else {
            let successfulIndexed = 0;
            // timeline_body.append('<div class="alert alert-info p-2 mt-2 mb-0"><small>There are ' + needToBeIndexedEntities.length + ' new content need to be indexed.</small></div>')
            function indexEntityInSearChili(index, retry = 0) {
                if (!(index in wordpressPublicEntities)) {
                    progressbar.css('width', '100%').attr('aria-valuenow', 100).removeClass('bg-info progress-bar-animated').addClass('bg-success');
                    timeline_badge.removeClass('info').addClass('success');
                    timeline_body.append('<div class="alert alert-success p-2 mt-2"><small><?= __('Successfully reindexed {successfulIndexed} content.', 'searchili') ?></small></div>'.searChiliFormat({successfulIndexed: successfulIndexed}))
                    return
                }
                jQuery.post(
                    ajaxurl,
                    {
                        'action': 'admin_ajax_index_missing_content',
                        'entityId': wordpressPublicEntities[index],
                    },
                    function (response, status) {
                        if (status === "success" && response.status) {
                            successfulIndexed++
                            let progressPercentage = (index / wordpressPublicEntities.length) * 100
                            progressbar.css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage)
                            indexEntityInSearChili(index+1)
                        } else {
                            if (retry < 2) {
                                indexEntityInSearChili(index, retry + 1)
                            } else {
                                timeline_body.append('<div class="alert alert-danger p-2 mt-2"><small><?= __('Failed to index post/page #{entityId}:', 'searchili') ?>: {message}</small></div>'.searChiliFormat({entityId: wordpressPublicEntities[index], message: ('message' in response?response.message:'')}))
                                indexEntityInSearChili(index+1)
                            }
                        }
                    }
                ).fail(function () {
                    if (retry < 2) {
                        indexEntityInSearChili(index, retry + 1)
                    } else {
                        timeline_body.append('<div class="alert alert-danger p-2 mt-2"><span><small><?= __('Failed to index post/page #{entityId}:', 'searchili') ?>: server error!</small></span></div>'.searChiliFormat({entityId: wordpressPublicEntities[index]}))
                        indexEntityInSearChili(index+1)
                    }
                });
            }
            indexEntityInSearChili(0)
        }
    }
    String.prototype.searChiliFormat = String.prototype.searChiliFormat || function () {
        let str = this.toString();
        if (arguments.length) {
            let t = typeof arguments[0], args = ("string" === t || "number" === t) ? Array.prototype.slice.call(arguments) : arguments[0];
            for (let arg in args) {
                str = str.replace(new RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
            }
        };
        return str;
    };
    jQuery(document).ready(function ($) {
        getListOfIDsFromSearChili();
    });
</script>
