<?php
namespace Database\Migrations;

    use Database\MigrationInterface;
    use Illuminate\Database\Capsule\Manager as Capsule;

    class CreateSallesTable implements MigrationInterface
    {
        public function up(): void
        {
            if (!Capsule::schema()->hasTable('salles')) {
                Capsule::schema()->create('salles', function ($table) {
                    $table->increments('id');
                    $table->string('nom');
                    $table->integer('capacite');
                    $table->enum('type', ['amphi', 'tp', 'reunion', 'standard'])->default('standard');
                    $table->boolean('active')->default(true);
                    $table->timestamps();
                });
                echo "Table 'salles' créée.\n";
            }
        }

        public function down(): void
        {
            Capsule::schema()->dropIfExists('salles');
            echo "Table 'salles' supprimée.\n";
        }
    }