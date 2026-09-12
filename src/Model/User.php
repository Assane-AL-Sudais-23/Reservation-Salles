<?php
declare(strict_types=1);

    namespace App\Model;

    use App\Security\Role;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class User extends Model
    {
        protected $table = 'users';

        protected $fillable = [
            'nom',
            'email',
            'password',
            'role',
        ];

        protected $hidden = [
            'password',
        ];

        protected $casts = [
            'id' => 'integer',
            'role' => Role::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function reservations(): HasMany
        {
            return $this->hasMany(Reservation::class, 'user_id', 'id');
        }
    }