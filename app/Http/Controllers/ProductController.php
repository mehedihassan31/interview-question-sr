<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;
use Yajra\Datatables\Datatables;


class ProductController extends Controller
{
    protected $dataTable;

    public function __construct(Datatables $dataTable)
    {
        $this->dataTable = $dataTable;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $variantsname = Variant::with('productVariant')->get();

        return view('products.index',compact('variantsname'));
    }


    public function data(Request $request)
    {
        $query = Product::orderBY('id', 'ASC')->with('productVariantPrice.productVariant')->select();
        return $this->dataTable->eloquent($query)
        ->escapeColumns([])
            ->editColumn('variant', function ($item) {
                $html="";
                $html.='<td>
                <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">';
                foreach($item->productVariantPrice as $prod_price)
                {
                    $html.='<dt class="col-sm-3 pb-0">';



                            $html.= ($prod_price->productVariant->variant_id==2 ? $prod_price->productVariant->variant : ''). '/ ' .($prod_price->productVariant->variant_id==1 ? $prod_price->productVariant->variant : '').' / '.($prod_price->productVariant->variant_id==3 ? $prod_price->productVariant->variant : '');
                        
                            $html.='</dt>
                    <dd class="col-sm-9">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 pb-0">Price : '.$prod_price->price.'</dt>
                            <dd class="col-sm-8 pb-0">InStock : '.$prod_price->stock.'</dd>
                        </dl>
                    </dd>';

                }

            
                $html.='</dl>
                <button onclick="';
                $html.='$("#variant").toggleClass("h-auto")';
                $html.='" class="btn btn-sm btn-link">Show more</button>
                </td>';


                return $html;
            })
            ->editColumn('action', function ($item) {

                $html="";
                $html.='<td>
                <div class="btn-group btn-group-sm">
                    <a href="'. route('product.edit', 1).'" class="btn btn-success">Edit</a>
                </div>
            </td>';
                return $html;
            })
            ->filter(function ($query) use ($request) {
                if ($request->filled('title')) {
                    $query->where('title', 'like', "%" . $request->get('title') . "%");
                }
                if ($request->filled('variant')) {

                    $query->with(['productVariantPrice.productVariant' => function ($query) use ($request) {
                        $query->where('variant',$request->get('variant'));
                    }]);
                }
                if ($request->filled('price_from') || $request->filled('price_to')) {

                    $query->with(['productVariantPrice' => function ($query) use ($request) {
                        $query->whereBetween('price',[$request->get('price_from'),$request->get('price_from')]);
                    }]);
                }
                if ($request->filled('date')) {
                    $query->where('created_at', 'like', "%" . $request->get('date') . "%");
                }
            })
            ->make(true);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
