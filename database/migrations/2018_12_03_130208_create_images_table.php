<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE images (
              id                  INT IDENTITY NOT NULL,
              file_name           CHAR(20),
              item_id             INT,
            
              CONSTRAINT fk_images_item_id FOREIGN KEY (item_id) REFERENCES items (id),
              CONSTRAINT pk_images PRIMARY KEY (id),
              CONSTRAINT chk_file_name UNIQUE(file_name)
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('
            DROP TABLE images
        ');
    }
}
