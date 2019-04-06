<?php

namespace Kato\Fieldable;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    protected $table = 'field_values';

    protected $fillable = [
        'field_id',
        'field_rows_id',
        'value'
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
