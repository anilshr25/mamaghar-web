<?php

namespace App\Services\Address;

use App\Http\Resources\Address\AddressResource;
use App\Models\Address\Address;
use App\Services\User\UserService;
use Exception;

class AddressService
{
    protected $address, $userService;

    public function __construct(Address $address, UserService $userService)
    {
        $this->address = $address;
        $this->userService = $userService;
    }

    public function all()
    {
        $address = $this->address->orderBy('id', "DESC")->get();
        return AddressResource::collection($address);
    }

    public function paginate($limit)
    {
        $address = $this->address->orderBy('id', "DESC")->paginate($limit);
        return AddressResource::collection($address);
    }

    public function find($id)
    {
        $address = $this->address->whereId($id)->first();
        return new AddressResource($address);
    }

    public function store($data)
    {
        // try{
            if(!empty($data['user_id'])) {
                $user = $this->userService->find($data['user_id']);
                $data['user_id'] = $user->id;
            }
            return $this->address->create($data);
        // }
        // catch(Exception $e)
        // {
        //     return false;
        // }
    }
    public function update($data, $id)
    {
        try{
            $address = $this->find($id);
            return $address->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $address = $this->find($id);
            $address->delete($id);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}

