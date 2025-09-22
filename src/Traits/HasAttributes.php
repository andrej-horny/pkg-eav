<?php

namespace Dpb\Package\Eav\Traits;

use Dpb\Package\Eav\Models\Attribute;
use Dpb\Package\Eav\Models\AttributeSet;
use Dpb\Package\Eav\Models\AttributeValue;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasAttributes
{
    // public function attributeSets(): BelongsToMany
    // {
    //     return $this->belongsToMany(AttributeSet::class, 'attribute_set_entities');
    // }

    public function attributeValues()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }

    public function setAttrValue(string $attributeCode, $value)
    {
        $attribute = Attribute::byCode($attributeCode)
            ->with('type:id,code')
            ->firstOrFail();

        $data = [
            'attribute_id' => $attribute->id,
            'value_string' => null,
            'value_int' => null,
            'value_decimal' => null,
            'value_bool' => null,
            'value_date' => null,
        ];

        switch ($attribute->type->code) {
            case 'string':
                $data['value_string'] = $value;
                break;
            case 'integer':
                $data['value_int'] = $value;
                break;
            case 'decimal':
                $data['value_decimal'] = $value;
                break;
            case 'boolean':
                $data['value_bool'] = (bool)$value;
                break;
            case 'date':
                $data['value_date'] = $value;
                break;
        }

        return $this->attributeValues()->updateOrCreate(
            [
                'entity_type' => $this->getMorphClass(),
                'entity_id'   => $this->getKey(),
                'attribute_id' => $attribute->id
            ],
            $data
        );
    }

    public function getAttrValue(string $attributeCode)
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