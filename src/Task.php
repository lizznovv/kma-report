<?php

class Task
{
    public int $id;
    public DateTime $closedDate;

    public function __construct(int $id, DateTime $closedDate) {
        $this->id = $id;
        $this->closedDate = $closedDate;
    }
}