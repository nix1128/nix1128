<?php


interface ReaderInterface
{

    public function start();
    public function read(string|object $from);

}