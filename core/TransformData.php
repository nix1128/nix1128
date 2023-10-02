<?php

require_once '../interfaces/ReaderInterface.php';
require_once 'CurlReader.php';
require_once 'LocalReader.php';

class TransformData implements ReaderInterface
{
    public function read($from): bool|string
    {
        {
            if ($from === 'curl') {
                return (new CurlReader())->start();
            } elseif ($from === 'local') {
                return (new LocalReader())->start();
            }

            throw new \InvalidArgumentException("<br>Unsupported reader: $from");
        }
    }

    public function transform(string $from)
    {
      return $this->read($from);
    }

    public function start()
    {
      $this->transform('local');
    }

}

$transformer = new TransformData();
$transformer->start();





