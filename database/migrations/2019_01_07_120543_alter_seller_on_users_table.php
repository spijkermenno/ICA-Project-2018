<?php

use Illuminate\Database\Migrations\Migration;

class AlterSellerOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            DECLARE @default_name varchar(256)
            SELECT @default_name = [name] FROM sys.default_constraints
            WHERE parent_object_id = object_id(\'users\')
                AND col_name(parent_object_id, parent_column_id) = \'seller\'

            exec(\'alter table users drop constraint \' + @default_name)
        ');

        statement('
            ALTER TABLE users
                DROP COLUMN seller
        ');

        statement('
            ALTER TABLE users
                ADD seller AS dbo.is_user_seller(users.name)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
