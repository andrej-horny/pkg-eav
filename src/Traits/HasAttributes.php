<?php

namespace Dpb\Package\Eav\Traits;

use Dpb\Package\Eav\Models\Attribute;
use Dpb\Package\Eav\Models\AttributeValue;

trait HasAttributes
{
    public function attributeValues()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }

    public function setAttributeValue(string $attributeCode, $value)
    {
        $attribute = Attribute::where('code', $attributeCode)->firstOrFail();

        $data = [
            'attribute_id' => $attribute->id,
            'value_string' => null,
            'value_int' => null,
            'value_decimal' => null,
            'value_bool' => null,
            'value_date' => null,
        ];

        switch ($attribute->data_type) {
            case 'string':  $data['value_string'] = $value; break;
            case 'int':     $data['value_int'] = $value; break;
            case 'decimal': $data['value_decimal'] = $value; break;
            case 'boolean': $data['value_bool'] = (bool)$value; break;
            case 'date':    $data['value_date'] = $value; break;
        }

        return $this->attributeValues()->updateOrCreate(
            ['attribute_id' => $attribute->id],
            $data
        );
    }

    public function getAttributeValue(string $attributeCode)
    {
        $value = $this->attributeValues()
            ->whereHas('attribute', fn($q) => $q->where('code', $attributeCode))
            ->first();

        return $value ? $value->value_string
            ?? $value->value_int
            ?? $value->value_decimal
            ?? $value->value_bool
            ?? $value->value_date
            : null;
    }
}
