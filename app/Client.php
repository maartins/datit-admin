<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use Sortable;

    public function createFromArray($array) {
        $this->first_name = $array->first_name;
        $this->last_name = $array->last_name;
        $this->phone_number = $array->phone_number;
        $this->address = $array->address;
        $this->client_type = $array->client_type;
        if ($array->client_type == 'company') {
            $this->company_name = $array->company_name;
        }
    }
}
