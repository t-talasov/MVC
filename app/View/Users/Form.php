<?php

namespace App\View\Users;

class Form extends \App\View\Main
{
    public function container($data = [])
    {
        ?>
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button"><i class="si si-settings"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title"><?= isset($data['isUpdate']) ? 'Редактирование пользователя' : 'Добавление пользователя' ?></h3>
                </div>
                <div class="block-content">
                    <?php
                        if (isset($data['errors'])) {
                            foreach ($data['errors'] as $error) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <p><?= $error ?></p>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <form class="form-horizontal push-10-t" action="<?= isset($data['isUpdate']) ? '/users/edit?id=' . $data['isUpdate'] : '/users/add' ?>" method="post">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="material-text" name="name" placeholder="Введите имя пользователя" value="<?= $data['data']['name'] ?? '' ?>">
                                    <label for="material-text">Имя пользователя</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="email" id="material-email" name="email" placeholder="Введите email пользователя" value="<?= $data['data']['email'] ?? '' ?>">
                                    <label for="material-email">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="material-password" name="password" placeholder="Введите пароль пользователя">
                                    <label for="material-password">Пароль</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="material-confirm-password" name="confirm-password" placeholder="Повторите пароль">
                                    <label for="material-password">Повтор пароля</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <button class="btn btn-sm btn-primary" type="submit">Добавить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php
    }
}