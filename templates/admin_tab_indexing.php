<style>
    .chili-progress-bar {
        position: relative;
        height: 10px;
        width: 70%;
        margin: 10px auto;
        border-radius: 10px;
        background: #dcdcde;
        background: rgba(0,0,0,.1);
    }
    .chili-progress-bar div {
        height: 10px;
        min-width: 20px;
        width: 0;
        background: #2271b1;
        border-radius: 10px;
        transition: width .3s;
    }
</style>
<div class="card" id="progressbar-holder" style="margin:150px auto 0;">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto;display: block;" width="150px" height="150px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <g transform="translate(50 50)">
            <g transform="translate(-19 -19) scale(0.6)">
                <g>
                    <animateTransform attributeName="transform" type="rotate" values="0;36" keyTimes="0;1" dur="0.2s" begin="0s" repeatCount="indefinite"></animateTransform>
                    <path d="M31.359972760794346 21.46047782418268 L38.431040572659825 28.531545636048154 L28.531545636048154 38.431040572659825 L21.46047782418268 31.359972760794346 A38 38 0 0 1 12.756598534413827 35.79482076825907 L12.756598534413827 35.79482076825907 L14.320943184816137 45.67170417421045 L0.4933064164842036 47.86178668477369 L-1.071038233918106 37.98490327882231 A38 38 0 0 1 -10.719362751275682 36.45675880007113 L-10.719362751275682 36.45675880007113 L-15.25926774867115 45.36682404195481 L-27.733359087308305 39.01095704560115 L-23.193454089912837 30.10089180371747 A38 38 0 0 1 -30.100891803717467 23.19345408991284 L-30.100891803717467 23.19345408991284 L-39.010957045601145 27.73335908730831 L-45.3668240419548 15.259267748671157 L-36.45675880007112 10.719362751275689 A38 38 0 0 1 -37.98490327882231 1.0710382339181128 L-37.98490327882231 1.0710382339181128 L-47.86178668477369 -0.49330641648419493 L-45.67170417421045 -14.320943184816128 L-35.79482076825907 -12.75659853441382 A38 38 0 0 1 -31.35997276079435 -21.460477824182675 L-31.35997276079435 -21.460477824182675 L-38.431040572659825 -28.531545636048147 L-28.53154563604818 -38.4310405726598 L-21.4604778241827 -31.35997276079433 A38 38 0 0 1 -12.756598534413815 -35.79482076825908 L-12.756598534413815 -35.79482076825908 L-14.320943184816125 -45.671704174210454 L-0.493306416484226 -47.86178668477368 L1.0710382339180844 -37.98490327882231 A38 38 0 0 1 10.719362751275693 -36.45675880007112 L10.719362751275693 -36.45675880007112 L15.25926774867116 -45.3668240419548 L27.733359087308287 -39.01095704560117 L23.19345408991282 -30.100891803717484 A38 38 0 0 1 30.10089180371747 -23.193454089912834 L30.10089180371747 -23.193454089912834 L39.010957045601145 -27.733359087308305 L45.36682404195479 -15.259267748671181 L36.456758800071114 -10.71936275127571 A38 38 0 0 1 37.98490327882231 -1.0710382339181006 L37.98490327882231 -1.0710382339181006 L47.86178668477369 0.4933064164842056 L45.67170417421046 14.320943184816105 L35.79482076825908 12.756598534413799 A38 38 0 0 1 31.359972760794346 21.460477824182686 M0 -23A23 23 0 1 0 0 23 A23 23 0 1 0 0 -23" fill="#0a0a0a"></path>
                </g>
            </g>
            <g transform="translate(19 19) scale(0.6)">
                <g>
                    <animateTransform attributeName="transform" type="rotate" values="36;0" keyTimes="0;1" dur="0.2s" begin="-0.1s" repeatCount="indefinite"></animateTransform><path d="M-31.35997276079435 -21.460477824182675 L-38.431040572659825 -28.531545636048147 L-28.53154563604818 -38.4310405726598 L-21.4604778241827 -31.35997276079433 A38 38 0 0 1 -12.756598534413815 -35.79482076825908 L-12.756598534413815 -35.79482076825908 L-14.320943184816125 -45.671704174210454 L-0.493306416484226 -47.86178668477368 L1.0710382339180844 -37.98490327882231 A38 38 0 0 1 10.719362751275693 -36.45675880007112 L10.719362751275693 -36.45675880007112 L15.25926774867116 -45.3668240419548 L27.733359087308287 -39.01095704560117 L23.19345408991282 -30.100891803717484 A38 38 0 0 1 30.10089180371747 -23.193454089912834 L30.10089180371747 -23.193454089912834 L39.010957045601145 -27.733359087308305 L45.36682404195479 -15.259267748671181 L36.456758800071114 -10.71936275127571 A38 38 0 0 1 37.98490327882231 -1.0710382339181006 L37.98490327882231 -1.0710382339181006 L47.86178668477369 0.4933064164842056 L45.67170417421046 14.320943184816105 L35.79482076825908 12.756598534413799 A38 38 0 0 1 31.359972760794346 21.460477824182686 L31.359972760794346 21.460477824182686 L38.431040572659825 28.531545636048158 L28.53154563604818 38.4310405726598 L21.460477824182703 31.35997276079433 A38 38 0 0 1 12.756598534413818 35.79482076825907 L12.756598534413818 35.79482076825907 L14.32094318481613 45.67170417421045 L0.493306416484232 47.86178668477368 L-1.0710382339180797 37.98490327882231 A38 38 0 0 1 -10.719362751275689 36.45675880007112 L-10.719362751275689 36.45675880007112 L-15.259267748671162 45.3668240419548 L-27.733359087308344 39.01095704560112 L-23.19345408991287 30.100891803717445 A38 38 0 0 1 -30.10089180371747 23.193454089912837 L-30.10089180371747 23.193454089912837 L-39.01095704560115 27.7333590873083 L-45.366824041954814 15.259267748671112 L-36.456758800071135 10.719362751275648 A38 38 0 0 1 -37.98490327882231 1.0710382339181053 L-37.98490327882231 1.0710382339181053 L-47.86178668477368 -0.49330641648420825 L-45.67170417421043 -14.320943184816171 L-35.79482076825906 -12.756598534413857 A38 38 0 0 1 -31.359972760794346 -21.46047782418268 M0 -23A23 23 0 1 0 0 23 A23 23 0 1 0 0 -23" fill="#28292f"></path>
                </g>
            </g>
        </g>
    </svg>
    <div class="chili-progress-bar" id="progress">
        <div class="progress-bar" style="width: 0%"></div>
    </div>
