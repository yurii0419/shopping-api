<?php

namespace App\Livewire\Pages\Shop\Component;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Style;
use Illuminate\Support\Facades\Auth;

class ManageProducts extends Component
{
    use WithFileUploads;
    public $product_name;
    public $name;
    public $product_description;
    public $product_price;
    public $category_id;
    public $subcategory_id;
    public $image;
    public $images;
    public $categories;
    public $subcategories;
    public $user;
    public $slug;
    public $product_user_id;
    public $product_code;
    public $brands;
    public $product_brand;
    public $quantity;
    public $conditions;
    public $styles;
    public $colors;

    public function mount(User $user)
    {
        $this->categories = Category::all();
        $this->subcategories = SubCategory::all();
        $this->brands = Brand::all();
        $this->colors = Color::all();
        $this->styles = Style::all();
        $this->conditions = Condition::all();
        $this->user = $user;
    }

    public function addProduct()
    {

        if ($this->images) {
            $path = $this->images->store('/assets/img/product-images');
            $imagePath = $path;
        } else {
            session()->flash('error', 'No image uploaded.');
            return;
        }

        Product::create([
            'user_id' => $this->user->id,
            'product_name' => $this->product_name,
            'product_description' => $this->product_description,
            'price' => $this->product_price,
            'category_id' => $this->category_id,
            'condition_id' => $this->condition_id,
            'color_id' => $this->color_id,
            'style_id' => $this->style_id,
            'subcategory_id' => $this->subcategory_id,
            'product_code' => $this->product_code,
            'slug' => $this->slug,
            'product_brand' => $this->product_brand,
            'quantity' => $this->quantity,
            'keyword' => '["dress","tops","sportswear"]',
            'status' => 1,
            'image' =>  $imagePath,
        ]);

        // Handle image uploads if they are included


        session()->flash('message', 'Product listed successfully!');
        $this->reset(); // Reset specific fields
    }

    public function render()
    {
        return view('livewire.pages.shop.component.manage-products');
    }
}
