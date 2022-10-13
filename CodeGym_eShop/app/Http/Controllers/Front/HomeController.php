<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    private $productService;
    private $blogService;

    public function __construct(ProductServiceInterface $productService, BlogRepositoryInterface $blogService)
    {
        $this->productService = $productService;
        $this->blogService = $blogService;
    }

    public function index() {
        $featuredProduct = $this->productService->getFeaturedProducts();
        $blogs = $this->blogService->getLatestBlogs();

        return view('front.index',compact('featuredProduct','blogs'));
    }


}
