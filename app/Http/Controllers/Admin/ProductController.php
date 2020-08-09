<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Product;
use App\Store;
use App\Traits\UploadTrait;

class ProductController extends Controller
{

    use UploadTrait;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $userStore = auth()->user()->store;

        $products = $userStore->products()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        $data =  $request->all();

        $categories = $request->get('categories', null);

        $store = auth()->user()->store;

        $product = $store->products()->create($data);

        $product->categories()->sync($categories);

        if ($request->hasFile('photos')) {
            $images = $this->imageUpload($request->file('photos'), 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto cadastrado com sucesso.')->success();
        return redirect()->route('admin.products.index');
    }

    public function show($product)
    {
        $products = $this->product->find($product);
        return view('admin.products.edit', compact('products'));
    }


    public function edit($product)
    {
        $categories = Category::all(['id', 'name']);

        $product = $this->product->findOrFail($product);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, $product)
    {
        $data =  $request->all();

        $categories = $request->get('categories', null);

        $product = $this->product->find($product);

        $product->update($data);

        if (!is_null($categories)) {

            $product->categories()->sync($categories);
        }

        if ($request->hasFile('photos')) {
            $images = $this->imageUpload($request->file('photos'), 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto atualizado com sucesso.')->success();
        return redirect()->route('admin.products.index');
    }

    public function destroy($product)
    {

        $product = $this->product->find($product);

        $product->delete();

        flash('Produto deletado com sucesso.')->success();
        return redirect()->route('admin.products.index');
    }
}
