<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component
{
    public $product;
    public $key;
    /**
     * Create a new component instance.
     */
    public function __construct($product, $key=null)
    {
        $this->product = $product;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.product-card');
    }
}
