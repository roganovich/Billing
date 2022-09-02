<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Filters\UsersFilter;
use PhpParser\Node\NullableType;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 2;
    const ROLE_CLIENT = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'created_at',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $roles = [
        self::ROLE_CLIENT => 'Пользователь',
        self::ROLE_ADMIN => 'Администратор'
    ];

    // Поиск по полям
    public function scopeFilter(Builder $builder, $request)
    {
        return (new UsersFilter($request))->filter($builder);
    }

    // Сортировка по полям
    public function scopeSort(Builder $builder, $request)
    {
        return (new UsersFilter($request))->sortable($builder);
    }

    public function getRoleAttribute()
    {
        return (isset(self::$roles[$this->role_id])) ? self::$roles[$this->role_id] : Null;
    }

    public function getIsAdminAttribute()
    {
        return ($this->role_id == self::ROLE_ADMIN);
    }

    public function getIsClientAttribute()
    {
        return ($this->role_id == self::ROLE_CLIENT);
    }
}
