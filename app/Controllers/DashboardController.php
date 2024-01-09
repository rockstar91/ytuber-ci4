<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    use \Myth\Auth\AuthTrait;

    protected $helpers = ['Auth'];

    public function __construct()
    {
        $this->restrict( route_to('login') );
    }

    public function index()
    {
        $viewData['user'] = user();

        return view('dashboard_codebase', $viewData);
    }
}