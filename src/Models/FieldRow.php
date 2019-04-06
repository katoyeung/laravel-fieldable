<?php

namespace Kato\Fieldable;

use Illuminate\Database\Eloquent\Model;

class FieldRow extends Model
{
    protected $table = 'field_rows';
    public $timestamps = false;

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
