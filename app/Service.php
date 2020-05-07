<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Service extends Model {
    use Sortable;

    protected $fillable = ['description', 'price', 'service_category_id'];
}
