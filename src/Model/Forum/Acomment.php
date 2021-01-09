<?php

namespace Lii\Model\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Lii\Model\Textfilter\MyTextfilter;

/**
 * A database driven model using the Active Record design pattern.
 */
class Acomment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Acomment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $text;
    public $answId;
    public $userId;
    public $created;
    public $updated;
    public $deleted;
    public $active;

    /**
     * Return the filtered data variable from the object
     *
     * @return string
     */
    public function getDataFiltered($filter)
    {
        $textFilter = new MyTextfilter();
        $filters = explode(",", $filter);
        array_push($filters, 'strip');
        return $textFilter->parse($this->text, $filters);
    }
}
