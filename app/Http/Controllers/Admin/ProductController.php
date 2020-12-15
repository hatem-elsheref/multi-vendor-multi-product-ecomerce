<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Image;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
class ProductController extends Controller
{

    public function getAllProductsToAdmin(Request $request){
        $products=Product::with(['stock','category','images'])->where(function ($query) use($request){
            $query->when($request->search,function ($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                    ->orWhere('model','like','%'.$request->search.'%')
                    ->orWhere('description','like','%'.$request->search.'%');
            });
        })->orderByDesc('id')->paginate(PAGINATION);

        return view('admin.seller.products.all',compact('products'));
    }

    public function index(Request $request)
    {
        $products=Product::with(['stock','category','images'])->where('user_id',auth()->id())->where(function ($query) use($request){
             $query->when($request->search,function ($q) use ($request){
              $q->where('name','like','%'.$request->search.'%')
                ->orWhere('model','like','%'.$request->search.'%')
                ->orWhere('description','like','%'.$request->search.'%');
            });
        })->orderByDesc('id')->paginate(PAGINATION);
        return view('admin.seller.products.index',compact('products'));
    }

    public function create()
    {
        $data=[];
        $data['categories']=Category::all();
        $data['colors']=colorsAvailable();
        $data['classes']=array_keys(sizesAvailable());
        return view('admin.seller.products.create',$data);
    }

    public function store(Request $request)
    {
       $request->validate([
           'name'        =>'required|string|max:191',
           'model'       =>'string|max:191',
           'price'       =>'required|numeric|min:0',
           'qty'         =>'required|numeric|min:1',
           'category_id' =>['required','numeric',Rule::exists('categories','id')],
           'colors'      =>['array','nullable'],
           'class'       =>['nullable'],
           'description' =>'required|string',
           'images'      =>'required|array',
           'images.*'    =>'image|mimes:png,jpg,jpeg,gif,webp'
       ]);

       $validatedData=$request->except(['_token','description','images','colors','class','_wysihtml5_mode']);

       //prepare user or product owned to stock => current auth
        $validatedData['user_id']=auth()->id();
      // prepare colors
        if (is_null($request->colors))
            $validatedData['colors']=null;
        else{
            if (count($request->colors) > 0){
                $availableColors=colorsAvailable();
                $colors=array_map(function ($color) use ($availableColors){
                    if (in_array($color,array_keys($availableColors)))
                        return $color;
                    else
                        return null;
                },$request->colors);
                $validatedData['colors']=serialize(array_filter($colors,fn($color)=>$color!=null));
            }else
                $validatedData['colors']=null;

        }

       //prepare sizes
        $class= ($request->class === 'un_known')? null:$request->class;
        if (is_null($class) or is_null($request->sizes) or empty($request->sizes)){
            $validatedData['sizes']=null;
        }else{

            $availableClasses=sizesAvailable();
            if (in_array($class,array_keys($availableClasses))){
                $availableSizes=$availableClasses[$class];
                $sizes=array_map(function ($size) use ($availableSizes){
                    if (in_array($size,$availableSizes))
                        return $size;
                    else
                        return null;
                },$request->sizes);
                $sizes=array_filter($sizes,fn($size)=>$size!=null);
                $data['sizes']=$sizes;
                $data['class']=$class;
                $validatedData['sizes']=serialize($data);
            }else{
                $validatedData['sizes']=null;
            }
        }

        //prepare description
//        $validatedData['description']=Purify::clean($request->description);
        $validatedData['description']=$request->description;


        $product=Product::create($validatedData);
        $product->slug();


        // prepare images
        if ($request->hasFile('images')){
            $sources=[];
            $count=0;
            foreach ($request->file('images') as $file){
                $fileName=$this->generateNewName($product,$count,$file);
                $parentPath='uploads/products';
                $src=$parentPath.'/'.$fileName;
                $file->move($parentPath,$src);
                $sources[]=['src'=>$src,'product_id'=>$product->id];
                $count++;
            }

            Image::insert($sources);
        }else{
            Image::create(['product_id'=>$product->id,'src'=>'uploads/products/'.DEFAULT_PRODUCT]);
        }

        success();
        return redirect()->route('product.index');


    }

    public function show($slug)
    {
        if (auth()->user()->role === ADMIN){
            $product=Product::with(['stock','category','images'])->where('slug',$slug)->firstOrFail();
        }elseif (auth()->user()->role === SELLER){
            $product=Product::with(['stock','category','images'])->where('user_id',auth()->id())->where('slug',$slug)->firstOrFail();
        }
        return view('admin.seller.products.show',compact('product'));
    }

