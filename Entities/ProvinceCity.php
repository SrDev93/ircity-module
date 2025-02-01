<?php

namespace Modules\IrCity\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProvinceCity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\IrCity\Database\factories\ProvinceCityFactory::new();
    }

    public function parent()
    {
        return $this->hasOne(ProvinceCity::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProvinceCity::class, 'parent_id')->with('children');
    }
}
