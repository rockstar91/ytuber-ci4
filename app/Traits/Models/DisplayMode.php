<?php


namespace App\Traits\Models;


trait DisplayMode
{
    // все, разрешенные для выборки поля в режиме dispayMode
    /**
     * @var string[]
     */
    protected $allowedDisplayFields = ['id'];

    // вычисляемый набор полей (передается в select)
    /**
     * @var array
     */
    protected $settedDisplayFields = [];

    // dispayMode statement
    /**
     * @var bool
     */
    protected $displayMode = false;

    /**
     * @return array|string[]|null
     */
    protected function getDisplayFields()
    {
        return !empty($this->settedDisplayFields) ? $this->settedDisplayFields : $this->allowedDisplayFields;
    }

    protected function selectDisplayFields()
    {
        $displayFields = $this->getDisplayFields();

        if(is_array($displayFields) && count($displayFields) > 0 && $this->displayMode)
        {
            foreach ($displayFields as $field)
            {
                $this->select($this->table . '.' . $field);
            }
            //return $this->select($displayFields);
        }
        else if ( ! $this->displayMode)
        {
            //$this->select($this->table . '.*');
        }
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fillDisplayFields($fields = [])
    {
        if( ! is_array($fields) )
        {
            $fields = array_map('trim', explode(',', $fields));
        }

        foreach ($fields as $field) {
            if(in_array($field, $this->allowedDisplayFields) && ! in_array($field, $this->settedDisplayFields))
            {
                $this->settedDisplayFields[] = $field;
            }
        }

        $this->settedDisplayFields = array_unique($this->settedDisplayFields);

        if(count($this->settedDisplayFields) > 0)
        {
            return $this->displayModeOn();
        }

        return $this;
    }

    /**
     *
     */
    public function clearDisplayFields()
    {
        $this->settedDisplayFields = [];
    }

    /**
     * @return $this
     */
    public function displayModeOn()
    {
        $this->displayMode = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function displayModeOff()
    {
        $this->displayMode = false;
        return $this;
    }

    public function displayModeStatus()
    {
        return $this->displayMode;
    }

    /**
     * @param null $id
     * @return array|object|null
     */
    public function find($id = null)
    {
        $this->selectDisplayFields();
        return parent::find($id);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAll(int $limit = 0, int $offset = 0)
    {
        $this->selectDisplayFields();
        return parent::findAll($limit, $offset);
    }
}