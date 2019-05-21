<?php

namespace App\Controller;

class Tasks
{
    public function run()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `tasks`
        ");
        $stmt->execute();
        
        $view = new \App\View\Tasks();
        $view->render([
            'data' => $stmt->fetchAll()
        ]);
    }

    public function runAdd()
    {

        $errors = [];
        if ($_POST) {

            $errors = $this->checkData($_POST);
            if (! $errors) {
                $pdo = \App\Service\DB::get();
                $stmt = $pdo->prepare("
                    INSERT INTO
                        `tasks` (
                            `title`,
                            `description`
                        ) VALUES (
                            :title,
                            :description
                        )
                ");
                $stmt->execute([
                    ':title' => $_POST['title'],
                    ':description' => $_POST['description']
                ]);

                $this->uploadImage($_FILES['image'], $pdo->lastInsertId());

                header('Location: /tasks');
                return;
            }
        }

        $view = new \App\View\Tasks\Form();
        $view->render([
            'errors' => $errors,
            'data' => $_POST,
        ]);
    }

    public function runUpdate()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `tasks`
            WHERE
                `id` = :id
        ");

        $stmt->execute([
            ':id' => $_GET['id']
        ]);

        $task = $stmt->fetch();

        $errors = $this->checkData($_POST);

        if ($_POST && ! $errors) {

            $stmt = $pdo->prepare("
                UPDATE
                    `tasks`
                SET
                    `title` = :title,
                    `description` = :description
                WHERE
                    `id` = :id
            ");

            $stmt->execute([
                ':title' => $_POST['title'],
                ':description' => $_POST['description'],
                ':id' => $_GET['id'],
            ]);



            header('Location: /tasks');
            return;
        }

        $view = new \App\View\Tasks\Form();
        $view->render([
            'data' => [
                'title' => $task['title'],
                'description' => $task['description'],
            ],
            'isUpdate' => $_GET['id']
        ]);
    }

    public function runDelete()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            DELETE FROM
                `tasks`
            WHERE
                `id` = :id
        ");
        $stmt->execute([
            ':id' => $_GET['id']
        ]);

        header('Location: /tasks');
        return;
    }

    public function checkData($data)
    {
        $return = [];
        if (
            ! isset($data['title'])
            || $data['title'] == ''
        ) {
            $return['title'] = 'Забыли назвать задачу';
        }

        if (
            ! isset($data['description'])
            || $data['description'] == ''
        ) {
            $return['description'] = 'Забыли описать задачу';
        }

        return $return ;
    }


    function uploadImage($image, $id)
    {
        $extension = ['jpeg', 'jpg'];
        $exp = explode('.', $image['name']);
        if (! in_array(end($exp), $extension)) {
            return;
        }
        $imageFile = UPLOAD_DIR. '/'. sha1($id).  '.jpg';
        move_uploaded_file($image['tmp_name'], $imageFile);
            
    }
}





