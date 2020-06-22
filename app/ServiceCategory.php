<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ServiceCategory extends Model {
    use Sortable;

    public $sortable = ['name'];
}
