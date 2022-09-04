<?php

namespace App\Models;

use App\Filters\OperationsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use SoftDeletes;

    use HasFactory;

    const STATUS_NEW = 1;
    const STATUS_CONFIRM = 2;
    const STATUS_CANCEL = -1;
    const STATUS_RETURN = -2;

    const TYPE_ONLINE = 1;
    const TYPE_BANK = 2;
    const TYPE_MANUAL = 3;

    protected $table = 'operations';

    protected $fillable = ['account_id', 'type_id', 'status', 'amount', 'balance', 'options'];

    public static $statuses = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_CONFIRM => 'Принят',
        self::STATUS_CANCEL => 'Отмена',
        self::STATUS_RETURN => 'Возврат'
    ];

    public static $types = [
        self::TYPE_ONLINE => 'Online',
        self::TYPE_BANK => 'Перевод',
        self::TYPE_MANUAL => 'Ручное'
    ];


    // Поиск по полям
    public function scopeFilter(Builder $builder, $request)
    {
        return (new OperationsFilter($request))->filter($builder);
    }

    // Сортировка по полям
    public function scopeSort(Builder $builder, $request)
    {
        return (new OperationsFilter($request))->sortable($builder);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function getTypeAttribute()
    {
        return (isset(self::$types[$this->type_id])) ? self::$types[$this->type_id] : Null;
    }

    public function getStatusAttribute()
    {
        return (isset(self::$statuses[$this->status_id])) ? self::$statuses[$this->status_id] : Null;
    }
}
