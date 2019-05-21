<?php

namespace App\View;

class Tasks extends Main
{
    public function container($data = [])
    {
        $options = [
            'id' => [
                'label' => '#',
                'class' => 'text-center',
            ],
            'title' => [
                'label' => 'Задача',
                'class' => '',
            ],
            'description' => [
                'label' => 'Описание',
                'class' => '',
                'trans' => function($row)
                {
                    if($row['status'] == 0) {
                        return '<span class="label label-success">в ожидании</span>';
                    } else {
                        return '<span class="label label-success">опубликовано</span>';
                    }
                }
            ],
            'status' => [
                'label' => 'Статус',
                'class' => '',
            ],
            'actions' => [
                'label' => 'Действия',
                'class' => 'text-center',
                'buttons' => [
                    'update' => [
                        'icon' => 'fa-pencil',
                        'label' => 'Редактировать',
                        'route' => '/tasks/update',
                    ],
                    'delete' => [
                        'icon' => 'fa-trash',
                        'label' => 'Удалить',
                        'route' => '/tasks/delete',
                    ],
                ],
            ],
        ];

        $buttons = [
            [
                'label' => 'Добавить',
                'route' => '/tasks/add',
            ],
        ];

        $this->table($data['data'], $options, $buttons);
    }
}
