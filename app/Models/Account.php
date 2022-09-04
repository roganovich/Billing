<?php

namespace App\Models;

use App\Filters\AccountsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    use HasFactory;

    const TYPE_FIZ = 1;
    const TYPE_UR = 2;

    const STATUS_NEW = 1;
    const STATUS_CURENT = 2;
    const STATUS_CLOSE = -1;

    protected $table = 'accounts';

    protected $fillable = ['code', 'user_id', 'type_id', 'title', 'status', 'balance', 'description', 'created_at', 'updated_at'];

    public static $types = [
        self::TYPE_FIZ => 'Физ.лицо',
        self::TYPE_UR => 'Юр.лицо',
    ];

    public static $statuses = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_CURENT => 'Текущий',
        self::STATUS_CLOSE => 'Закрыт',
    ];

    // Поиск по полям
    public function scopeFilter(Builder $builder, $request)
    {
        return (new AccountsFilter($request))->filter($builder);
    }

    // Сортировка по полям
    public function scopeSort(Builder $builder, $request)
    {
        return (new AccountsFilter($request))->sortable($builder);
    }

    public function getTypeAttribute()
    {
        return (isset(self::$types[$this->type_id])) ? self::$types[$this->type_id] : Null;
    }

    public function getStatusAttribute()
    {
        return (isset(self::$statuses[$this->status_id])) ? self::$statuses[$this->status_id] : Null;
    }


    public function getIsFizAttribute()
    {
        return ($this->type_id == self::TYPE_FIZ);
    }

    public function getIsUrAttribute()
    {
        return ($this->type_id == self::TYPE_UR);
    }
}
