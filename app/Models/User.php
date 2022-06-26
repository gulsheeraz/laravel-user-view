<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'address',
        'department_id',
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
        'dob' => 'datetime',
    ];


    
    public function getAge()
    {
        return Carbon::parse($this->attributes['dob'])->age . ' years';
    }

    
    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $this->attributes['first_name']. ' ' .$this->attributes['first_name'],
        );
    }

    public function getRoles(): string
    {
        $roles = $this->roles()->get()->map(function ($item) {
            return $item->name;
        });

        if (empty($roles->toArray())) {
            return 'N/A';
        }

        return implode(', ', $roles->toArray());
    }


    /**
     * Get the department belongs with the user.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /*
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
