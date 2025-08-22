<?php

namespace app\controllers\api\helpers;

use app\database\DBQuery;

class Image
{
    private $db;

    public function __construct()
    {
        $this->db = new DBQuery;
    }
    
    public function saveImage(string $url, int $id, int $order): string
    {
        $imageContent = @file_get_contents($url);
        if ($imageContent === false) {
            throw new \Exception("Failed to download image from URL: {$url}");
        }

        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        $ext = strtolower($ext ?: 'jpg');

        $fileName = "{$id}_{$order}.{$ext}";
        $filePathOriginal = rtrim(IMG_PATH_ORIGINAL, '/') . '/' . $fileName;
       
        if (file_put_contents($filePathOriginal, $imageContent) === false) {
            throw new \Exception("Failed to save image to path: {$filePathOriginal}");
        }

        // Redimensionar e salvar em diferentes tamanhos
        $this->resizeAndSaveImage($filePathOriginal, IMG_PATH_1300, 1300, $fileName);
        $this->resizeAndSaveImage($filePathOriginal, IMG_PATH_0800, 800, $fileName);
        $this->resizeAndSaveImage($filePathOriginal, IMG_PATH_0200, 200, $fileName);


        return $fileName;
    }

    private function resizeAndSaveImage(string $srcPath, string $destDir, int $maxWidth, string $fileName): void
    {
        [$origWidth, $origHeight, $imageType] = getimagesize($srcPath);
        $ratio = $origHeight / $origWidth;
        $newWidth = $maxWidth;
        $newHeight = intval($newWidth * $ratio);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($srcPath);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($srcPath);
                break;
            case IMAGETYPE_WEBP:
                $srcImage = imagecreatefromwebp($srcPath);
                break;
            default:
                throw new \Exception("Unsupported image type: {$imageType}");
        }

        $dstImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        $destPath = rtrim($destDir, '/') . '/' . $fileName;

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($dstImage, $destPath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($dstImage, $destPath);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($dstImage, $destPath, 90);
                break;
        }

        imagedestroy($srcImage);
        imagedestroy($dstImage);
    }

    public function saveImageDB(int $id, int $order, string $fileName): void
    {
        $sql = "INSERT INTO I001 (I001_P001_Id, I001_Order, I001_File) VALUES (?, ?, ?)";

        try {
            $this->db->insert($sql, [$id, $order, $fileName]);
        } catch (\mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'Duplicate') !== false) {
                throw new \Exception("Image already exists in DB for ID {$id} and order {$order}.");
            }

            throw new \Exception("Failed to insert image in DB for ID {$id}, order {$order}: " . $e->getMessage());
        }
    }
}