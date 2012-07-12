<?php

if (!function_exists('create_dropdown')) {
    function create_dropdown($model, $field) {
        $ci =& get_instance();
        $ci->load->model($model, 'dropdown_' . $model);
        $records = $ci->{'dropdown_' . $model}->fetch_all();
        
        $field = explode(',', $field);

        $values = array('' => 'Select...');
        foreach ($records->result_array() as $record) {
            $value = array();
            foreach ($field as $f) {
                 $value[] = $record[$f];
            }

            $values[$record[$ci->{'dropdown_' . $model}->get_primary_key()]] = implode(' ', $value);
        }
        
        return $values;
    }
}

/**
 * Checks if the hash on the session is valid to increase security.
 *
 */
function is_logged_in() {
    $ci =& get_instance();

    return (
        $ci->session->userdata('logged_in')
        && $ci->session->userdata('user_id') . $ci->input->ip_address() == $ci->encrypt->decode($ci->session->userdata('x'))        
        );
}

function __autoload($class) {
    $path  = APPPATH . 'libraries/' . $class . '.php';
    if (file_exists($path)) {
        include_once ($path);
        if (!class_exists($class, false) && !interface_exists($class)) {
            trigger_error("Unable to load class: $class", E_USER_WARNING);
        }
    }
}