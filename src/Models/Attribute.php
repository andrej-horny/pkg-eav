<?php

namespace Dpb\Package\Eav\Models;

use Illuminate\Database\Eloquent\Builder;
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
    
    /**
     * Scopes
     */

    public function scopeByCode(Builder $query, string $code)
    {
        return $query->where('code', '=', $code);
    }   

    public function scopeByType(Builder $query, string $type)
    {
        return $query->whereHas('type', function($q) use ($type) {
            $q->byCode($type);
        });
    }    
    
    public function scopeByGroup(Builder $query, string $group)
    {
        return $query->whereHas('group', function($q) use ($group) {
            $q->byCode($group);
        });
    }      
}
