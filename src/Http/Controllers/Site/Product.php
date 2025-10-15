<?php

namespace Jiny\Site\Http\Controllers\Site;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Frontend Product Single Action Controller
 *
 * URL Priority Rules:
 * 1. /product/{category}/{product} - Category-based product URLs
 * 2. /product/{product} - Direct product URLs
 *
 * Supports both slug and ID for categories and products
 */
class Product extends Controller
{
    public function __invoke(Request $request, ...$segments)
    {
        // Determine URL structure based on segment count
        if (count($segments) === 2) {
            // Format: /product/{category}/{product}
            return $this->handleCategoryProduct($segments[0], $segments[1]);
        } elseif (count($segments) === 1) {
            // Format: /product/{product}
            return $this->handleDirectProduct($segments[0]);
        }

        // Invalid URL structure
        abort(404);
    }

    /**
     * Handle category-based product URLs: /product/{category}/{product}
     */
    protected function handleCategoryProduct($categoryIdentifier, $productIdentifier)
    {
        // Find category by slug or ID
        $category = $this->findCategory($categoryIdentifier);
        if (!$category) {
            abort(404, 'Category not found');
        }

        // Find product within the category
        $product = $this->findProductInCategory($productIdentifier, $category->id);
        if (!$product) {
            abort(404, 'Product not found in this category');
        }

        // Increment view count
        $this->incrementViewCount($product->id);

        return $this->renderProduct($product, $category);
    }

    /**
     * Handle direct product URLs: /product/{product}
     */
    protected function handleDirectProduct($productIdentifier)
    {
        // Find product by slug or ID
        $product = $this->findProduct($productIdentifier);
        if (!$product) {
            abort(404, 'Product not found');
        }

        // Get category if exists
        $category = null;
        if ($product->category_id) {
            $category = DB::table('site_product_categories')
                ->where('id', $product->category_id)
                ->whereNull('deleted_at')
                ->first();
        }

        // Increment view count
        $this->incrementViewCount($product->id);

        return $this->renderProduct($product, $category);
    }

    /**
     * Find category by slug or ID
     */
    protected function findCategory($identifier)
    {
        $query = DB::table('site_product_categories')
            ->whereNull('deleted_at')
            ->where('enable', true);

        // Try slug first, then ID
        if (is_numeric($identifier)) {
            $query->where(function ($q) use ($identifier) {
                $q->where('slug', $identifier)
                  ->orWhere('id', $identifier);
            });
        } else {
            $query->where('slug', $identifier);
        }

        return $query->first();
    }

    /**
     * Find product by slug or ID within a specific category
     */
    protected function findProductInCategory($identifier, $categoryId)
    {
        $query = DB::table('site_products')
            ->leftJoin('site_product_categories', 'site_products.category_id', '=', 'site_product_categories.id')
            ->select(
                'site_products.*',
                'site_product_categories.title as category_name',
                'site_product_categories.slug as category_slug'
            )
            ->where('site_products.category_id', $categoryId)
            ->where('site_products.enable', true)
            ->whereNull('site_products.deleted_at');

        // Try slug first, then ID
        if (is_numeric($identifier)) {
            $query->where(function ($q) use ($identifier) {
                $q->where('site_products.slug', $identifier)
                  ->orWhere('site_products.id', $identifier);
            });
        } else {
            $query->where('site_products.slug', $identifier);
        }

        return $query->first();
    }

    /**
     * Find product by slug or ID (any category)
     */
    protected function findProduct($identifier)
    {
        $query = DB::table('site_products')
            ->leftJoin('site_product_categories', 'site_products.category_id', '=', 'site_product_categories.id')
            ->select(
                'site_products.*',
                'site_product_categories.title as category_name',
                'site_product_categories.slug as category_slug'
            )
            ->where('site_products.enable', true)
            ->whereNull('site_products.deleted_at');

        // Try slug first, then ID
        if (is_numeric($identifier)) {
            $query->where(function ($q) use ($identifier) {
                $q->where('site_products.slug', $identifier)
                  ->orWhere('site_products.id', $identifier);
            });
        } else {
            $query->where('site_products.slug', $identifier);
        }

        return $query->first();
    }

    /**
     * Increment product view count
     */
    protected function incrementViewCount($productId)
    {
        DB::table('site_products')
            ->where('id', $productId)
            ->increment('view_count');
    }

    /**
     * Render product view with additional data
     */
    protected function renderProduct($product, $category = null)
    {
        // Get pricing options
        $pricingOptions = DB::table('site_product_pricing')
            ->where('product_id', $product->id)
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('price')
            ->get();

        // Get image gallery
        $images = DB::table('site_product_images')
            ->where('product_id', $product->id)
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('featured', 'desc')
            ->orderBy('pos')
            ->get();

        // Use first gallery image as main image if product has no main image
        if (empty($product->image) && $images->count() > 0) {
            $product->image = $images->first()->image_url;
        }

        // Get testimonials for this product
        $testimonials = DB::table('site_testimonials')
            ->where('type', 'product')
            ->where('item_id', $product->id)
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('featured', 'desc')
            ->orderBy('rating', 'desc')
            ->orderBy('likes_count', 'desc')
            ->limit(6)
            ->get();

        // Get related products from same category
        $relatedProducts = collect();
        if ($product->category_id) {
            $relatedProducts = DB::table('site_products')
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->orderBy('featured', 'desc')
                ->orderBy('view_count', 'desc')
                ->limit(4)
                ->get();
        }

        return view('jiny-site::www.product.show', [
            'product' => $product,
            'category' => $category,
            'pricingOptions' => $pricingOptions,
            'images' => $images,
            'testimonials' => $testimonials,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}