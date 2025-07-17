<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function store($request);
    public function update($request,$id);
    public function delete($id);
}
