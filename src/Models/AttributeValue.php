<?php

namespace Dpb\Package\Eav\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'attribute_id',
        'value_int',
        'value_decimal',
        'value_string',
        'value_bool',
        'value_date',
    ];

    public function getTable()
    {
        return config('pkg-eav.table_prefix') . 'attribute_values';
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
