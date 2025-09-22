<?php

namespace Dpb\Package\Eav\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'title',
    ];

    public function getTable()
    {
        return config('pkg-eav.table_prefix') . 'attribute_groups';
    }

    // public function attributes()   {
    //     return $this->hasMany(Attribute:class);
        
    // }
}
