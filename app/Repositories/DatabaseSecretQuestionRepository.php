<?php

namespace App\Repositories;

use App\SecretQuestion;
use App\Repositories\Contracts\SecretQuestionRepository;

class DatabaseSecretQuestionRepository extends DatabaseRepository implements SecretQuestionRepository
{
    public function getAll($columns = ['*'])
    {
        return collect(
            $this->conn->select('
                select
                    ' . implode(',', $columns) . '
                from secret_questions
            ')
        )->mapInto(SecretQuestion::class);
    }
}
