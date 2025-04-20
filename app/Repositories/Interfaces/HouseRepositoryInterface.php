<?php

namespace App\Repositories\Interfaces;

interface HouseRepositoryInterface
{
    public function getHouseById($id);
    public function getHouse($id);
    public function getUser();
    public function getHousesData($id);
    public function createHouse(array $data);
    public function updateHouse($id, array $data);
    public function deleteHouse($id);
    public function viewHouse($house);
    public function searchByName(string $name);
}
