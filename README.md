<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Manager</h1>
</p>

Система для построения миграций.  
***Задача :*** быстро описывать миграции таблиц.
<hr>

##### INSTALL
Добавить в `composer.json`  
<small>require</small>  
```
"require": {
    ...
    "andy87/yiisoft-manager" : "1.0.1"
},
```  
<small>repositories</small>  

```
"repositories": [
    ...,
    {
        "type"                  : "package",
        "package"               : {
            "name"                  : "andy87/yiisoft-manager",
            "version"               : "1.0.1",
            "source"                : {
                "type"                  : "git",
                "reference"             : "master",
                "url"                   : "https://github.com/andy87/yiisoft-manager"
            },
            "autoload": {
                "psr-4": {
                    "andy87\\yii2\\manager\\console\\components\\": "src/console/components"
                }
            }
        }
    }
]
```
выполнить: `php composer.phar update`

Создать файл `console/components/Manager.php`
```php
<?php

namespace console\components;

class Manager extends \andy87\yii2\manager\console\components\Manager
{
  // ...
}
```
<br>
  
### Порядок выполнения кода
- **`addTable()`**  
- **`alert()`**  
- **`upgrade()`**  
- **`rename()`**  
- **`demo()`**  

<br>

### Рабочие методы для построения миграций

##### Создание таблицы
`addTable()`
```php
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
  
Создание таблицы, к примеру  *`members`*:
```php
class m....table_name__add extend Manager 
{
    public $tableName = 'member';
    public $tableComment = 'Участники';

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

Во все генерируемые таблицы из вспомогательных методов вставляется *`id, created_at, updated_at`*

##### Дабавить строки в начало таблицы
**`tableHead()`**  
```php
public function tableHead()
{
    return [
        'id' => $this->primaryKey()->comment('ID')
    ];
}
```
##### Дабавить строки после "tableHead" и перед "addTable"
**`afterHead()`**  
```php
public function afterHead()
{
    return [];
}
```

##### Блок перед "tableTail" и после "addTable"
**`beforeTail()`**  
```php
public function beforeTail()
{
    return [];
}
```

##### Последний блок
**`tableTail()`**  
```php
public function tableTail()
{
    return [
        'created_at'            => $this->integer(11)->comment('Дата создания')
        'updated_at'            => $this->integer(11)->comment('Дата редактирования')
    ];
}
```

все эти блоки можно переназначить по необходимости.  

# Редактирование  
  
### Добавление колонок
**`append()`**  
```php
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
Добавление колонок, к примеру в талицу *`news`*, через *`public`*:
```php
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
Добавление колонок, к примеру в талицу *`blog`*,  через *`key`*:
```php
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
в несколько таблиц, к примеру *`news`* + *`blog`* + *`profile`*, через *`key`*  
```php
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
  
  
### Переименование колонок  
**`rename()`**
```php
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
Переименование колонок, к примеру в таблице *`news`*, через *`public`*  
```php
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
Переименование колонок, к примеру в таблице *`news`*, через *`key`*  
```php
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
в нескольких таблицах, к примеру *`news`* + *`blog`* + *`profile`*, через *`key`* 
```php
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
  
  
### Изменение свойства колонок  
**`upgrade()`**
```php
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
Изменение свойства колонок, к примеру в таблице *`page`*, через *`public`*  
```php
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
Переименование колонок, к примеру в таблице *`news`*, через *`key`*  
```php
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
в нескольких таблицах, к примеру *`news`* + *`blog`* + *`profile`*, через *`key`* 
```php
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

### тестовые данные  
Вставляются в таблицу после её создания.  
**`demo()`**  
```php
class m....news__upgrade extend Manager 
{
    public $tableName = 'formula';
    public $tableComment = 'Формула';

    public function addTable()
    {
        return [
            'foo'           => $this->string(32)->notNull()->comment('первое значение'),
            'bar'           => $this->string(32)->notNull()->comment('второе значение'),
            'result'        => $this->string(255)->notNull()->comment('результат'),
        ];
    }
    public function demo()
    {
        return [
            [
                'foo'           => 'a1',
                'bar'           => 'b2',
                'result'        => 'a1b2',
            ],
            [
                'foo'           => 'c3',
                'bar'           => 'd4',
                'result'        => 'c3d4',
            ],
            [
                'foo'           => 'e5',
                'bar'           => 'f6',
                'result'        => 'e5f6',
            ]
        ];
    }
}
```
### Индексы  
**`addIndex( $table, $columns, $unique )`**  
Создание index
```php
$this->createIndex(
    "idx-{$source}-{$target}",
    $source,
    $target,
    $unique     // Default : false
);

```

**`createForeignKey( $source, $target, $refTable, $refColumns, $delete)`**  
Создание foreign key
```php
$this->addForeignKey(
    "fk-{$source}-{$target}",
    $source,
    $target,
    $refTable,
    $refColumns,
    $delete          // Default : CASCADE
);
```

## Вспомогательные методы  
Если надо останвоить выполнение миграций в рабочем методе вызывается функция: 
**`setStatus( $status )`**  
Выходит из миграции в начале *`up()`* невыполняя описанную миграцию  

**`setDev( $status )`**  
Выходит из миграции в конце *`up()`* выполняя описанную миграцию, но не записывая её как выполненую в таблицу `Migration`  
