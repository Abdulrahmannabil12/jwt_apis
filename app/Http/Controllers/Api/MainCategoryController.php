<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainCategories;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
class MainCategoryController extends Controller
{
    use GeneralTrait;

    public function index(){
        $cat = MainCategories::all();

        return    $this->returnData('data',$cat);

    }
}
