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
                    $table->enum('role', ['user', 'admin'])->default('user');
                    $table->timestamps();
                });
                echo "Table 'users' créée.\n";
            }
        }

        public function down(): void
        {
            Capsule::schema()->dropIfExists('users');
            echo "Table 'users' supprimée.\n";
        }
    }