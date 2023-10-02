<?php

require_once '../interfaces/ReaderInterface.php';

class LocalReader implements ReaderInterface
{

    public function start(): string
    {
        $filename = "../assets/task.json";

        if (!file_exists($filename)){
            echo "<br> file is missing ";

        }

        echo "<br>Sucess local fetch... ";
        return file_get_contents($filename);

    }

    public function read($from): bool|string
    {
        return json_decode($this->start());
    }
}
