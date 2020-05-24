<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Component extends Model {
    use Sortable;

    protected $fillable = ['name', 'price', 'device_id'];
}
