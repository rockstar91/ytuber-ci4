<?php

use Config\Services;

//--------------------------------------------------------------------

if (! function_exists('set_checkbox'))
{
    /**
     * Set Checkbox
     *
     * Let's you set the selected value of a checkbox via the value in the POST array.
     * If Form Validation is active it retrieves the info from the validation class
     *
     * @param string  $field
     * @param string  $value
     * @param boolean $default
     *
     * @return string
     */
    function set_checkbox(string $field, string $value = '', bool $default = false): string
    {
        $request = Services::request();

        // Try any old input data we may have first
        $input = $request->getOldInput($field);

        if ($input === null)
        {
            $input = $request->getPost($field);
        }

        if (is_array($input))
        {
            // Note: in_array('', array(0)) returns TRUE, do not use it
            foreach ($input as &$v)
            {
                if ($value === $v)
                {
                    return ' checked="checked"';
                }
            }

            return '';
        }

        // Unchecked checkbox and radio inputs are not even submitted by browsers ...
        //if (intval($input) === 0 || ! empty($request->getPost()) || ! empty(old($field)))
        if (intval($input) === 0 && ( ! empty($request->getPost()) || ! empty(old($field)) ) )
        {
            return ($input === $value) ? ' checked="checked"' : '';
        }

        return ($default === true) ? ' checked="checked"' : '';
    }
}