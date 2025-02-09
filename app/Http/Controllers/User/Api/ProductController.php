<?php
namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\User\ProductRepo;
use App\Http\Requests\User\Api\SearchRequest;
class ProductController extends BaseResponse
{

    protected $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function view(Request $request)
    {
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if ($result['success'])
        {
            $results = [];
            $filter = [];
            $results['products'] = $result['object']['products'];
            $results['pagination'] = $result['object']['pagination'];
            array_push($filter, ['type' => __('home.brand'), 'list' => $result['object']['brands']]);
            array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
            array_push($filter, ['type' => __('home.brandOrigin'), 'list' => $result['object']['countries']]);
            array_push($filter, ['type' => __('home.company'), 'list' => $result['object']['companies']]);
            $results['filter'] = $filter;

            return $this->response(200, $result['success'], 200, [], 0, $results);
        }
        elseif ($result['errors'])
            return $this->response(500, $result['errors'], 500);
        else
            return $this->response(500, "Error", 500);
    }
    /**
     * Search in products
     *
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request)
    {
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if ($result['success'])
        {
            $results = [];
            $filter = [];
            $results['products'] = $result['object']['products'];
            $results['pagination'] = $result['object']['pagination'];
            array_push($filter, ['type' => __('home.brand'), 'list' => $result['object']['brands']]);
            array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
            array_push($filter, ['type' => __('home.brandOrigin'), 'list' => $result['object']['countries']]);
            array_push($filter, ['type' => __('home.company'), 'list' => $result['object']['companies']]);
            $results['filter'] = $filter;
            $results['search_key'] = $result['object']['key'];
            return $this->response(200, $result['success'], 200, [], 0, $results);
        }
        elseif ($result['errors'])
            return $this->response(500, $result['errors'], 500);
        else
            return $this->response(500, "Error", 500);
    }

    public function companyProducts(Request $request, $id)
    {
        $request->merge(['in_company' => $id]);
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if ($result['success'])
        {
            $results = [];
            $filter = [];
            if (count($result['object']['products']))
            {
                $results['products'] = $result['object']['products'];
                $results['pagination'] = $result['object']['pagination'];
                array_push($filter, ['type' => __('home.brand'), 'list' => $result['object']['brands']]);
                array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
                array_push($filter, ['type' => __('home.brandOrigin'), 'list' => $result['object']['countries']]);
                $results['filter'] = $filter;
                $results['company'] = $result['object']['company'];
                return $this->response(200, $result['success'], 200, [], 0, $results);
            }
            return $this->response(101, "Validation Error", 200, ['This company has no products']);
        }
        elseif ($result['errors'])
            return $this->response(500, $result['errors'], 500);
        else
            return $this->response(500, "Error", 500);
    }

    public function brandProducts(Request $request, $id)
    {
        $request->merge(['in_brand' => $id]);
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if ($result['success'])
        {
            $results = [];
            $filter = [];
            if (count($result['object']['products']))
            {
                $results['products'] = $result['object']['products'];
                $results['pagination'] = $result['object']['pagination'];
                array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
                array_push($filter, ['type' => __('home.brandOrigin'), 'list' => $result['object']['countries']]);
                array_push($filter, ['type' => __('home.company'), 'list' => $result['object']['companies']]);
                $results['filter'] = $filter;
                $results['brand'] = $result['object']['brand'];
                return $this->response(200, $result['success'], 200, [], 0, $results);
            }
            return $this->response(101, "Validation Error", 200, ['This brand has no products']);
        }
        elseif ($result['errors'])
            return $this->response(500, $result['errors'], 500);
        else
            return $this->response(500, "Error", 500);
    }

    public function categoryProducts(Request $request, $id, $level)
    {
        $request->merge(['in_category' => $id]);
        $request->merge(['category_level' => $level]);
        if($request->input('brand')){
            $brands = [];
            array_push($brands,$request->input('brand'));
            $request->merge(['brands' => $brands]);
        }
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if ($result['success'])
        {
            $results = [];
            $filter = [];
            if (count($result['object']['products']) && $result['object']['category']['level'] == $level)
            {
                $results['products']   = $result['object']['products'];
                $results['pagination'] = $result['object']['pagination'];
                $results['brands']     = $result['object']['brands'];
                array_push($filter, ['type' => __('home.brand'), 'list' => $result['object']['brands']]);
                // array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
                array_push($filter, ['type' => __('home.brandOrigin'), 'list' => $result['object']['countries']]);
                array_push($filter, ['type' =>__('home.company'), 'list' => $result['object']['companies']]);

                if($level=='level3')
                    array_push($filter, ['type' => __('home.specifications'), 'list' => $result['object']['specifications']]);

                $results['filter']   = $filter;
                $results['category'] = $result['object']['category'];
                return $this->response(200, $result['success'], 200, [], 0, $results);
            }
            return $this->response(101, "Validation Error", 200, ['This category has no products']);
        }
        elseif ($result['errors'])
            return $this->response(500, $result['errors'], 500);
        else
            return $this->response(500, "Error", 500);
    }

    public function show($id)
    {
        $result = $this->productRepo->product($id);
        if ($result['success'])
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        elseif ($result['validator'])
            return $this->response(101, "Validation Error", 200, $result['validator']);
        elseif ($result['errors'])
            return $this->response(500, $result['errors'], 500);
        else
            return $this->response(500, "Error", 500);
    }
}

