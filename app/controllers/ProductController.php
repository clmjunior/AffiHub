<?php

namespace app\controllers;

class ProductController extends Controller
{
    public function indexProduct()
    {
        $products = $this->getProducts();

        $data = [
            'title' => 'Produtos', 
            'name' => 'product', 
            'products' => $products
        ];

        $this->view('product', $data);
    }

    public function getProducts()
    {
        try {
            $sql = "SELECT 
                        P001_Id,
                        P001_EAN,
                        P001_Name,
                        P001_Title,
                        P001_Description,
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
            $products = [];

            foreach ($rawProducts as $row) {
                $products[] = [
                    'id' => (int) $row['P001_Id'],
                    'ean' => $row['P001_EAN'],
                    'name' => $row['P001_Name'],
                    'title' => $row['P001_Title'],
                    'description' => $row['P001_Description'],
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
                    'images' => $this->getProductImages($row['P001_Id']) // você pode implementar essa função
                ];
            }

            return [
                'status' => 'success',
                'data' => $products
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => 'Erro ao buscar produtos: ' . $th->getMessage()
            ];
        }
    }

    private function getProductImages($productId)
    {
        $sql = "SELECT I001_File FROM I001 WHERE I001_P001_Id = ? ORDER BY I001_Order ASC LIMIT 1";
        $images = $this->db->select($sql, [$productId]);

        return array_map(function ($img) {
            return IMG_HOST_0200 . $img['I001_File'];
        }, $images);
    }

}
