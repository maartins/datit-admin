<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model {
    use Sortable;

    protected $fillable = ['first_name', 'last_name', 'phone_number', 'address', 'client_type', 'company_name'];
}
