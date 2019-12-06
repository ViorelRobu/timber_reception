<?php

namespace App\Traits;

trait Translatable {
    /**
     * You have to define your own FK and translations that you would like in your history display.
     * This variable has to be defined in each class using Translatable trait
     * The format is the following
     *      protected $dictionary = [
     *          foreign_key' => ['translated_column_name', 'model_name', 'column_name']
     *      ];
     * /

    /**
     * Translate the Foreign Keys ID's from the auditable table into human readable data
     * 
     * @param string $item
     * @return array
     */
    protected function translate(string $item)
    {
        $value = [];

        foreach ($this->dictionary as $key => $val) {
            if ($item == $key) {
                $value = $val;
            }
        }

        return $value;
    }

}