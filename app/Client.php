<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use Sortable;

    public function createFromArray($array) {
        $name = trim($array->name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#'.$last_name.'#', '', $name));
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone_number = $array->phone_number;
        $this->address = $array->address;
        $this->client_type = $array->client_type;
        if ($array->client_type == 'company') {
            $this->company_name = $array->company_name;
        }
    }
}
