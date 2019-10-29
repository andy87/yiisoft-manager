<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Manager</h1>
    Система для построения миграций
    <br>
</p>

#### Template
```
<?php

/**
 * Class m191029_094215_user__upgrade
 */
class m000000_000000_name__addTable extends Manager
{
    
}

```

#### addTable()
Создание таблицы 
```
<?php
/**
 * Class m000000_000000_name__addTable
 */
class m000000_000000_name__addTable extends Manager
{
    public function addTable()
    {
        return [];
    }    
}
```
  
Создание таблицы, к примеру  `members`:
```
class m....table_name__add extend Manager 
{
    public $tableName = 'members';

    public function addTable()
    {
        return [
            'author'            => $this->text()->notNull()->comment('Автор'),
            'content'           => $this->text()->notNull()->comment('Контент'),
            'source'            => $this->string(255)->notNull()->comment('ссылка на оригинал'),
        ];
    }
}
```
#### tableHead()
 - Начало таблицы
```
public function tableHead()
{
    return [
        'id' => $this->integer(7)->notNull()->comment('Айди')
    ];
}
```
#### afterHead()
 - Блок за `id`
```
public function afterHead()
{
    return [];
}
```
#### addTable()
 - Главный блок - блок за `afterHead` 
```
public function addTable()
{
    return [];
}
```
#### beforeTail()
 - Блок перед окончанием
```
public function beforeTail()
{
    return [];
}
```

#### tableTail()
 - Последний блок
```
public function tableTail()
{
    return [
        'created_at'            => $this->integer(11)->comment('Дата создания')
        'updated_at'            => $this->integer(11)->comment('Дата редактирования')
    ];
}
```

# Редактирование  
  
#### append()
Добавление колонок
```
<?php
/**
 * Class m000000_000000_name__append
 */
class m000000_000000_name__append extends Manager
{
    public function append()
    {
        return [];
    }    
}
```
Добавление колонок, к примеру в талицу `news`, через `public`:
```
class m....news__append extend Manager 
{
    public $tableName = 'news';

    public function append()
    {
        return [
            'role'              => 'integer(10) AFTER `username`',
            'date_time'         => 'integer(11) AFTER `role`'
        ];
    }
}
```
  
Добавление колонок, к примеру в талицу `blog`,  через `key`:
```
class m....news__append extend Manager 
{
    public function append()
    {
        return [
            'blog'    => [
                'role'          => 'integer(10) AFTER `username`',
                'date_time'     => 'integer(11) AFTER `role`'
            ],
           
        ];
    }
}
```
  
  
##### в несколько таблиц, к примеру `news` + `blog` + `profile`, через `key`
```
class m....news_blog_profile__appends extend Manager 
{
    public function append()
    {
        return [
            'news'          => [
                'category'      => 'integer(3) AFTER `header` NOT NULL',
                'weight'        => 'integer(7) AFTER `category` DEFAULT(0)'
            ],
            'blog'          => [
                'category'      => 'integer(2) AFTER `header`',
                'position'      => 'string(32) AFTER `category` NULL'
            ],
            'profile'       => [
                'role'          => 'integer(2) AFTER `username`',
                'gender'        => 'integer(1) AFTER `role` NULL'
            ]
        ];
    }
}
```
  
  
#### rename()
Переименование колонок 
```
<?php
/**
 * Class m000000_000000_name__rename
 */
class m000000_000000_name__rename extends Manager
{
    public function rename()
    {
        return [];
    }    
}
```
Переименование колонок, к примеру в таблице `news`, через `public`
```
class m....news__rename extend Manager 
{
    public $tableName = 'news';

    public function rename()
    {
        return [
            'role'              => 'role_id',
            'weight'            => 'views'
        ];
    }
}
```
  
Переименование колонок, к примеру в таблице`news`, через `key`
```
class m....news__rename extend Manager 
{
    public function rename()
    {
        return [
            'news'          => [
                'role'          => 'role_id',
                'weight'        => 'views'
            ]
        ];
    }
}
```
  
  
##### в нескольких таблицах, к примеру `news` + `blog` + `profile`, через `key`
```
class m....foo_bar_next__renames extend Manager 
{
    public function rename()
    {
        return [
            // название таблицы где меняем имена
            'news'          => [
                'role'          => 'role_id',
                'weight'        => 'views'
            ],
            'blog'          => [
                'group'         => 'category',
                'weight'        => 'views'
            ],
            'profile'       => [
               'role'           => 'role_id',
               'created_at'     => 'birth_day'
            ]
        ];
    }
}
```
  
  
#### upgrade()
Изменение свойства колонок 
```
<?php
/**
* Class m000000_000000_name__upgrade
*/
class m000000_000000_name__upgrade extends Manager
{
  public function upgrade()
  {
      return [];
  }    
}
```
Изменение свойства колонок, к примеру в таблице `page`, через `public`
```
class m....news__upgrade extend Manager 
{
    public $tableName = 'page';

    public function upgrade()
    {
        return [
            'category'          => 'integer(2) AFTER `username`',
            'description'       => 'VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL'
        ];
    }
}
```
  
Переименование колонок, к примеру в таблице `news`, через `key`
```
class m....news__upgrade extend Manager 
{
    public function upgrade()
    {
        return [
            'news'    => [
                'category'      => 'integer(2) AFTER `username`',
                'description'   => 'VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL'
            ]
        ];
    }
}
```
  
  
##### в нескольких таблицах, к примеру `news` + `blog` + `profile`, через `key`
```
class m....foo_bar_next__upgrads extend Manager 
{
    public function upgrade()
    {
        return [
            // название таблицы где меняем свойства колонки
            'news'          => [
                // имя колонки  => "тип колонки"
                'category'      => 'integer(2) AFTER `username`',
                'description'   => 'VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL'
            ],
            'blog'          => [
                'role'          => 'integer(1) NULL DEFAULT(2)',
                'date_time'     => 'string(11) NOT NULL'
            ],
            'profile'       => [
                'role'          => 'integer(1) NULL DEFAULT(2)',
                'date_time'     => 'string(11) NOT NULL'
            ]
        ];
    }
}
```