</div>

<script type="text/javascript">
    const urlParams = new URLSearchParams(window.location.search);
    const reindex = urlParams.get('reindex') !== null;
    var alreadyIndexedDocuments = []
    var wordpressPublicDocuments = []
    var progressbar

    function getListOfIDsFromChiliSearch() {
        jQuery.post(
            ajaxurl,
            {
                'action': 'admin_ajax_get_list_of_ids_from_chilisearch',
            },
            function (response, status) {
                if (status === "success" && response.status) {
                    setProgressPercentage(5)
                    alreadyIndexedDocuments = alreadyIndexedDocuments.concat(response.documents)
                    getListOfContentNeedToBeIndexed()
                } else {
                    alert('Failed to load list of indexed content in Chili Search. please refresh the page and try again.');
                }
            }
        ).fail(function () {
            alert('Failed to load list of indexed content in Chili Search. please refresh the page and try again.');
        });
    }

    function getListOfContentNeedToBeIndexed() {
        jQuery.post(
            ajaxurl,
            {
                'action': 'admin_ajax_get_list_of_content_need_to_be_indexed',
            },
            function (response, status) {
                if (status === "success" && response.status) {
                    setProgressPercentage(10)
                    wordpressPublicDocuments = wordpressPublicDocuments.concat(response.documents)
                    setTimeout(function () {
                        deleteContentShouldNotBeIndexed();
                    }, 100);
                } else {
                    alert('Failed to load list of content need to be indexed in Chili Search. please refresh the page and try again.');
                }
            }
        ).fail(function () {
            alert('Failed to load list of content need to be indexed in Chili Search. please refresh the page and try again.');
        });
    }

    function deleteContentShouldNotBeIndexed() {
        let needToBeDeletedDocuments = alreadyIndexedDocuments.filter(x => !wordpressPublicDocuments.includes(x));
        let successfulDeletes = 0;

        function deleteDocumentFromChiliSearch(index, retry = 0) {
            if (!(index in needToBeDeletedDocuments)) {
                setProgressPercentage(50)
                console.log('Successfully deleted {successfulDeletes} documents.'.csf({successfulDeletes: successfulDeletes}))
                indexMissingContent()
                return
            }
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_delete_content_should_not_be_indexed',
                    'documentId': needToBeDeletedDocuments[index],
                },
                function (response, status) {
                    if (status === "success" && response.status) {
                        successfulDeletes++
                        let progressPercentage = ((index / needToBeDeletedDocuments.length) * 30) + 20
                        setProgressPercentage(progressPercentage)
                        deleteDocumentFromChiliSearch(index + 1)
                    } else {
                        if (retry < 2) {
                            deleteDocumentFromChiliSearch(index, retry + 1)
                        } else {
                            deleteDocumentFromChiliSearch(index + 1)
                        }
                    }
                }
            ).fail(function () {
                if (retry < 2) {
                    deleteDocumentFromChiliSearch(index, retry + 1)
                } else {
                    deleteDocumentFromChiliSearch(index + 1)
                }
            });
        }

        deleteDocumentFromChiliSearch(0)
    }

    function indexMissingContent() {
        let needToBeIndexedDocuments = wordpressPublicDocuments.filter(x => !alreadyIndexedDocuments.includes(x));
        let successfulIndexed = 0;

        function indexDocumentInChiliSearch(index, retry = 0) {
            if (!(index in needToBeIndexedDocuments)) {
                setProgressPercentage(100)
                console.log('Successfully indexed {successfulIndexed} new documents.'.csf({successfulIndexed: successfulIndexed}))
                reindexExistingContent()
                return
            }
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_index_missing_content',
                    'documentId': needToBeIndexedDocuments[index],
                },
                function (response, status) {
                    if (status === "success" && response.status) {
                        successfulIndexed++
                        let progressPercentage = ((index / needToBeIndexedDocuments.length) * 50) + 50;
                        setProgressPercentage(progressPercentage)
                        indexDocumentInChiliSearch(index + 1)
                    } else {
                        if (retry < 2) {
                            indexDocumentInChiliSearch(index, retry + 1)
                        } else {
                            console.log('Failed to index #{documentId}: {message}'.csf({
                                documentId: needToBeIndexedDocuments[index],
                                message: ('message' in response ? response.message : '')
                            }))
                            indexDocumentInChiliSearch(index + 1)
                        }
                    }
                }
            ).fail(function () {
                if (retry < 2) {
                    indexDocumentInChiliSearch(index, retry + 1)
                } else {
                    console.log('Failed to index #{documentId}: server error!'.csf({documentId: needToBeIndexedDocuments[index]}))
                    indexDocumentInChiliSearch(index + 1)
                }
            });
        }

        indexDocumentInChiliSearch(0)
    }

    function reindexExistingContent() {
        if (!reindex) {
            window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=analytics&fresh' . ( isset( $_GET['get-started'] ) ? '&tab=demo&fresh&get-started' : '&tab=analytics&fresh' ) ) ?>");
            return
        }
        setProgressPercentage(100)
        let successfulIndexed = 0;

        function indexDocumentInChiliSearch(index, retry = 0) {
            if (!(index in alreadyIndexedDocuments)) {
                setProgressPercentage(200)
                window.location.replace("<?= admin_url( 'admin.php?page=chilisearch' . ( isset( $_GET['get-started'] ) ? '&tab=demo&fresh&get-started' : '&tab=analytics&fresh' ) ) ?>");
                return
            }
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_index_missing_content',
                    'documentId': alreadyIndexedDocuments[index],
                },
                function (response, status) {
                    if (status === "success" && response.status) {
                        successfulIndexed++
                        let progressPercentage = ((index / alreadyIndexedDocuments.length) * 100) + 100
                        setProgressPercentage(progressPercentage)
                        indexDocumentInChiliSearch(index + 1)
                    } else {
                        if (retry < 2) {
                            indexDocumentInChiliSearch(index, retry + 1)
                        } else {
                            console.log('Failed to index #{documentId}: {message}'.csf({
                                documentId: alreadyIndexedDocuments[index],
                                message: ('message' in response ? response.message : '')
                            }))
                            indexDocumentInChiliSearch(index + 1)
                        }
                    }
                }
            ).fail(function () {
                if (retry < 2) {
                    indexDocumentInChiliSearch(index, retry + 1)
                } else {
                    console.log('Failed to index #{documentId}: server error!'.csf({documentId: alreadyIndexedDocuments[index]}))
                    indexDocumentInChiliSearch(index + 1)
                }
            });
        }

        indexDocumentInChiliSearch(0)
    }

    function setProgressPercentage(percentage) {
        if (reindex) {
            percentage = percentage / 2
        }
        progressbar.css('width', percentage + '%')
    }

    String.prototype.csf = String.prototype.csf || function () {
        let str = this.toString();
        if (arguments.length) {
            let t = typeof arguments[0],
                args = ("string" === t || "number" === t) ? Array.prototype.slice.call(arguments) : arguments[0];
            for (let arg in args) {
                str = str.replace(new RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
            }
        }

        return str;
    };
    jQuery(document).ready(function ($) {
        progressbar = jQuery('#progress .progress-bar')
        getListOfIDsFromChiliSearch();
    });
</script>
