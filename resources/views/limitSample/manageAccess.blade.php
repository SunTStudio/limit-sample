@extends('layouts.app')

@section('css')
    <style>
        .tables-container p {
            font-size: 0.7rem;
            margin: 0;
        }

        .tables-container {
            display: flex;
            justify-content: space-around;
        }

        table {
            width: 30%;
        }
    </style>
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Manage Access</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">Manage Access User</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection
@section('content')
<div class="container bg-white p-3">
    <h4>Setting Manage Access</h4>
    <div class="row ">
        <div class="col">
            <div class="ibox ">
                <div class="ibox-content">
                    <form action="{{ route('manage.access.store') }}" method="POST">
                        @csrf
                        <p>Berikut Management Approval :</p>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Section Head 1 :</label>
                            <div class="col-lg-5">
                                <select class="form-control" id="id" name="idSec1" required="required">
                                    <option value="" > Pilih Section Head </option>
                                    @foreach ($SecHeads as $SecHead)
                                        <option value="{{ $SecHead->id }}" @if ($SecHead->npk == $oldSecHead1->user->npk)
                                            selected
                                        @endif>{{ $SecHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label">Section Head 2 :</label>
                            <div class="col-lg-5">
                                <select class="form-control" id="id" name="idSec2" required="required">
                                    <option value="" > Pilih Section Head </option>
                                    @foreach ($SecHeads as $SecHead)
                                        <option value="{{ $SecHead->id }}" @if ($SecHead->npk == $oldSecHead2->user->npk))
                                            selected
                                        @endif>{{ $SecHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label">Department Head :</label>
                            <div class="col-lg-5">
                                <select class="form-control" id="id" name="idDeptHead" required="required">
                                    <option value=""> Pilih Department Head </option>
                                    @foreach ($DeptHeads as $DeptHead)
                                        <option value="{{ $DeptHead->id }}" @if ($DeptHead->npk == $oldDeptHead->user->npk)
                                            selected
                                        @endif>{{ $DeptHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" type="submit">Ubah Access</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection
