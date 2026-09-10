<?php
declare(strict_types=1);

    namespace App\Model;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Reservation extends Model
    {
        protected $table = 'reservations';

        protected $fillable = [
            'user_id',
            'salle_id',
            'date_debut',
            'date_fin',
            'statut',
        ];

        protected $casts = [
            'id' => 'integer',
            'user_id' => 'integer',
            'salle_id' => 'integer',
            'date_debut' => 'datetime',
            'date_fin' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function salle(): BelongsTo
        {
            return $this->belongsTo(Salle::class, 'salle_id', 'id');
        }
    }