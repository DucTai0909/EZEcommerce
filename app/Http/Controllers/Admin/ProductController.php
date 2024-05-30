<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index(){
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(){
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::where('status', '0')->get();
        return view('admin.products.create', compact('categories', 'brands', 'colors'));
    }

    public function store(ProductFormRequest $request){
        $validatedData = $request->validated();

        $category = Category::findOrFail($validatedData['category_id']);
        $product = $category->products()->create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['slug']),
            'brand' => $validatedData['brand'],
            'small_description' => $validatedData['small_description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'trending' => $request->trending == true ? '1' : '0',
            'featured' => $request->featured == true ? '1' : '0',
            'status' => $request->status == true ? '1' : '0',
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
        ]);

        if($request->hasFile('image')){
            $uploadPath = 'uploads/products/';

            $i =1;
            foreach($request->file('image') as $imageFile){
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $imageFile->move($uploadPath, $filename);
                $finalImagePathName = $uploadPath.$filename;

                $product->productImages()->create([
                    'product_id' =>$product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }

        if($request->colors){
            foreach($request->colors as $key => $color){
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->colorquantity[$key]  ?? 0
                ]);
            }
        }
        return redirect('/admin/products')->with('message','Product Added Successfully');
    }

    public function edit(int $product_id){
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::findOrFail($product_id);
        
        $product_colors = $product->productColors()->pluck('color_id')->toArray();
        $colors = Color::whereNotIn('id', $product_colors)->get();
        return view('admin.products.edit', compact('categories', 'brands', 'product', 'colors'));
    }

    public function editSolveLostUpdate($product_id){
        $categories = Category::all();
        $brands = Brand::all();
        
        try {
            DB::beginTransaction();
            
            // Thiết lập mức cô lập SERIALIZABLE
            DB::statement('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
            
            // Lấy và khóa bản ghi sản phẩm để chỉnh sửa
            $product = Product::where('id', $product_id)->lockForUpdate()->first();
            
            if (!$product) {
                DB::commit();
                return redirect('admin/products')->with('message', 'No Product ID Found');
            }
    
            // Kiểm tra xem sản phẩm có đang bị khóa hay không
            if ($product->is_locked) {
                DB::commit();
                return redirect('admin/products')->with('message', 'Product is currently being edited by another admin. Please try again later.');
            }
    
            // Khóa sản phẩm
            $product->update(['is_locked' => true]);
            
            $product_colors = $product->productColors()->pluck('color_id')->toArray();
            $colors = Color::whereNotIn('id', $product_colors)->get();
            
            DB::commit();
            
            return view('admin.products.edit', compact('categories', 'brands', 'product', 'colors'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect('admin/products')->with('message', 'Product is currently being edited by another admin. Please try again later.');
        }
    }
    
    

    public function update(ProductFormRequest $request, int $product_id){
        $validatedData =$request->validated();

        $product = Product::where('id', $product_id)->first();
        
        if($product){
            $product->update([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['slug']),
                'brand' => $validatedData['brand'],
                'small_description' => $validatedData['small_description'],
                'description' => $validatedData['description'],
                'original_price' => $validatedData['original_price'],
                'selling_price' => $validatedData['selling_price'],
                'quantity' => $validatedData['quantity'],
                'trending' => $request->trending == true ? '1' : '0',
                'featured' => $request->featured == true ? '1' : '0',
                'status' => $request->status == true ? '1' : '0',
                'meta_title' => $validatedData['meta_title'],
                'meta_keyword' => $validatedData['meta_keyword'],
                'meta_description' => $validatedData['meta_description'],
            ]);

            if($request->hasFile('image')){
                $uploadPath = 'uploads/products/';
    
                $i =1;
                foreach($request->file('image') as $imageFile){
                    $extension = $imageFile->getClientOriginalExtension();
                    $filename = time().$i++.'.'.$extension;
                    $imageFile->move($uploadPath, $filename);
                    $finalImagePathName = $uploadPath.$filename;
    
                    $product->productImages()->create([
                        'product_id' =>$product->id,
                        'image' => $finalImagePathName,
                    ]);
                }
            }

            if($request->colors){
                foreach($request->colors as $key => $color){
                    $product->productColors()->create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'quantity' => $request->colorquantity[$key]  ?? 0
                    ]);
                }
            }
            return redirect('admin/products')->with('message', 'Product Updated Succesfully');
        }else{
            return redirect('admin/products')->with('message', 'No Product ID Found');
        }
    }

    public function updateSolveLostUpdate(ProductFormRequest $request, int $product_id){
        $validatedData = $request->validated();
        
        DB::beginTransaction();
        
        try {
            // Thiết lập mức cô lập SERIALIZABLE
            DB::statement('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
            
            // Lấy và khóa bản ghi sản phẩm
            $product = Product::where('id', $product_id)->lockForUpdate()->first();
            
            if (!$product) {
                DB::commit();
                return redirect('admin/products')->with('message', 'No Product ID Found');
            }
    
            $product->update([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['slug']),
                'brand' => $validatedData['brand'],
                'small_description' => $validatedData['small_description'],
                'description' => $validatedData['description'],
                'original_price' => $validatedData['original_price'],
                'selling_price' => $validatedData['selling_price'],
                'quantity' => $validatedData['quantity'],
                'trending' => $request->trending == true ? '1' : '0',
                'featured' => $request->featured == true ? '1' : '0',
                'status' => $request->status == true ? '1' : '0',
                'meta_title' => $validatedData['meta_title'],
                'meta_keyword' => $validatedData['meta_keyword'],
                'meta_description' => $validatedData['meta_description'],
                'is_locked' => false // Giải phóng khóa sau khi cập nhật
            ]);
    
            if ($request->hasFile('image')) {
                $uploadPath = 'uploads/products/';
        
                $i = 1;
                foreach ($request->file('image') as $imageFile) {
                    $extension = $imageFile->getClientOriginalExtension();
                    $filename = time() . $i++ . '.' . $extension;
                    $imageFile->move($uploadPath, $filename);
                    $finalImagePathName = $uploadPath . $filename;
        
                    $product->productImages()->create([
                        'product_id' => $product->id,
                        'image' => $finalImagePathName,
                    ]);
                }
            }
    
            if ($request->colors) {
                foreach ($request->colors as $key => $color) {
                    $product->productColors()->create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'quantity' => $request->colorquantity[$key] ?? 0
                    ]);
                }
            }
            
            DB::commit();
            return redirect('admin/products')->with('message', 'Product Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/products')->with('message', 'An error occurred while updating the product. Please try again.');
        }
    }

    // public function updateNonRead(ProductFormRequest $request, int $product_id){
    //     $validatedData =$request->validated();

       

    //     $product = Product::where('id', $product_id)->first();
        
    //     if($product){
    //         $product->update([
    //             'category_id' => $validatedData['category_id'],
    //             'name' => $validatedData['name'],
    //             'slug' => Str::slug($validatedData['slug']),
    //             'brand' => $validatedData['brand'],
    //             'small_description' => $validatedData['small_description'],
    //             'description' => $validatedData['description'],
    //             'original_price' => $validatedData['original_price'],
    //             'selling_price' => $validatedData['selling_price'],
    //             'quantity' => $validatedData['quantity'],
    //             'trending' => $request->trending == true ? '1' : '0',
    //             'featured' => $request->featured == true ? '1' : '0',
    //             'status' => $request->status == true ? '1' : '0',
    //             'meta_title' => $validatedData['meta_title'],
    //             'meta_keyword' => $validatedData['meta_keyword'],
    //             'meta_description' => $validatedData['meta_description'],
    //         ]);

    //         if($request->hasFile('image')){
    //             $uploadPath = 'uploads/products/';
    
    //             $i =1;
    //             foreach($request->file('image') as $imageFile){
    //                 $extension = $imageFile->getClientOriginalExtension();
    //                 $filename = time().$i++.'.'.$extension;
    //                 $imageFile->move($uploadPath, $filename);
    //                 $finalImagePathName = $uploadPath.$filename;
    
    //                 $product->productImages()->create([
    //                     'product_id' =>$product->id,
    //                     'image' => $finalImagePathName,
    //                 ]);
    //             }
    //         }

    //         if($request->colors){
    //             foreach($request->colors as $key => $color){
    //                 $product->productColors()->create([
    //                     'product_id' => $product->id,
    //                     'color_id' => $color,
    //                     'quantity' => $request->colorquantity[$key]  ?? 0
    //                 ]);
    //             }
    //         }
    //         return redirect('admin/products')->with('message', 'Product Updated Succesfully');
    //     }else{
    //         return redirect('admin/products')->with('message', 'No Product ID Found');
    //     }
    // }
    // public function updateDirtyRead(ProductFormRequest $request, int $product_id){
    //     $validatedData = $request->validated();
    
    //     DB::beginTransaction();
        
    //     try {
    //         // Thiết lập mức cô lập READ COMMITTED
    //         // DB::statement('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
            
    //         // Lấy bản ghi sản phẩm
    //         $product = Product::where('id', $product_id)->first();
            
    //         if (!$product) {
    //             DB::commit();
    //             return redirect('admin/products')->with('message', 'No Product ID Found');
    //         }

    //         // Cập nhật sản phẩm
    //         $product->update([
    //             'category_id' => $validatedData['category_id'],
    //             'name' => $validatedData['name'],
    //             'slug' => Str::slug($validatedData['slug']),
    //             'brand' => $validatedData['brand'],
    //             'small_description' => $validatedData['small_description'],
    //             'description' => $validatedData['description'],
    //             'original_price' => $validatedData['original_price'],
    //             'selling_price' => $validatedData['selling_price'],
    //             'quantity' => $validatedData['quantity'],
    //             'trending' => $request->trending == true ? '1' : '0',
    //             'featured' => $request->featured == true ? '1' : '0',
    //             'status' => $request->status == true ? '1' : '0',
    //             'meta_title' => $validatedData['meta_title'],
    //             'meta_keyword' => $validatedData['meta_keyword'],
    //             'meta_description' => $validatedData['meta_description']
    //         ]);
            
    //         // Giữ giao tác đang mở để mô phỏng việc đọc sau khi commit
    //         sleep(10); // Sleep để giữ giao tác mở trong 10 giây
            
    //         // Commit giao tác
    //         DB::rollBack();
    //         return redirect('admin/products')->with('message', 'An error occurred while updating the product. Please try again');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect('admin/products')->with('message', 'An error occurred while updating the product. Please try again.');
    //     }
    // }
    
    

    public function updateProdColorQty(Request $request, $prod_color_id){
        $productColorData = Product::findOrFail($request->product_id)
                                    ->productColors()->where('id', $prod_color_id)->first();
        
        $productColorData->update([
            'quantity' => $request->qty,
        ]);
        

        return response()->json(['message'=>'Product Color Quantity Update']);
    }

    public function deleteProdColor($prod_color_id) {
        $productColor = ProductColor::findOrFail($prod_color_id);
        $productColor->delete();
        return response()->json(['message'=>'Product Color Deleted']);

    }


    public function releaseLock($product_id){
        $product = Product::where('id', $product_id)->first();
        if ($product) {
            $product->update(['is_locked' => false]);
        }
        return response()->json(['message' => 'Lock released successfully.']);
    }

}




