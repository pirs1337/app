<?php

interface Msg{

    public const SUCCESS_MSG = [
        'record' => 'Вы успешно записаны',
        'record_delete' => 'Запись успешно удалена',
        'record_add' => 'Запись добавлена',
        'category' => 'Категоия добавлена',
        'product' => 'Продукт добавлен',
    
        'category_delete' => 'Категория успешно удалена',
        'product_delete' => 'Продукт успешно удален',
    
        'category_edit' => 'Категория успешно редактирована',
        'product_edit' => 'Продукт успешно редактирован',
    
        'img' => 'Изображение успешно удалено'
        
    ];
    
    public const ERROR_MSG = [
        'auth' => 'Аккаунт не найден. Проверьте правильность введённых вами данных и повторите попытку',
 
        'record_find' => 'На данную дату нет записей. Выберите другую дату',
        'record_time' => 'Выберите время',
        'record_delete' => 'Запись не найдена',

        'error' => 'Не удалось успешно выполнить запрос',
    
        'category' => 'Такой категории не существует',
        'product' => 'Такого продукта не существует',
        'img' => 'Такого изображения не существует'
    
    ];

    public const ACCESS_DENIED = 'Доступ запрещен';
}

