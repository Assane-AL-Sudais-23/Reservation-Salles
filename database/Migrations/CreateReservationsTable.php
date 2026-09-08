<?php

    namespace Database\Migrations;

    use Database\MigrationInterface;
    use Illuminate\Database\Capsule\Manager as Capsule;

    class CreateReservationsTable implements MigrationInterface
    {
        public function up(): void
        {
            if (!Capsule::schema()->hasTable('reservations')) {
                Capsule::schema()->create('reservations', function ($table) {
                    $table->increments('id');
                    $table->integer('user_id')->unsigned();
                    $table->integer('salle_id')->unsigned();
                    $table->dateTime('date_debut');
                    $table->dateTime('date_fin');
                    $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])->default('en_attente');
                    $table->timestamps();

                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
                });
                echo " Table 'reservations' créée.\n";
            }
        }

        public function down(): void
        {
            Capsule::schema()->dropIfExists('reservations');
            echo "Table 'reservations' supprimée.\n";
        }
    }