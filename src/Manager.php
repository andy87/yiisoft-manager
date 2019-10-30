<?php

namespace andy87\yii2\migrate;

use Yii;
use yii\db\Migration;

/**
 * Class Manager
 *
 *      Migration
 *
 *  @and_y87
 *
 * @package common\components
 */
class Manager extends Migration
{
    const ACTIVE    = 1;
    const INACTIVE  = 0;





    public $tableName   = false;





    // T O O L S

    /**
     * Добавыить `Таблицу`.
     *
     * @return array
     */
    public function addTable()
    {
        return [];
    }

    /**
     *  Добавить `Колонку`.
     *
     *  Отдаёт массив вида:
     *      [
     *          'news'  => [
     *              'date_time' => 'INT(7)  AFTER `date`',
     *              'nick_name' => 'VARCHAR(255)  AFTER `author`',
     *          ],
     *
     *          или при $tableName
     *
     *          'birthday' => 'INT(11)  AFTER `status`'
     *      ]
     *
     * @return array
     */
    public function append()
    {
        return [];
    }

    /**
     *  Изменить `Тип колонки`.
     *
     *  Отдаёт массив вида:
     *      [
     *          'news'  => [
     *              'hash_tags' => 'TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *              'nick_name' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *          ],
     *
     *          или при $tableName
     *
     *          'birthday' => 'INT(7) NOT NULL' ]
     *      ]
     *
     * @return array
     */
    public function alert()
    {
        return [];
    }

    /**
     * Изменить `Тип колонки`.
     *
     * Отдаёт массив вида:
     *      [
     *          'news'  => [
     *              'hash_tags' => 'TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *              'nick_name' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *          ],
     *
     *          или при $tableName
     *
     *          'birthday' => 'INT(7) NOT NULL'
     *      ]
     *
     * @return array
     */
    public function upgrade()
    {
        return [];
    }

    /**
     *  Переименовать `колонку`.
     *
     *  Отдаёт массив вида:
     *      [
     *          'news'  => [
     *              'date' => 'date_time',
     *              'nick' => 'nick_name',
     *          ],
     *
     *          или при $tableName
     *
     *          'created_at' => 'birthday'
     *      ]
     *
     * @return array
     */
    public function rename()
    {
        return [];
    }


    


    // T A B L E _ H E A D

    /**
     * То что будет вствлено в начало таблицы.
     *
     * @return array
     */
    private function tableHead()
    {
        return [
            'id' => $this->primaryKey()
        ];
    }

    /**
     * То что будет вствлено посте `id`, `status` ...
     *
     * @return array
     */
    public function afterHead()
    {
        return [];
    }





    // T A B L E _ T A I L

    /**
     * То что будет вствлено перед ... `created_at`.
     *
     * @return array
     */
    public function beforeTail()
    {
        return [];
    }

    /**
     *  То что будет вствлено в конец таблицы.
     *
     * @return array
     */
    private function tableTail()
    {
        return [
            'created_at'        => $this->integer(),
            'updated_at'        => $this->integer(),
        ];
    }





    // C O R E

    /**
     * Ядро создания таблиц.
     *
     * Принимает массив стандартного вида.
     *
     *  в начало вставляет @tableHead()
     *      'id'                => $this->primaryKey(),
     *      'status'            => $this->integer(1)->defaultValue(1),
     *  далее идёт $this->afterHead()
     *
     *  почле этого добавляется $scheme
     *
     *  затем вставляется $this->beforeTail()
     *
     *  в конец добавляется @tableTail()
     *      'created_at'        => $this->integer(),
     *      'updated_at'        => $this->integer(),
     *
     * @param array $scheme
     */
    private function coreCreate( $scheme )
    {
        if ( count($scheme) )
        {
            $tableOptions = ($this->db->driverName === 'mysql')
                ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
                : null;

            $prefix = array_merge( $this->tableHead(), $this->afterHead() );
            $scheme = array_merge( $prefix, $scheme );

            $tail   = array_merge( $this->beforeTail(), $this->tableTail() );
            $scheme = array_merge( $scheme, $tail );

            $this->createTable( "{{%{$this->tableName}}}", $scheme, $tableOptions );
        }
    }





