<?php

namespace Kato\Fieldable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kato\Fieldable\Field;
use Kato\Fieldable\FieldRow;
use Kato\Fieldable\FieldValue;

trait Fieldable
{
    public function addField($attributes = [])
    {
        if ($attributes instanceof Model && $attributes->isFieldable()) {
            return $this->fields()->save($attributes);
        }

        return $this->fields()->updateOrCreate($attributes);
    }

    public function addRow($columns, $rowData, $attributes = [])
    {
        if ($attributes instanceof Model && $attributes->isFieldable()) {
            $row = $this->fieldRows()->save($attributes);
        } else {
            $row = $this->fieldRows()->create($attributes);
        }

        foreach ($columns as $key => $col) {
            if ($rowData[$key]) {
                $this->fieldValues()->create([
                    'field_id' => $col->id,
                    'field_rows_id' => $row->id,
                    'value' => $rowData[$key]
                ]);
            }
        }

        return $row;
    }

    public function fields()
    {
        return $this->morphMany(Field::class, 'fieldable');
    }

    public function fieldRows()
    {
        return $this->morphMany(FieldRow::class, 'fieldable');
    }

    public function fieldValues()
    {
        return $this->morphMany(FieldValue::class, 'fieldable');
    }

    public function fieldRecords()
    {
        $fields = $this->fields;
        $columns[] = DB::raw('field_rows.id as id');
        foreach ($fields as $field) {
            $columns[] = DB::raw('MAX(IF(field_values.field_id = '.$field->id.', field_values.value, null)) as `'.$field->name.'`');
        }

        return $this->fieldRows()
            ->leftJoin('field_values', function ($join) {
                $join->on('field_rows.id', '=', 'field_values.field_rows_id');
            })
            ->select($columns)
            ->groupBy('field_rows.id');
    }

    public function isFieldable()
    {
        return true;
    }
}
