<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\{ProductRepository,ResponseRepository};


class ApiController extends Controller
{
     /**
     * @var $productRepository object ProductRepository
     */
    private $productRepository;
    private $responseRepository;

    public function __construct(ProductRepository $productRepository,ResponseRepository $responseRepository){
        $this->productRepository = $productRepository;
        $this->responseRepository = $responseRepository;
    }

    /**
     * list of all products
     */
    public function products(){
        $listOfProducts = $this->productRepository->all();
        return $this->responseRepository->success('',$listOfProducts);
    }

    /**
     * get product detail against slug of product
     */
    public function productDetail($slug){
        $productDetail = $this->productRepository->productDetail($slug);
        if($productDetail!=null){
            return $this->responseRepository->success('',$productDetail);
        }
        return $this->responseRepository->error('',$productDetail);
    }
}
