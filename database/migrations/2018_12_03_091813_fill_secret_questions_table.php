<?php

use Illuminate\Database\Migrations\Migration;

class FillSecretQuestionsTable extends Migration
{
    public $questions = [
        'In welke straat ben je geboren?',
        'Wat is de meisjesnaam je moeder?',
        'Wat is je lievelingsgerecht?',
        'Hoe heet je oudste zusje?',
        'Hoe heet je huisdier?'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect($this->questions)->map(function ($question) {
            $this->insertSecretQuestion($question);
        });
    }

    public function insertSecretQuestion($question)
    {
        return statement('
            INSERT INTO secret_questions
                (question)
            VALUES
                (:question)
        ', [
            'question' => $question
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        statement('
            DELETE FROM secret_questions
        ');
    }
}
