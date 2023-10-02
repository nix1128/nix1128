<?php
include '../config/connection.php';
require_once '../interfaces/ReaderInterface.php';
require_once '../core/TransformData.php';


// This logic is meant to work only with local file resource

class DbReader implements ReaderInterface
{
    public function read($from): bool|array
    {
        $conn = OpenCon();

        $serviceUrl = "SELECT service.url from service";

        $service = $conn->query($serviceUrl);

        $media = "SELECT article.title, media.filename, article.published_to AS image_url
            FROM article
            JOIN article_media ON article.id = article_media.article_id
            JOIN media ON article_media.media_id = media.id
            WHERE media.filename IS NOT NULL";

        $media = $conn->query($media);


        if ($service && $media) {
            $serviceData = $service->fetch_all();
            $mediaData = $media->fetch_all();

            $result = ["service" => $serviceData, "media" => $mediaData];

            $link1 = $result["service"][0][0];
            $link2 = $result['service'][1][0];

            $resolution = "/320x180/";

            $data1 = (date('MY', strtotime($result["media"][0][2])));
            $data2 = (date('MY', strtotime($result["media"][1][2])));

            $image1 = $result["media"][0][1];
            $image2 = $result["media"][1][1];

            $concatLink1 = $link1 . $data1 . $resolution . $image1;
            $concatLink2 = $link2 . $data2 . $resolution . $image2;

        } else {
            echo "<br>Error: " . $conn->error;
            CloseCon($conn);
            return false;
        }

        return print_r($concatLink2);
    }

    public function start()
    {
        $this->read($this);
    }
}


$dbRead = new DbReader();
$dbRead->start();
