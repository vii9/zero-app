<?php


namespace App\Repositories;

use App\Models\Product;


class ProductApiRepository implements ProductApiRepositoryInterface
{

    /**
     * @var Product
     */
    private $_productModel;

    public function __construct(Product $product)
    {

        $this->_productModel = $product;
    }

    public function getAll()
    {
        return $this->_productModel->all();
    }

    public function getDetailProduct($id_product)
    {
        return $this->_productModel->find($id_product);
    }

    public function create($data)
    {
        return $this->_productModel->create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price'],
        ]);
    }

    public function update($data, $id_product)
    {
        return $this->_productModel->whereId($id_product)->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price'],
        ]);
    }

    public function destroy($id_product)
    {
        return $this->_productModel->find($id_product);
    }
}
