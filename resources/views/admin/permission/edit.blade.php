@extends('layouts/dashboard')
@section('content')
<form action="{{ URL::route('admin.permission.update', $permission->id) }}" method="POST">
    <div class="form-group">
        <label for="name">Name: </label>
        @if($errors->has("name"))
            <div class="alert alert-danger">
                {{ $errors->first("name") }}
            </div>
        @endif
        <input type="text" name="name" value="{{ $permission->name }}" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="display_name">Display Name: </label>
        @if($errors->has("display_name"))
            <div class="alert alert-danger">
                {{ $errors->first("display_name") }}
            </div>
        @endif
        <input type="text" name="display_name" value="{{ $permission->display_name }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="name">Description: </label>
        @if($errors->has("description"))
            <div class="alert alert-danger">
                {{ $errors->first("description") }}
            </div>
        @endif
        <input type="text" name="description" value="{{ $permission->description }}" class="form-control">
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PUT">
    <button type="submit" class="btn btn-success">Update permission</button>
</form>
@stop
