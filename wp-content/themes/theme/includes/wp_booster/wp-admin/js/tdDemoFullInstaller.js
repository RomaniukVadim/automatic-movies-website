/**
 * Created by ra on 3/15/2016.
 *
 * Installs the full demo. It has a list of steps and it starts recusivley from 0 to the last step. If an error is encounter,
 * the class will show a warning to the user but it will continue with the install as if nothing happened
 */


/* global jQuery:{} */
/* global console:{} */
/* global alert:{} */
/* global confirm:{} */
/* global td_ajax_url:{} */
/* global tdDemoProgressBar:{} */


var tdDemoFullInstaller = {};

(function () {
    'use strict';
    tdDemoFullInstaller = {


        /**
         * Recursive function, it will start from step 0 and work it's way up from there.
         * On error the function will show an alert and it will continue with the install process
         * @see tdDemoFullInstaller._getSteps()
         * @param demoId - the demo id that you want to install
         * @param step - not needed, it will be 0 by default
         * @param onFinishCallback - this callback is called whent he install is finished. Event on error, the install will be finished!
         */
        installNextStep: function (demoId, step, onFinishCallback) {
            if (typeof step === 'undefined') {
                step = 0;
            }

            // get all the steps
            var steps = tdDemoFullInstaller._getSteps(demoId);

            // the current step
            var currentStep = steps[step];
            tdDemoProgressBar.timer_change(currentStep.progress);


            //console.log(currentStep);

            currentStep.data.td_magic_token = tdWpAdminImportNonce;

            jQuery.ajax({
                type: 'POST',
                url: tdDemoFullInstaller._getAdminAjax(currentStep.data.td_demo_action),
                cache:false,
                data: currentStep.data,
                dataType: 'json',
                success: function(data, textStatus, XMLHttpRequest){
                    if (typeof steps[step + 1] !== 'undefined') {
                        tdDemoFullInstaller.installNextStep(demoId, step + 1, onFinishCallback);
                    } else {
                        // on finish finally call the callback
                        onFinishCallback();
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){

                    var responseText = MLHttpRequest.responseText.replace(/<br>/g, '\n');


                    console.log('textStatus: ' + textStatus);
                    console.log('errorThrown: ' + errorThrown);
                    console.log('responseText: ' + responseText);



                    alert('tagDiv importer detected an error. The importer will try to recover and continue to install the demo after you click ok on this dialog.\n' +
                        '\n' +
                        'Steps to troubleshoot:\n' +
                        '- Check the permissions on your upload folder\n' +
                        '- Please make sure that WP_DEBUG is set to false in wp-config.php\n' +
                        '- Contact our support via email contact@tagdiv.com (please provide your product license key)'
                    );



                    // continue even on error :)
                    if (typeof steps[step + 1] !== 'undefined') {
                        tdDemoFullInstaller.installNextStep(demoId, step + 1, onFinishCallback);
                    } else {
                        // on finish finally call the callback
                        onFinishCallback();
                    }
                }
            });
        },



        /**
         * generates an unique ID. Used for cache busting
         * @returns {string}
         * @private
         */
        _getAdminAjax: function(stepName) {
            if (typeof stepName === 'undefined') {
                stepName = 'not_set';
            }

            function s4() {
                return Math.floor((1 + Math.random()) * 0x10000)
                    .toString(16)
                    .substring(1);
            }
            return td_ajax_url + '&step=' + stepName + '&uid=' + s4() + s4() + s4() + s4();
        },


        /**
         * generates the steps needed for a particular demoId
         * @param demoId
         * @returns {{0: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: string}}, 1: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}, 2: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}, 3: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}, 4: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}, 5: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}, 6: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}, 7: {progress: number, data: {action: string, td_demo_action: string, td_demo_id: *}}}}
         * @private
         */
        _getSteps: function (demoId) {
            return {
                0: {
                    progress: 10,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action: 'remove_content_before_install',
                        td_demo_id: ''
                    }
                },
                1: {
                    progress: 22,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_media_1',
                        td_demo_id: demoId
                    }

                },
                2: {
                    progress: 34,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_media_2',
                        td_demo_id: demoId
                    }
                },
                3: {
                    progress: 46,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_media_3',
                        td_demo_id: demoId
                    }
                },
                4: {
                    progress: 58,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_media_4',
                        td_demo_id: demoId
                    }
                },
                5: {
                    progress: 70,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_media_5',
                        td_demo_id: demoId
                    }
                },
                6: {
                    progress: 82,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_media_6',
                        td_demo_id: demoId
                    }
                },
                7: {
                    progress: 98,
                    data: {
                        action: 'td_ajax_demo_install',
                        td_demo_action:'td_import',
                        td_demo_id: demoId
                    }
                }
            };
        }
    };
})();

