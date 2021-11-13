<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserListRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function index(UserListRequest $request)
    {
        $user = User::filter($request->validated())->paginate(5);
        return new UserCollection($user);
    }

    public function create()
    {
        return [];
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return UserResource::make($user);
    }

    public function show(User $user)
    {
        return UserResource::make($user->load([]));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return [
            'user' => UserResource::make($user->load([]))
        ];
    }

    public function update(User $user, UserRequest $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->update($request->validated());
        return UserResource::make($user);
    }

    public function delete(User $user, $id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return ['deleted' => true];
    }
}
