<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Device extends Model {
    use Sortable;

    protected $fillable = ['device_type_id', 'name', 'additions', 'problem', 'note', 'invoice_id'];
}
