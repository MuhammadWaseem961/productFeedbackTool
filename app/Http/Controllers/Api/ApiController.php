<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedbackCategory;
use App\Repositories\{ProductRepository,ResponseRepository,FeedbackCategoryRepository};


class ApiController extends Controller
{
     /**
     * @var $productRepository object ProductRepository
     * @var $respoonseRepository object RespoonseRepository
     * @var  $feedbackCategroyRepository object FeedbackCategroyRepository
     */
    private $productRepository;
    private $responseRepository;
    private $feedbackCategroyRepository;

    public function __construct(FeedbackCategoryRepository $feedbackCategroyRepository,ProductRepository $productRepository,ResponseRepository $responseRepository){
        $this->productRepository = $productRepository;
        $this->feedbackCategroyRepository = $feedbackCategroyRepository;
        $this->responseRepository = $responseRepository;
    }

    /**
     * list of all products
     */
    public function products(){
        $listOfProducts = $this->productRepository->recordWithSpecificColumns(['id','title','slug','image','summary']);
        return $this->responseRepository->success('',$listOfProducts);
    }

    /**
     * get product detail against slug of product
     */
    public function productDetail($slug){
        $productDetail = $this->productRepository->productDetail(['id','title','slug','image','summary'],$slug);
        $feedbackCategories = $this->feedbackCategroyRepository->recordsWithSpecificColumn(['id as value','title as label']);
        if($productDetail!=null){
            return $this->responseRepository->success('',["product"=>$productDetail,'feedbackCategories'=>$feedbackCategories]);
        }
        return $this->responseRepository->error('',$productDetail);
    }
}
