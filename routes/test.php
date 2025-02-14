<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::any('test', function (Request $request) {
    Excel::import(new \App\Imports\UsersImport(), 'users.xlsx');
    return success();
});
