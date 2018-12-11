<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepository;

class DatabaseCategoryRepository extends DatabaseRepository implements CategoryRepository
{
    public function getAll()
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive 
            FROM categories 
            WHERE inactive = 0
            ORDER BY name ASC
        ');
    }

    public function getAllByParentId($id)
    {
        return $this->conn->select('
                SELECT id, name, parent, order_number, inactive 
                FROM categories 
                WHERE parent = ?
                AND inactive = 0
                ORDER BY name ASC',
            [$id]
        );
    }

    public function getChildrenFor(array $ids)
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive
            FROM categories
            WHERE parent IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ')
            AND inactive = 0
            ORDER BY order_number ASC, name ASC
        ', $ids);
    }

    public function getById($id)
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive
            FROM categories
            WHERE id = ?
            AND inactive = 0',
            [$id]
        );
    }

    public function getAllParentsById($id)
    {
        return $this->conn->select(
            '
            WITH tblParent AS
            (
                SELECT *
                    FROM categories WHERE id = ?
                UNION ALL
                SELECT categories.*
                    FROM categories  JOIN tblParent  ON categories.id = tblParent.parent
            )
            SELECT * FROM  tblParent
                WHERE id <> ? AND id > 0
            ORDER BY parent ASC
            OPTION(MAXRECURSION 64)',
            [$id, $id]
        );
    }

    public function getAllByParentIdOrdered($id)
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive
            FROM categories
            WHERE parent = ?
            AND inactive = 0
            ORDER BY order_number ASC, name ASC',
            [$id]
        );
    }

    public function getLevelWithChildren($parent_id)
    {
        $parents = $this->getAllByParentId($parent_id);
        if (count($parents)) {
            return collect($parents)
                ->pipe(function ($parents) {
                    $children = collect($this->getChildrenFor($parents->pluck('id')->toArray()))
                        ->groupBy('parent');

                    return $parents->map(function ($parent) use ($children) {
                        $parent->children = $children[$parent->id] ?? [];

                        return $parent;
                    });
                })
                ->toArray();
        }
        return [];
    }

    public function create($name, $parent)
    {
        $id = $this->getHighestId();
        $id++;

        $order_number = $this->getHighestOrderNumber();
        $order_number++;

        $this->conn->insert('
            INSERT INTO categories
                (id, name, parent, order_number)
            VALUES
                (:id, :name, :parent, :order_number)
        ', [
            'id' => $id,
            'name' => $name,
            'parent' => $parent,
            'order_number' => $order_number
        ]);
    }

    private function getHighestId()
    {
        $highest_id = $this->conn->select('
            SELECT TOP 1 id 
            FROM categories 
            ORDER BY id DESC;
        ');

        return intval($highest_id[0]->id);
    }

    private function getHighestOrderNumber()
    {
        $highest_order_number = $this->conn->select('
            SELECT TOP 1 order_number 
            FROM categories 
            ORDER BY order_number DESC;
        ');

        return intval($highest_order_number[0]->order_number);
    }

    public function disable($id)
    {
        $children = $this->conn->select('
            DECLARE @Id int = ? -- your UnitId
            ;WITH cte AS 
             (
              SELECT a.id, a.parent
              FROM categories a
              WHERE parent = @Id
              UNION ALL
              SELECT a.id, a.parent
              FROM categories a JOIN cte c ON a.parent = c.id
               and c.id != @Id
            
              )
              SELECT id
              FROM cte',
            [$id]
        );

        foreach ($children as $child)
        {
            $this->disableById($child->id);
        }

        $this->disableById($id);
    }

    private function disableById($id)
    {
        $this->conn->update('
            UPDATE categories
                SET inactive = 1
            WHERE id = :id',
            [
                'id' => $id
        ]);
    }

    public function updateName($id, $name)
    {
        return $this->conn->update('
            UPDATE categories
                SET name = :name
            WHERE id = :id
        ', [
            'name' => $name,
            'id' => $id
        ]);
    }

    public function updateOrderNumber($id, $current_order_number, $new_order_number)
    {
        $replacement = $this->checkOrderNumber($new_order_number);

        if ($replacement) {
            $replaced = $this->replaceOrderNumber($replacement[0]->id, $current_order_number);

            if ($replaced) {
                $this->changeOrderNumber($id, $new_order_number);
            } else {
                print_r('Error 2');
            }
        } else {
            $this->changeOrderNumber($id, $new_order_number);
        }
    }

    private function checkOrderNumber($order_number)
    {
        return $this->conn->select('
            SELECT TOP 1 id 
            FROM categories 
            WHERE order_number = ?;',
            [$order_number]
        );
    }

    private function replaceOrderNumber($replacementId, $current_order_number)
    {
        $replaced = $this->conn->update('
                UPDATE categories
                    SET order_number = :order_number
                WHERE id = :id
            ', [
            'order_number' => $current_order_number,
            'id' => $replacementId
        ]);

        if ($replaced) {
            return true;
        } else {
            return false;
        }
    }

    private function changeOrderNumber($id, $new_order_number)
    {
        $updated = $this->conn->update('
                    UPDATE categories
                        SET order_number = :order_number
                    WHERE id = :id
                ', [
            'order_number' => $new_order_number,
            'id' => $id
        ]);

        if ($updated) {
            print_r('Success!');
        } else {
            print_r('Error 1');
        }
    }
}
