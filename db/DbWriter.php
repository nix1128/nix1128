<?php
include '../config/connection.php';
require_once '../interfaces/WriterInterface.php';
require_once '../core/TransformData.php';

class DbWriter implements WriterInterface
{

    public TransformData $trans;

    public function __construct(TransformData $transD)
    {
        $this->trans = $transD;
    }

    public function read(): bool|string|array
    {

        $resource = "../assets/resource.json";
        $local = "../assets/task.json";

        if (!file_exists($resource) && !file_exists($local)) {
            $this->trans->start();
        }

        $json = file_get_contents("../assets/task.json");

        return json_decode($json, true);

    }

    public function write()
    {
        $conn = OpenCon();

        foreach ($this->read() as $item) {
            $title = $item['title'];
            $body = $item['body'];
            $published_from = $item['published_from'];
            //published to = 30 days
            $published_to = date('Y-m-d H:i:s', strtotime($published_from . ' +30 days'));

            $type = $item['type'];
            $status = $item['status'];
            $media_filename = $item['media_filename'];
            $media_published = date('Y-m-d H:i:s', $item['media_published']);
            $media_service_id = $item['media_service_id'];
            $media_type = $item['media_type'];

            // Insert into the 'article' table
            $sqlArt = $conn->prepare("INSERT INTO article (title, body, published_from, type, status, published_to) VALUES (?, ?, ?, ?, ?, ?)");
            $sqlArt->bind_param("ssssss", $title, $body, $published_from, $type, $status, $published_to);

            if (!$sqlArt->execute()) {
                die('Error inserting into article: ' . $sqlArt->error);
            }

            $article_id = $conn->insert_id;

            // Insert into the 'media' table
            $sqlMed = $conn->prepare("INSERT INTO media (filename, published, service_id, type) VALUES (?, ?, ?, ?)");
            $sqlMed->bind_param("ssss", $media_filename, $media_published, $media_service_id, $media_type);

            if (!$sqlMed->execute()) {
                die('Error inserting into media: ' . $sqlMed->error);
            }

            $media_id = $conn->insert_id;

            // Insert into the 'article_media' junction table
            $sqlArt_Med = $conn->prepare("INSERT INTO article_media (article_id, media_id) VALUES (?, ?)");
            $sqlArt_Med->bind_param("ii", $article_id, $media_id);


            if (!$sqlArt_Med->execute()) {
                die('Error inserting into article_media: ' . $sqlArt_Med->error);
            }
        }

        echo "<br> Successful Data fetch and DB upload";
        CloseCon($conn);
    }

}


$trans = new TransformData();
$dw = new DbWriter($trans);
$dw->read();
$dw->write();








