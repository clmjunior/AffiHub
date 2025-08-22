<?php

namespace app\controllers\api\products;

use app\controllers\api\BaseApiController;
use app\controllers\api\helpers\Image;
use app\controllers\api\ValidationException;

class ProductApiHelpers extends BaseApiController
{
    protected function processImages(array $images): array
    {
        $errors = [];
        $warnings = [];

        $id = $images['id'] ?? null;
        $imageList = $images['images'] ?? [];

        if (empty($id)) {
            throw new ValidationException(["id is missing."]);
        }

        if (empty($imageList) || !is_array($imageList)) {
            throw new ValidationException(["images list is missing or invalid."]);
        }

        $sql = "SELECT I001_Order FROM I001 WHERE I001_P001_Id = ?";
        $existingOrders = $this->db->select($sql, [$id]);
        $existingOrderValues = array_column($existingOrders, 'I001_Order');

        foreach ($imageList as $index => $image) {
            $order = $image['order'] ?? null;
            $url = $image['url'] ?? null;

            if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
                $warnings[] = "Invalid or missing image URL at index {$index}.";
                continue;
            }

            if (!isset($order) || !is_numeric($order)) {
                $warnings[] = "Missing or invalid 'order' at index {$index}.";
                continue;
            }

            if (in_array($order, $existingOrderValues)) {
                $warnings[] = "Image already exists at order {$order} (index {$index}). Use PUT to update.";
                continue;
            }

            $headers = @get_headers($url, 1);
            if ($headers === false || !isset($headers[0]) || strpos($headers[0], '200') === false) {
                $warnings[] = "Unreachable image URL at index {$index}: {$url}";
                continue;
            }

            $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];
            if (stripos($contentType, 'image/') !== 0) {
                $warnings[] = "URL is not a valid image at index {$index}: {$url}";
                continue;
            }

            try {
                $oImage = new Image();
                $fileName = $oImage->saveImage($url, $id, $order);
                $oImage->saveImageDB($id, $order, $fileName);
            } catch (\Exception $e) {
                $warnings[] = "Failed to process image at index {$index} (order {$order}): " . $e->getMessage();
            }
        }

        return $warnings;
    }



    protected function mountProductImages($productId): array
    {
        $sql = "SELECT I001_File FROM I001 WHERE I001_P001_Id = ? ORDER BY I001_Order ASC";
        $images = $this->db->select($sql, [$productId]);

        // Associações de tamanho com suas respectivas constantes
        $sizeHosts = [
            '0200' => IMG_HOST_0200,
            '0800' => IMG_HOST_0800,
            '1300' => IMG_HOST_1300,
            // 'original' => IMG_HOST_ORIGINAL,
        ];

        $result = [];

        foreach ($sizeHosts as $size => $host) {
            $result[$size] = array_map(function ($img) use ($host) {
                return rtrim($host, '/') . '/' . $img['I001_File'];
            }, $images);
        }

        return $result;
    }


    protected function mountProductChannels($productId): array
    {
        $sql = "SELECT 
                    M001_Name,
                    P002_M001_Id,
                    P002_Title,
                    P002_Title,
                    P002_Price,
                    P002_Stock,
                    P002_Status 
                FROM P002
                LEFT JOIN M001 ON P002_M001_Id=M001_Id 
                WHERE P002_P001_Id = ? 
                ORDER BY P002_M001_Id ASC";
        $channels = $this->db->select($sql, [$productId]);

        $result = [];

        foreach ($channels as $channel) {
            $result[] = [
                'channel_name'  => $channel['M001_Name'] ?? '',
                'channel_id'  => $channel['P002_M001_Id'] ?? '',
                'title'  => $channel['P002_Title'] ?? '',
                'price'  => floatval($channel['P002_Price'] ?? 0),
                'stock'  => intval($channel['P002_Stock'] ?? 0),
                'status' => $channel['P002_Status'] ?? '',
            ];
        }

        return $result;
    }

}