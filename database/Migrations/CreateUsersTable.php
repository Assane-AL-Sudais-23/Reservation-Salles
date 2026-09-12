<?php
namespace Database\Migrations;

    use Database\MigrationInterface;
    use Illuminate\Database\Capsule\Manager as Capsule;

    class CreateUsersTable implements MigrationInterface
    {
        public function up(): void
        {
            if (!Capsule::schema()->hasTable('users')) {
                Capsule::schema()->create('users', function ($table) {
                    $table->increments('id');
                    $table->string('nom');
                    $table->string('email')->unique();
                    $table->string('password');
                    $table->enum('role', ['admin', 'responsable'])->default('responsable');
                    $table->timestamps();
                });
                echo "Table 'users' créée.\n";
            } elseif (Capsule::schema()->hasColumn('users', 'role')) {
                Capsule::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin', 'responsable') NOT NULL DEFAULT 'responsable'");
                echo "Colonne 'role' mise à jour dans la table 'users'.\n";
            }
        }

        public function down(): void
        {
            Capsule::schema()->dropIfExists('users');
            echo "Table 'users' supprimée.\n";
        }
    }