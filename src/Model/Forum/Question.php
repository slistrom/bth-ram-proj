<?php

namespace Lii\Model\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Lii\Model\Textfilter\MyTextfilter;

/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Question";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $text;
    public $userId;
    public $answered;
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
