/**
 * Created by ra on 3/15/2016.
 */




var tdDemoProgressBar = {};

(function () {
    'use strict';
    tdDemoProgressBar = {
        progress_bar_wrapper_element: '',
        progress_bar_element: '',
        current_value: 0,
        goto_value: 0,
        timer:'',
        last_goto_value:0,

        show: function show() {
            tdDemoProgressBar.progress_bar_wrapper_element.addClass('td-progress-bar-visible');
        },

        hide: function hide() {
            tdDemoProgressBar.progress_bar_wrapper_element.removeClass('td-progress-bar-visible');
        },

        reset:function reset() {
            clearInterval(tdDemoProgressBar.timer);
            tdDemoProgressBar.current_value = 0;
            tdDemoProgressBar.goto_value = 0;
            tdDemoProgressBar.timer = '';
            tdDemoProgressBar.last_goto_value = 0;
            tdDemoProgressBar.change(0);
        },




        change: function change(new_progress) {
            tdDemoProgressBar.progress_bar_element.css('width', new_progress + '%');
            tdDemoProgressBar.last_goto_value = new_progress;
            if (new_progress === 100) {
                clearInterval(tdDemoProgressBar.timer);
            }
        },

        timer_change: function timer_change(new_progress) {
            clearInterval(tdDemoProgressBar.timer);

            tdDemoProgressBar._ui_change(tdDemoProgressBar.last_goto_value);
            tdDemoProgressBar.current_value = tdDemoProgressBar.last_goto_value;


            clearInterval(tdDemoProgressBar.timer);
            tdDemoProgressBar.timer = setInterval(function(){
                if (Math.floor((Math.random() * 5) + 1) === 1) {
                    var tmp_value = Math.floor((Math.random() * 5) + 1) + tdDemoProgressBar.current_value;
                    if (tmp_value <= new_progress) {
                        tdDemoProgressBar._ui_change(tdDemoProgressBar.current_value);
                        tdDemoProgressBar.current_value = tmp_value;
                    } else {
                        tdDemoProgressBar._ui_change(new_progress);
                        clearInterval(tdDemoProgressBar.timer);
                    }

                    //console.log(tmp_value);
                }

            }, 1000);
            tdDemoProgressBar.last_goto_value = new_progress;
        },


        /**
         * change only the css
         * @param new_progress integer
         */
        _ui_change: function change(new_progress) {
            tdDemoProgressBar.progress_bar_element.css('width', new_progress + '%');
        }


    };
})();
