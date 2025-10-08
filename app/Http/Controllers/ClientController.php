<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\System;
use App\Repositories\SystemRepository;
use Illuminate\Support\Facades\App;

class ClientController extends Controller
{
    protected $language;
    protected $system;

    public function __construct() {}
}
