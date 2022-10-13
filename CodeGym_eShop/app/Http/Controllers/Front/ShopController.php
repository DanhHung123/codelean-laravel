<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Brand\BrandServiceInterface;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceInterface;
use App\Services\ProductCategory\ProductCategoryServiceInterface;
use App\Services\ProductComment\ProductCommentServiceInterface;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $productSevice;
    private $productCommentService;
    private $productCategorySevice;
    private $brandService;

    public function __construct(ProductServiceInterface $productService
        , ProductCommentServiceInterface $productCommentService
        , ProductCategoryServiceInterface $productCategoryService
        , BrandServiceInterface $brandService)
    {
        $this->productSevice = $productService;
        $this->productCommentService = $productCommentService;
        $this->productCategorySevice = $productCategoryService;
        $this->brandService = $brandService;
    }

    public function show($id) {
        $product = $this->productSevice->find($id);
        $relatedProducts = $this->productSevice->getRelatedProducts($product,4);

        return view('front.shop.show',compact('product','relatedProducts'));
    }

    public function postcomment(Request $request) {
        $this->productCommentService->create($request->all());

        return redirect()->back();
    }

    public function index(Request $request) {
        $categories = $this->productCategorySevice->all();
        $brands = $this->brandService->all();
        $products = $this->productSevice->getProductOnIndex($request);

        return view('front.shop.shop',compact('products','categories','brands'));
    }

    public function category($categoryName, Request $request) {
        $categories = $this->productCategorySevice->all();
        $brands = $this->brandService->all();
        $products = $this->productSevice->getProductsByCategory($categoryName, $request);

        return view('front.shop.shop',compact('products','categories','brands'));
    }
}
