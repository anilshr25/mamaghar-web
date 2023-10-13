<?php

namespace App\Http\Controllers\Admin\User\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressRequest;
use App\Services\User\Address\AddressService;

class AddressController extends Controller
{
    protected $address;

    public function __construct(AddressService $address)
    {
        $this->address = $address;
    }

    public function index($userId)
    {
        return $this->address->paginate($userId);
    }

    public function store($userId, AddressRequest $request)
    {
        $address = $this->address->createOrUpdate($userId, $request->all());
        if($address)
            return response(['status' => "OK"], 200);
        return response(['status' =>"ERROR"], 500);
    }

    public function show($userId, $id)
    {
        if($address = $this->address->getByUserId($userId, $id))
            return response(['status' => "OK", 'address' => $address ], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update($userId, $id, AddressRequest $request)
    {
        $address = $this->address->createOrUpdate($userId, $id, $request->all());
        if($address)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($userId, $id)
    {
        if($this->address->delete($userId, $id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
