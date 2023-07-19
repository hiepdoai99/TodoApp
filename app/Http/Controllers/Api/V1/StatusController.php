<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;


class StatusController extends Controller
{
    public function index(Request $request){
//       $status = QueryBuilder::for(Status::class)
//                ->allowedFilters('name','id')
//                ->paginate($request->per_page ?? 10)
//                ->appends($request->all());
//       return $this->respondSuccess($status)
        $status = Status::all();
        return $this->respondSuccess($status);
    }


    public function store(Request $request)
    {
        $status = new Status();

        $status->name = $request->name;

        $status ->save();

        return $this->respondSuccess($status);
    }



    public function edit(Request $request,$id)
    {
        $status = Status::find($id);
        $status->name = $request->name;
        $status ->save();

        return $this->respondSuccess($status);

    }

    public function destroy($id, Request $request)
    {

        $status = Status::find($id);
        if ($status->delete()) {
            return $this->respondOk(__('status.delete_success', ['resource', 'status '.$status->name]));
        }
        return $this->respondError(__('status.delete_fail',['resource',  'status '.$status->name]));
    }

}
