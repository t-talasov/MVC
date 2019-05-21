<?php

namespace App\Controller;

class Users
{
    public function run()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `users`
        ");
        $stmt->execute();

        $view = new \App\View\Users();
        $view->render([
            'data' => $stmt->fetchAll()
        ]);
    }

    public function runAdd()
    {
        $errors = [];

        if ($_POST && ! $errors = $this->checkData($_POST)) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                INSERT INTO
                    `users` (
                        `email`,
                        `name`,
                        `password`
                    ) VALUES (
                        :email,
                        :name,
                        :password
                    )
            ");
            $stmt->execute([
                ':email' => $_POST['email'],
                ':name' => $_POST['name'],
                ':password' => sha1($_POST['password'])
            ]);
            header('Location: /users');
            return;
        }

        $view = new \App\View\Users\Form();
        $view->render([
            'errors' => $errors,
            'data' => $_POST
        ]);
    }

    public function runEdit()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `users`
            WHERE
                `id` = :id
        ");
        $stmt->execute([
            ':id' => $_GET['id']
        ]);
        
        $user = $stmt->fetch();
        $errors = [];

        if ($_POST && ! $errors = $this->checkData($_POST)) {
            $stmt = $pdo->prepare("
                UPDATE
                    `users`
                SET
                    `email` = :email,
                    `name` = :name,
                    `password` = :password
                WHERE
                    `id` = :id
            ");
            $stmt->execute([
                ':email' => $_POST['email'],
                ':name' => $_POST['name'],
                ':password' => $_POST['password'] == '' ? $user['password'] : sha1($_POST['password']),
                ':id' => $_GET['id']
            ]);
            header('Location: /users');
            return;
        }

        $view = new \App\View\Users\Form();
        $view->render([
            'errors' => $errors,
            'data' => $user,
            'isUpdate' => $_GET['id']
        ]);
    }

    private function checkData($data)
    {
        $return = [];

        if (! isset($data['password'])
        || ! isset($data['confirm-password'])
        || $data['password'] !== $data['confirm-password']) {
            $return[] = 'Не правильно заполнено поле "Пароль"!';
        }

        return $return;
    }
}