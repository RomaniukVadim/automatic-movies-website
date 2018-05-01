<?php

/**
 * generates the metaboxes used on pages that have loops (the filters of the loop)
 * Class td_metabox_generator
 */
class td_metabox_generator {

    protected $mb;

    public function __construct($mb) {
        $this->mb = $mb;
    }

    /**
     * creates the fields with return of homepage_filter_get_map() array
     * @param array $array_for_fields
     */
    function td_render_homepage_loop_filter($array_for_fields = array()){
        $arry_params = $array_for_fields['params'];

        $buffer_field = '';
        foreach ($arry_params as $array_field) {
            $buffer_field =  '<div class="td-meta-box-row">';

            switch ($array_field['type']) {
                case 'dropdown':
                    $this->mb->the_field($array_field['param_name']);

                    $buffer_field .=  '<span class="td-page-o-custom-label" >' . $array_field['heading'] . '</span>';
                    $buffer_field .=  '<div class="td-select-style-overwrite">';
                        $buffer_field .=  '<select class="' . $array_field['class'] . ' td-panel-dropdown" name="' . $this->mb->get_the_name() . '">';
                            //creating options for select
                            foreach ($array_field['value'] as $select_option_key => $select_option_val) {
                                if($this->mb->get_the_value() == $select_option_val) {
                                    $var_selected = ' selected="selected" ';
                                } else {
                                    $var_selected = '';
                                }
                                $buffer_field .=  '<option value="' . $select_option_val . '" ' . $var_selected . '>' . $select_option_key . '</option>';
                            }
                        $buffer_field .=  '</select>';
                    $buffer_field .=  '</div>';

                    if (!empty($array_field['description'])) {
                        $buffer_field .=  '
                        <span class="td-page-o-info">' . $array_field['description'] . '</span>';
                    }
                    break;

                //default : textfield
                default:
                    $this->mb->the_field($array_field['param_name']);
                    $value_input = $this->mb->get_the_value();
                    if (!empty($value_input)) {
                        //
                    } else {
                        $value_input = $array_field['value'];
                    }

                    $buffer_field .=  '<span class="td-page-o-custom-label">' . $array_field['heading'] . ' </span>
                    <input type="text" class="' . $array_field['class'] . ' td-input-text-backend-generic-filter" name="' . $this->mb->get_the_name() . '" value="' . $value_input . '" />';

                    if (!empty($array_field['description'])) {
                        $buffer_field .=  '
                        <span class="td-page-o-info">' . $array_field['description'] . '</span>';
                    }
                    break;
            }

            $buffer_field .=  '</div>';
            echo $buffer_field;
        }

    }

}//end class