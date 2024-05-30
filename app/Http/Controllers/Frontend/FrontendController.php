<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index(){
        $sliders = Slider::where('status', '0')->get();
        $newArrivalsProducts = Product::latest()->take(14)->get();
        $trendingProducts = Product::where('trending', '1')->latest()->take(15)->get();
        $featuredProducts = Product::where('featured', '1')->take(14)->get();
        return view('frontend.index', compact('sliders', 'trendingProducts', 'newArrivalsProducts', 'featuredProducts'));
    }

    public function categories(){
        $categories = Category::where('status', '0')->get();
        return view('frontend.collections.category.index', compact('categories'));
    }

    public function products($category_slug){
        $category = Category::where('slug', $category_slug)->first();
        if($category){
            return view('frontend.collections.products.index', compact('category'));

        }else{
            return redirect()->back();
        }
    }


    public function productView($category_slug, $product_slug){
        $category = Category::where('slug', $category_slug)->first();
        if($category){
            
            $product = $category->products()
                                ->where('slug', $product_slug)
                                ->where('status', '0')
                                ->first();
            if($product){
                
                return view('frontend.collections.products.view', compact('category', 'product'));
            }else{
                return redirect()->back();
            }

        }else{
            return redirect()->back();
        }
    }


    public function productViewNonRead($category_slug, $product_slug){
        DB::statement('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        $category = Category::where('slug', $category_slug)->first();
        if($category){
            $product = $category->products()
                                ->where('slug', $product_slug)
                                ->where('status', '0')
                                ->first();
            echo $product->name;
            sleep(8);
            $product = $category->products()
                                ->where('slug', $product_slug)
                                ->where('status', '0')
                                ->first();
            if($product){
                DB::commit();
                return view('frontend.collections.products.view', compact('category', 'product'));
            }else{
                return redirect()->back();
            }

        }else{
            return redirect()->back();
        }
    }

    public function thankyou(){
        return view('frontend.thank-you');
    }

    public function newArrival(){
        $newArrivalsProducts = Product::latest()->take(16)->get();
        return view('frontend.pages.new-arrival', compact('newArrivalsProducts'));
    }

    public function featuredProducts(){
        $featuredProducts = Product::where('featured', '1')->get();
        return view('frontend.pages.featured-products', compact('featuredProducts'));
    }

    public function searchProducts(Request $request){
        if($request->search){
            $searchProducts = Product::where('name', 'LIKE', '%'.$request->search.'%')
                                        ->latest()
                                        ->paginate(10);
            return view('frontend.pages.search', compact('searchProducts'));
        }else{
            return redirect()->back()->with('message', 'Không tìm thấy sản phẩm');
        }
    }
}
