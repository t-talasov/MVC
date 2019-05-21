<?php

namespace App\View;

class Users extends Main
{
    public function container($data = [])
    {
        $options = [
            'id' => [
                'label' => '#',
                'class' => 'text-center'
            ],
            'email' => [
                'label' => 'Email',
                'class' => '',
            ],
            'name' => [
                'label' => 'Имя пользователя',
                'class' => '',
            ],
            'actions' => [
                'label' => 'Действия',
                'class' => 'text-center',
                'buttons' => [
                    'edit' => [
                        'icon' => 'fa-pencil',
                        'route' => '/users/edit',
                    ],
                    'delete' => [
                        'icon' => 'fa-trash',
                        'route' => '/users/delete',
                    ],
                ]
            ],
        ];

        $buttons = [
            [
                'label' => 'Добавить',
                'route' => '/users/add',
            ]
        ];

        $this->table($data['data'], $options, $buttons);
    }
}