<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "system_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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

    /**
     * Roles for the admin panel
     */
    protected const SUPER_ROLE = 1;
    protected const ADMIN_ROLE = 2;
    protected const MODERATOR = 3;


    /**
     *  Roles admin panel in the form of a string
     *
     * @return array
     */
    public function getRoles()
    {
        return [
            self::SUPER_ROLE => "super",
            self::ADMIN_ROLE => "admin",
            self::MODERATOR => "moderator",
        ];
    }

    /**
     *  Hashing the password when creating a user
     *
     * @param [type] $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
