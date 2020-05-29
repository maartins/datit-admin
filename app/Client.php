<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model {
    use Sortable;

    public $sortable = ['first_name', 'last_name', 'phone_number', 'address', 'client_type', 'company_name', 'created_at', 'updated_at'];
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'address', 'client_type', 'company_name'];
}
