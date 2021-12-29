<?php


namespace App\Repositories;


interface ProductApiRepositoryInterface
{
    public function getAll();
    public function getDetailProduct($id_product);
    public function create($data);
    public function update($data, $id_product);
    public function destroy($id_product);
}
