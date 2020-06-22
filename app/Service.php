<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Service extends Model {
    use Sortable;

    protected $fillable = ['description', 'price', 'service_category_id'];
    public $sortable = ['description', 'price', 'created_at', 'updated_at'];

    public function device() {
        return $this->belongsTo('App\Device');
    }

    public function category() {
        return $this->belongsTo('App\ServiceCategory', 'service_category_id');
    }
}
