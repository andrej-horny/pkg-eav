<?php

namespace Dpb\Package\Eav\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeType extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
    ];

    public function getTable()
    {
        return config('pkg-eav.table_prefix') . 'attribute_types';
    }

}
