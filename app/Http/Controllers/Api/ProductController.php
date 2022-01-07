<?php

namespace App\Http\Controllers\Api;

#use App\Events\ProductUpdateEvent;
use App\Constant\ApiStatus;
use App\Http\Controllers\Controller;
use App\Repositories\ProductApiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Constant\RoleConstant;
use App\Repositories\UserApiRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SentEmailToEditorNotification;


class ProductController extends Controller
{
    private $_productRepo;
    private $_userRepo;

    public function __construct(
        ProductApiRepositoryInterface $productRepository,
        UserApiRepositoryInterface $userRepository
    ) {
        $this->_productRepo = $productRepository;
        $this->_userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->_productRepo->getAll();

        return ! $products
            ? apiError(ApiStatus::SERVER_ERROR)
            : apiSuccess($products, 'all products');
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
            return apiError(ApiStatus::VALIDATE_ERROR, $validator->getMessageBag());
        }
        DB::beginTransaction();
        try {
            $newProduct = $this->_productRepo->create($request->all());
            #ProductUpdateEvent::dispatch($newProduct);
            $userEditor = $this->_userRepo->getUsersByRole(RoleConstant::IS_EDITOR);
            Notification::send($userEditor, new SentEmailToEditorNotification($newProduct));
            DB::commit();

            return apiSuccess($newProduct,'Product create successfully',201);
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollback();

            return apiError(ApiStatus::SERVER_ERROR, 'Can not create product');
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
            ? apiError(ApiStatus::NOT_FOUND, 'Url not found')
            : apiSuccess($product, 'oke');
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
            return apiError(ApiStatus::VALIDATE_ERROR, $validator->getMessageBag());
        }

        try {
            $this->_productRepo->update($request->all(), $id);

            return apiSuccess([], sprintf('Product id: %s was update successfully!', $id));
        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'Can not update product');
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
                return apiError(ApiStatus::NOT_FOUND, 'not found product');
            }

            $productExist->delete();

            return apiSuccess([], sprintf('Product id: %s was delete successfully!', $id));

        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'Can not delete product');
        }
    }
}
