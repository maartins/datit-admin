<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Device extends Model {
    use Sortable;

    protected $fillable = ['device_type_id', 'name', 'additions', 'problem', 'note', 'invoice_id'];

    public function invoice() {
        return $this->belongsTo('App\Invoice');
    }

    public function services() {
        return $this->belongsToMany('App\Service', 'device_services');
    }

    public function type() {
        return $this->belongsTo('App\DeviceType', 'device_type_id');
    }
}
