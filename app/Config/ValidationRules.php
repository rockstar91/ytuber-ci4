<?php

namespace Config;


class ValidationRules
{
    /**
     * @param string $value
     * @param string|null $fields
     * @return bool
     */
    public function password(string $value, string $fields = NULL) : bool
    {
        $len = strlen($value);

        list($min, $max) = explode(',', $fields);


        // пароль может быть не указан
        if( $len <= 0)
        {
            return true;
        }

        if($len < $min)
        {
            return false;
        }
        else if ($len > $max)
        {
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     * @param string|null $fields
     * @param array $data
     * @param string|null $error
     * @return bool
     */
    public function password_confirm(string $value, string $fields = NULL, array $data = [], string &$error = NULL): bool
    {

        if( empty($data['password']) && empty($value) )
        {
            return true;
        }
        else if( !empty($data['password']) && $value == $data['password'] )
        {
            return true;
        }

        return false;
    }

    public function is_unique_where(string $str, string $field = NULL, array $data = [], string &$error = NULL): bool
    {
        // Grab any data for exclusion of a single row.
        list($field, $whereField, $whereValue) = array_pad(explode(',', $field), 3, null);

        // Break the table and field apart
        sscanf($field, '%[^.].%[^.]', $table, $field);

        $db = Database::connect($data['DBGroup'] ?? null);

        $row = $db->table($table)
            ->select('1')
            ->where($field, $str)
            ->where('`deleted_at` IS NULL')
            ->limit(1);

        if (! empty($whereField) && ! empty($whereValue))
        {
            $row = $row->where("{$whereField}", $whereValue);
        }

        return (bool) ($row->get()
                ->getRow() === null);

    }

    public function greater_than_equal_where(string $value, string $field = NULL, array $data = [], string &$error = NULL): bool
    {
        $exploded = explode(',', $field);

        if(count($exploded) < 3)
        {
            return false;
        }


        // Grab any data for exclusion of a single row.
        list($primaryField, $comparedField, $comparedValue) = array_pad($exploded, 3, null);

        // Break the table and field apart
        sscanf($primaryField, '%[^.].%[^.]', $table, $primaryField);

        // Get row
        $db = Database::connect($data['DBGroup'] ?? null);

        $row = $db->table($table)
            ->select($primaryField . ',' . $comparedField)
            ->where($primaryField, $value)
            ->where($comparedField . ' >=', $comparedValue)
            ->limit(1);

        return (bool) ($row->get()
                ->getRow() !== null);
    }
}