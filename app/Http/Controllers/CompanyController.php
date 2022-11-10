<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    private CompanyInterface $companyRepository;
    public function __construct(
        CompanyInterface $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }
}
