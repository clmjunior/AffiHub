<?php

namespace app\controllers\api\products;

use app\controllers\api\ValidationException;

class ProductApiController extends ProductApiHelpers implements ProductApiInterface
{
    public function getProducts()
    {
        $this->handleApiResponse(function () {
            $sql = "SELECT 
                        P001_Id,
                        P001_EAN,
                        P001_Name,
                        P001_Title,
                        P001_Description,
                        P001_Cost_Price,
                        P001_Price,
                        P001_Brand,
                        P001_Weight,
                        P001_Height,
                        P001_Width,
                        P001_Length,
                        P001_Is_Active,
                        created_at,
                        updated_at
                    FROM P001
                    WHERE P001_Is_Active = 1";

            $rawProducts = $this->db->select($sql);

            if (empty($rawProducts)) {
                throw new ValidationException(['no products found.'], 'No products found.', 404);
            }

            $products = [];
            $warnings = [];

            foreach ($rawProducts as $row) {
                $images = $this->mountProductImages($row['P001_Id']);
                if (empty($images['0800'])) {
                    $warnings[] = "Product ID {$row['P001_Id']} has no 800px images.";
                }

                $channels = $this->mountProductChannels($row['P001_Id']);

                $products[] = [
                    'id' => (int) $row['P001_Id'],
                    'ean' => $row['P001_EAN'],
                    'name' => $row['P001_Name'],
                    'title' => $row['P001_Title'],
                    'description' => $row['P001_Description'],
                    'cost_price' => $row['P001_Cost_Price'],
                    'price' => $row['P001_Price'],
                    'brand' => $row['P001_Brand'],
                    'weight' => (float) $row['P001_Weight'],
                    'dimensions' => [
                        'height' => (float) $row['P001_Height'],
                        'width'  => (float) $row['P001_Width'],
                        'depth'  => (float) $row['P001_Length']
                    ],
                    'active' => (bool) $row['P001_Is_Active'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                    'images' => $images,
                    'channels' => $channels,

                ];
            }

            return [
                'data' => $products,
                'message' => 'products found successfully.',
                'code' => 200,
                'warnings' => $warnings
            ];
        });
    }

    public function createProduct($params)
    {
        $this->handleApiResponse(function () use ($params) {
            $warnings = [];

            // Validação básica
            if (empty($params->id) || empty($params->name) || empty($params->channels)) {
                throw new ValidationException(["Some mandatory fields are empty (id, name, channels)."]);
            }

            // Verificar duplicidade
            if ($this->db->hasRows("SELECT 1 FROM P001 WHERE P001_Id = ?", [$params->id])) {
                throw new \Exception("Product {$params->id} already exists.");
            }

            // Inserir produto
            $sql = "INSERT INTO P001 (
                        P001_Id, 
                        P001_EAN, 
                        P001_Name, 
                        P001_Title, 
                        P001_Description,
                        P001_Cost_Price, 
                        P001_Price, 
                        P001_Brand, 
                        P001_Weight,
                        P001_Height, 
                        P001_Width, 
                        P001_Length, 
                        P001_Is_Active,
                        created_at, 
                        updated_at
                    ) VALUES (
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        NOW(), 
                        NOW()
                    )";

            $this->db->insert($sql, [
                $params->id,
                $params->ean ?? null,
                $params->name,
                $params->title ?? null,
                $params->description ?? null,
                $params->cost_price ?? 0,
                $params->price ?? 0,
                $params->brand ?? null,
                $params->weight ?? 0,
                $params->dimensions->height ?? 0,
                $params->dimensions->width ?? 0,
                $params->dimensions->depth ?? 0,
                $params->active ? 1 : 0
            ]);

            if (!empty($params->images)) {
                try {
                    $warnings = array_merge($warnings, $this->processImages([
                        'id' => $params->id,
                        'images' => $params->images
                    ]));
                } catch (\Exception $e) {
                    $warnings[] = "Error saving the image: " . $e->getMessage();
                }
            } else {
                $warnings[] = "No images provided.";
            }

            // Inserir canais
            foreach ($params->channels as $channel) {
              
                $this->db->insert(
                    " INSERT INTO P002 (
                                P002_P001_Id, 
                                P002_M001_Id, 
                                P002_Title, 
                                P002_Price, 
                                P002_Stock, 
                                P002_Status)
                           VALUES (
                                ?, 
                                ?, 
                                ?, 
                                ?, 
                                ?, 
                                ?
                            )",
                    [
                        $params->id,
                        $channel['channel_id'],
                        $channel['title'],
                        $channel['price'],
                        $channel['stock'],
                        $channel['status'] ?? 'active'
                    ]
                );
            }

            return [
                'data' => ['id' => $params->id],
                'message' => 'Produto criado com sucesso.',
                'code' => 200,
                'warnings' => $warnings
            ];
        });
    }





    public function createImages($params)
    {
        $this->handleApiResponse(function () use ($params) {
            $images = !is_array($params) ? (array) $params : $params;
            $warnings = $this->processImages($images);

            return [
                'data' => $params,
                'message' => 'images created successfully',
                'code' => 201,
                'warnings' => $warnings

            ];
        });
    }



}