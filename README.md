#Laravel Fieldable

Under development

## Migrations
```
php artisan migrate
```

## Update model

```php
use Fieldable;
```

example 
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kato\Fieldable\Traits\Fieldable;

class Activity extends Model
{
    use Fieldable;
}
```

## Insert field and value
```php
$activity = Activity::first();

$fields = ['name', 'email', 'phone'];
foreach ($fields as $field) {
    $columns[$col] = $activity->addField([ 'name' => $field ]);
}

foreach ($rows as $row) {
    $activity->addRow($columns, $row);
}
```

## Show all records
```
$records = $activity->fieldRecords()->paginate(10);
```
