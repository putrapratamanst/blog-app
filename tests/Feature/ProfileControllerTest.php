<?php

use App\Http\Controllers\ProfileController;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View as ViewInstance;
use Mockery\MockInterface;

beforeEach(function () {
    $this->controller = new ProfileController();
});

it('can display the user profile form', function () {
    $user = Mockery::mock('App\Models\User');
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('user')->andReturn($user);

    $response = $this->controller->edit($request);

    expect($response)->toBeInstanceOf(ViewInstance::class);
    expect($response->getData())->toHaveKey('user', $user);
});

it('can update the user profile information', function () {
    $user = Mockery::mock('App\Models\User');
    $user->shouldReceive('fill')->andReturnSelf();
    $user->shouldReceive('isDirty')->with('email')->andReturn(true);
    $user->shouldReceive('save')->andReturnTrue();

    $request = Mockery::mock(ProfileUpdateRequest::class);
    $request->shouldReceive('user')->andReturn($user);
    $request->shouldReceive('validated')->andReturn(['email' => 'test@example.com']);

    Redirect::shouldReceive('route')->with('profile.edit')->andReturnSelf();
    Redirect::shouldReceive('with')->with('status', 'profile-updated')->andReturnSelf();

    $response = $this->controller->update($request);

    expect($response)->toBeInstanceOf(\Illuminate\Http\RedirectResponse::class);
});

it('can delete the user account', function () {
    $user = Mockery::mock('App\Models\User');
    $user->shouldReceive('delete')->andReturnTrue();

    $request = Mockery::mock(Request::class);
    $request->shouldReceive('validateWithBag')->with('userDeletion', ['password' => ['required', 'current-password']]);
    $request->shouldReceive('user')->andReturn($user);
    $request->shouldReceive('session')->andReturnSelf();
    $request->shouldReceive('invalidate')->andReturnSelf();
    $request->shouldReceive('regenerateToken')->andReturnSelf();

    Auth::shouldReceive('logout')->andReturnTrue();
    Redirect::shouldReceive('to')->with('/')->andReturnSelf();

    $response = $this->controller->destroy($request);

    expect($response)->toBeInstanceOf(\Illuminate\Http\RedirectResponse::class);
});

afterEach(function () {
    Mockery::close();
});
