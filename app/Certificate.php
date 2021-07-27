<?php

namespace App;

use Carbon\Carbon;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Certificate extends Model 
{
    use SoftDeletes, Auditable;

    public $table = 'certificates';

    public static $searchable = [
        'name',
        'description',
        'type'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'type',
        'start_validity',
        'end_validity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getStartValidityAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartValidityAttribute($value)
    {
        $this->attributes['start_validity'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndValidityAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndValidityAttribute($value)
    {
        $this->attributes['end_validity'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function logical_servers()
    {
        return $this->belongsToMany(LogicalServer::class)->orderBy("name");
    }
}