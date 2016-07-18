<?php
namespace Framework\Database\Tables;

/**
 * Lewis Lancaster 2016
 *
 * Class Example
 *
 * @package Framework\Database\Tables
 */

use Framework\Database\Table;

class Example extends Table
{

    /**
     * We must extend the table parent class to access database methods. Its important that we extend our parent because
     * the database connection is automatically created.
     *
     * The class name is relative to the table name you are accessing, so, this class known as 'Example' will be accessing
     * the database table 'example'. This can be changed in the construct.
     *
     * @param $id
     *
     * @return mixed|null
     */

    public function getExample( $id )
    {

        $array = array(
            'id'    => $id
        );

        $result = $this->getTable()->where( $array )->get();

        return ( empty( $result ) ) ? null : reset( $result );
    }
}