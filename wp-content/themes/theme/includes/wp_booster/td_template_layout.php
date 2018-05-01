<?php

/*
 * Used by templates to create the layout (rows + columns) in author.php, tag.php etc...
 * the layout is then populated with modules
 */


class td_template_layout extends td_block_layout {
    var $td_column_number;
    var $td_current_column = 1;

    var $td_post_count = 0;

    var $is_output_disabled = false; //when the module is disabled (for module 1 and 7), it dosn't output anything because they don't need the grid to work

    function __construct($sidebar_position) {
        switch($sidebar_position) {
            case 'sidebar_left':
                // 2 cols
                $this->set_columns(2);
                break;

            case 'no_sidebar':
                // 3 cols
                $this->set_columns(3);
                break;

            default:
                //default is one sidebar (right in general)  2 + 1(sidebar)
                $this->set_columns(2);
                break;

        }
    }


    function disable_output() {
        $this->is_output_disabled = true;
    }

    /**
     * Set the column width of the layout (1 2 3)
     * @param $columns
     */
    function set_columns($columns) {
        $this->td_column_number = $columns;
    }

    /**
     * calculates the next position
     */
    function layout_next() {
        $this->td_post_count++;

        if ($this->td_column_number == $this->td_current_column) {
            $this->td_current_column = 1;
        } else {
            $this->td_current_column++;
        }
    }


    /**
     * 1. Opens a new row if it's not already opened
     * 2. opens the column (span 4 or 6) @todo no full width !!!
     * @return string the html generated
     */
    function layout_open_element() {
        if ($this->is_output_disabled) {
            return '';
        }

        $buffy = '';
        switch ($this->td_column_number) {
            case 2:
                $buffy .= $this->open_row();
                $buffy .= $this->open6();
                break;

            case 3:
                $buffy .= $this->open_row();
                $buffy .= $this->open4();
                break;
        }
        return $buffy;
    }

    /**
     * Closes the element, used after element
     * @return string
     */
    function layout_close_element() {
        if ($this->is_output_disabled) {
            return;
        }


        $buffy = '';
        switch ($this->td_column_number) {
            case 2:
                //close span
                $buffy .= $this->close6();

                //close row
                if ($this->td_current_column == 2) {
                    $buffy .= $this->close_row();
                }
                break;

            case 3:
                //close span
                $buffy .= $this->close4();

                //close row
                if ($this->td_current_column == 3) {
                    $buffy .= $this->close_row();
                }
                break;
        }

        return $buffy;
    }


    function close_all_tags() {
        if ($this->is_output_disabled) {
            return;
        }
        //return the parents close all
        return parent::close_all_tags();
    }

}
