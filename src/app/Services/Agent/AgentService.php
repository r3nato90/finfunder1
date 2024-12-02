<?php

namespace App\Services\Agent;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Str;

class AgentService
{
    /**
     * @return AbstractPaginator
     */
    public function getPaginate(): AbstractPaginator
    {
        return Agent::latest()->paginate(getPaginate());
    }

    public function prepParams(Request $request): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
        ];
    }

    public function save(array $data): Agent
    {
        return Agent::create($data);
    }






}
