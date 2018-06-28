<?php
class HttpFileBase
{
    public function __construct($fileName)
    {
        $this->HasFiles = sizeof($_FILES) > 0;
        $this->FileKey = $fileName;
    }

    public function SaveAs($fileKey, $path, $savename)
    {
        move_uploaded_file($savenames, $path);
    }
}
?>