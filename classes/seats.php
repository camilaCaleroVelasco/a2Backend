<?php
class Seat {
    // Properties
    public $show_id;
    public $row;
    public $column;
    public $isAvailable;

    // Methods
    function set_show_id($show_id){
        $this->show_id = $show_id;
    }

    function set_row($row){
        $this->row = $row;
    }

    function set_column($column){
        $this->column = $column;
    }

    function set_isAvailable($isAvailable){
        $this->isAvailable = $isAvailable;
    }

    function get_show_id(){
        return $this->show_id;
    }

    function get_row(){
        return $this->row;
    }

    function get_column(){
        return $this->column;
    }

    function get_isAvailable(){
        return $this->isAvailable;
    }
}