    public function edit($slug)
    {
        return view('admin.seller.products.edit',$this->findProductWithDetails($slug));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name'        =>'required|string|max:191',
            'model'       =>'string|max:191',
            'price'       =>'required|numeric|min:0',
            'qty'         =>'required|numeric|min:1',
            'category_id' =>['required','numeric',Rule::exists('categories','id')],
            'colors'      =>['array','nullable'],
            'class'       =>['nullable'],
            'description' =>'required|string',
            'images'      =>'array|nullable',
            'images.*'    =>'nullable|image|mimes:png,jpg,jpeg,gif,webp'
        ]);
        $product=Product::with('images')->where('slug',$slug)->firstOrFail();
        $validatedData=$request->except(['_token','_method','description','images','colors','class','_wysihtml5_mode']);

        //prepare user or product owned to stock => current auth
        $validatedData['user_id']=auth()->id();
        // prepare colors
        if (is_null($request->colors))
            $validatedData['colors']=null;
        else{
            if (count($request->colors) > 0){
                $availableColors=colorsAvailable();
                $colors=array_map(function ($color) use ($availableColors){
                    if (in_array($color,array_keys($availableColors)))
                        return $color;
                    else
                        return null;
                },$request->colors);
                $validatedData['colors']=serialize(array_filter($colors,fn($color)=>$color!=null));
            }else
                $validatedData['colors']=null;

        }

        //prepare sizes
        $class= ($request->class === 'un_known')? null:$request->class;
        if (is_null($class) or is_null($request->sizes) or empty($request->sizes)){
            $validatedData['sizes']=null;
        }else{

            $availableClasses=sizesAvailable();
            if (in_array($class,array_keys($availableClasses))){
                $availableSizes=$availableClasses[$class];
                $sizes=array_map(function ($size) use ($availableSizes){
                    if (in_array($size,$availableSizes))
                        return $size;
                    else
                        return null;
                },$request->sizes);
                $sizes=array_filter($sizes,fn($size)=>$size!=null);
                $data['sizes']=$sizes;
                $data['class']=$class;
                $validatedData['sizes']=serialize($data);
            }else{
                $validatedData['sizes']=null;
            }
        }

        //prepare description
//        $validatedData['description']=Purify::clean($request->description);
        $validatedData['description']=$request->description;



      if ($product->update($validatedData)){
          $product->slug();
      }else{
          fail();
          return redirect()->route('product.index');
      }


        // prepare images
        if ($request->hasFile('images')){
            foreach ($product->images as $image){
                Storage::disk('my_desk')->delete($image->src);
                $image->delete();
            }
            Image::insert($this->uploadImages($request->file('images'),$product));
        }

        success();
        return redirect()->route('product.index');

    }

    public function destroy($slug)
    {
        $product=Product::with('images')->where('slug',$slug)->firstOrFail();
        $items=OrderItem::where('product_id',$product->id)->count();
        if ($items > 0){
            fail();
            return redirect()->route('product.index');
        }
        foreach ($product->images as $image){
            Storage::disk('my_desk')->delete($image->src);
            $image->delete();
        }
        // if product has no orders delete this orders but check if the orders not paid

        $product->delete();
        success();
        return redirect()->route('product.index');
    }

    public function classify(Request $request){
        if($request->ajax()){
            $class=$request->class;
            echo json_encode(sizesAvailable()[$class]);
        }
    }

    private function generateNewName($product,$iterator,$file){
       return $product->slug . $iterator . time() . '.' . $file->getClientOriginalExtension();
    }

    private function findProductWithDetails($slug){
        $product=Product::with(['stock','category','images'])->where('user_id',auth()->id())->where('slug',$slug)->firstOrFail();

        $data['product']=$product;
        $data['categories']=Category::all();
        $data['colors']=colorsAvailable();
        $data['classes']=array_keys(sizesAvailable());
        return $data;
    }

    private function uploadImages($images,$product){
        $count=0;
        $sources=[];
        foreach ($images as $file){
            $fileName=$this->generateNewName($product,$count,$file);
            $parentPath='uploads/products';
            $src=$parentPath.'/'.$fileName;
            $file->move($parentPath,$src);
            $sources[]=['src'=>$src,'product_id'=>$product->id];
            $count++;
        }
        return $sources;
    }
}
