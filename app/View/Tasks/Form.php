<?php

namespace App\View\Tasks;

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
                    <h3 class="block-title"><?= isset($data['isUpdate']) ? 'Редактирование задачи' : 'Добавление задачи' ?></h3>
                </div>
                <div class="block-content">
                    <?php
                        if (isset($data['errors']) && $data['errors']) {
                            foreach ($data['errors'] as $error) {
                                ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <p><?= $error ?></p>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                    <form class="form-horizontal push-10-t" enctype="multipart/form-data" action="<?= isset($data['isUpdate']) ? '/tasks/update?id=' . $data['isUpdate'] : '/tasks/add' ?>" method="post">
                        <div class="form-group">
                            <div class="col-xs-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="title" placeholder="Введите название задачи" value="<?= isset($data['data']['title']) ? $data['data']['title'] : '' ?>">
                                    <label for="material-email">Название</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <textarea class="form-control" name="description" placeholder="Ввдедите описание"><?= isset($data['data']['description']) ? $data['data']['description'] : '' ?></textarea>
                                    <label for="material-text">Описание</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12" for="example-file-input">выбрать сабжи</label>
                            <div class="col-xs-12">
                                <input type="file" id="example-file-input" name="image">
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
