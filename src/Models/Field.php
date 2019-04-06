<?php

namespace Kato\Fieldable;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'fields';

    protected $fillable = [
        'name',
        'field_order'
    ];

    public function fieldable()
    {
        return $this->morphTo();
    }

    public function values()
    {
        return $this->hasMany(FieldValue::class);
    }
}
