<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Domains\User\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(
        protected readonly string $base_path = 'Admin/User'
    ){}
    
    public function index(Request $request) : Response
    {
        return Inertia::render("{$this->base_path}/Index", ['info' => [
            'header' => ['Code', 'Name', 'Username', 'E-mail', ''],
            'users' => (new UserService())->getAllPaginate(50),
        ]]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
