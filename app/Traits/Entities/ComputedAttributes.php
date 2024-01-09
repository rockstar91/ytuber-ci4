<?php


namespace App\Traits\Entities;


trait ComputedAttributes
{
    protected $computedAttributes = [];

    private function fillComputedAttributes(array $data = null)
    {
        foreach ($this->computedAttributes as $attributeKey) {

            $method = 'calculate' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $attributeKey)));
            if (method_exists($this, $method))
            {
                $data[$attributeKey] = $this->$method($data);
            }
        }

        return $data;
    }

    public function setAttributes(array $data)
    {
        $data = $this->fillComputedAttributes($data);
        return parent::setAttributes($data);
    }
}