    // R E N A M E

    /**
     * Ядро переименования.
     *
     * Принимает массив вида:
     *  [
     *      'news'  => [
     *          'date' => 'date_time',
     *          'nick' => 'nick_name',
     *      ],
     *      'user'  => [ 'created_at' => 'birthday' ]
     *  ]
     *
     * @param array $rename
     */
    private function coreRename( $rename )
    {
        $this->common( $rename, 'renameColumn' );
    }





    // A D D

    /**
     * Ядро добавления колонок.
     *
     * Принимает массив вида:
     *  [
     *      'news'  => [
     *          'date_time' => 'INT(7)  AFTER `date`',
     *          'nick_name' => 'VARCHAR(255)  AFTER `author`',
     *      ],
     *      'user'  => [ 'birthday' => 'INT(11)  AFTER `status`' ]
     *  ]
     *
     * @param array $add
     */
    private function coreAppend( $add )
    {
        $this->common( $add, 'addColumn' );
    }





    // A L E R T

    /**
     * Ядро изменения типа колонок.
     *
     * Принимает массив вида:
     *  [
     *      'news'  => [
     *          'hash_tags' => 'TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *          'nick_name' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *      ],
     *      'user'  => [ 'birthday' => 'INT(7) NOT NULL' ]
     *  ]
     *
     * @param array $alert
     */
    private function coreAlert( $alert )
    {
        $this->common( $alert, 'alterColumn' );
    }





    // U P G R A D E

    /**
     *  Ядро изменения типа колонок ( Alias coreAlert() ).
     *
     * Принимает массив вида:
     *  [
     *      'news'  => [
     *          'hash_tags' => 'TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *          'nick_name' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL',
     *      ],
     *      'user'  => [ 'birthday' => 'INT(7) NOT NULL' ]
     *  ]
     *
     * @param array $upgrade
     */
    private function coreUpgrade( $upgrade )
    {
        $this->coreAlert( $upgrade );
    }





    // M I G R A T  I O N

    /**
     *
     * @return bool|void
     */
    public function up()
    {
        if ( count( $create = $this->addTable() ) )
        {
            $this->coreCreate( $create );
        }

        if ( count( $alert = $this->alert() ) )
        {
            $this->coreAlert( $alert );
        }

        if ( count( $upgrade = $this->upgrade() ) )
        {
            $this->coreUpgrade( $upgrade );
        }

        if ( count( $rename = $this->rename() ) )
        {
            $this->coreRename( $rename );
        }

        if ( count( $add = $this->append() ) )
        {
            $this->coreAppend( $add );
        }
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        if ( count( $this->addTable() ) )
        {
            $this->dropTable( $this->tableName );
        }
    }

    /**
     * Общая функция для :
     *      - renameColumn
     *      - addColumn
     *      - alterColumn
     *
     * @param array $arr
     * @param string $action renameColumn|addColumn|alterColumn
     */
    public function common( $arr = [], $action = '' )
    {
        //  если переменная tableName есть то в функциях
        //      coreRename coreAddColumn coreAlert coreUpgrade
        //          не обязательно делать основной ключ с именем таблицы
        if ( $this->tableName AND !is_array($arr[0][0]) )
        {
            $scheme = $arr;

            $arr    = [];

            $arr[ $this->tableName ] = $scheme;
        }

        foreach ( $arr as $tableName => $items )
        {
            foreach ( $items as $key => $val )
            {
                $table = Yii::$app->db->schema->getTableSchema( $this->tableName );

                if ( $tableName == 'addColumn' AND isset($table->columns[ $key ]) )
                {
                    continue;
                }

                $this->$action( "{{%{$tableName}}}", $key, $val );
            }
        }
    }
}