<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProductApiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    private $_productRepo;

    public function __construct(ProductApiRepositoryInterface $productRepository)
    {
        $this->_productRepo = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->_productRepo->getAll();

        if ( ! $products) {
            return response()->json(['message' => 'ERROR'], 500);
        }

        return response()->json(['message' => 'SUCCESS', 'data' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->_validateProductCreate($request->all());

        if ($validator->fails()) {
            return response()->json(['message' => 'ERROR', 'data' => $validator->getMessageBag()], 403);
        }

        try {
            $newProduct = $this->_productRepo->create($request->all());

            return response()->json(['message' => 'SUCCESS', 'data' => $newProduct], 201);

        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json(['message' => 'ERROR', 'data' => 'Can not create product'], 500);
        }
    }

    private function _validateProductCreate($request)
    {
        return Validator::make($request, [
            'name' => 'required|string|max:191',
            'slug' => 'required|string|max:191',
            'price' => 'required|numeric',
        ],[
            'name.required' => 'Tên sản phẩm thì bắt buộc'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->_productRepo->getDetailProduct($id);

        return ! $product
            ? response()->json(['message' => 'ERROR'], 404)
            : response()->json(['message' => 'SUCCESS', 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->_validateProductCreate($request->all());

        if ($validator->fails()) {
            return response()->json(['message' => 'ERROR', 'data' => $validator->getMessageBag()], 403);
        }

        try {
            $this->_productRepo->update($request->all(), $id);

            return response()->json([
                'message' => 'SUCCESS',
                'data' => sprintf('Product id: %s was update successfully!', $id)
            ], 201);

        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json(['message' => 'ERROR', 'data' => "can not update product"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $productExist = $this->_productRepo->destroy($id);

            if ( ! $productExist) {
                return response()->json(['message' => 'ERROR', 'data' => "not found product"], 404);
            }

            $productExist->delete();

            return response()->json([
                'message' => 'SUCCESS',
                'data' => sprintf('Product id: %s was delete successfully!', $id)
            ], 201);

        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json(['message' => 'ERROR', 'data' => "can not delete product"], 500);
        }
    }
}
