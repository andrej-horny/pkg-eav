<?php

namespace Dpb\Package\Eav\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'group_id',
        'type_id',
    ];

    public function getTable()
    {
        return config('pkg-eav.table_prefix') . 'attributes';
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class);
    }
    
    public function type(): BelongsTo
    {
        return $this->belongsTo(AttributeType::class);
    }    
}
