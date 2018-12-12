<?php

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
                id          INT IDENTITY NOT NULL, -- Primary key
                file_name   CHAR(20), -- Afbeelding naam wat opgeslagen wordt in de server
                item_id     INT, -- Foreign key naar een item in de items tabel
            
                CONSTRAINT pk_images PRIMARY KEY (id),
                CONSTRAINT fk_images_item_id FOREIGN KEY (item_id) REFERENCES items (id),
                CONSTRAINT chk_file_name UNIQUE(file_name) -- Zorgt voor dat er geen duplicate afbeelding namen zijn
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
