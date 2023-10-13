<?php

namespace App\Services\User\Address;

use App\Http\Resources\User\Address\AddressResource;
use App\Models\User\Address\Address;
use Exception;

class AddressService
{
    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function paginate($userId, $limit = 10)
    {
        $address = $this->address->whereUserId($userId)->orderBy('id', "DESC")->paginate($limit);
        return AddressResource::collection($address);
    }

    public function getByUserId($userId, $id)
    {
        $address = $this->address->whereUserId($userId)->whereId($id)->first();
        return new AddressResource($address);
    }

    function createOrUpdate($userId, $data)
    {
        try {
            $address = $this->getByUserId($userId, $data['id']);
            if (empty($address))
                $address = $this->store($userId, $data);
            else
                $address = $this->update($userId, $address->id, $data);

            return $address;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function store($userId, $data)
    {
        try{
            $data['user_id'] = $userId;
            return $this->address->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    public function update($userId, $id, $data)
    {
        try{
            $address = $this->getByUserId($userId, $id);
            return $address->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($userId, $id)
    {
        try{
            $address = $this->getByUserId($userId, $id);
            return $address->delete();
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}

