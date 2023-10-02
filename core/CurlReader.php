<?php

require_once '../interfaces/ReaderInterface.php';

class CurlReader implements ReaderInterface
{

    public function read(string|object $from): CurlHandle|bool
    {
        return  curl_init($from);
    }


    public function start()
    {
        $ch =  $this->read("https://jsonplaceholder.typicode.com/posts");
        $data = fopen("../assets/resource.json", "w");

        curl_setopt($ch, CURLOPT_FILE, $data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $result = curl_exec($ch);


        if (curl_errno($ch) && $result === false) {
            echo curl_error($ch);
            return false;
        } else {
            echo "Success curl fetch <br> ";
            curl_close($ch);

            fclose($data);

            return $data;
        }
    }
}



