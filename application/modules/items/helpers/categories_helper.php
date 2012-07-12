<?php

if (!function_exists('category_dropdown')) {
    function category_dropdown() {
        $ci =& get_instance();
        $ci->load->model('categories');
        
        $categories = $ci->categories->fetch_all();
        
        $values = array('' => 'Select...');
        foreach ($categories->result_array() as $category) {
            $values[$category[$ci->categories->get_primary_key()]] =  $category['name'];
        }
        
        return $values;
    }
}

if (!function_exists('category_jqgrid_options')) {
    function category_jqgrid_options() {
        $categories = category_dropdown();
                     
        foreach ($categories as $key => $category) {
            $options[] = $key . ':' . $category;
        }
        
        return implode(';', $options);
    }
}