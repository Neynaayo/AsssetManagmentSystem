<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total count of assets
        $totalAssets = Asset::count();

        // Fetch the count of distinct departments and companies from the department and company tables
        $totalDepartments = Department::count();
        $totalCompanies = Company::count();

        // Fetch distinct floors from the assets table
        $totalFloors = Asset::distinct('location')->count('location');

        // Get asset count grouped by department
        $assetsByDepartment = DB::table('assets')
            ->join('department', 'assets.department_id', '=', 'department.id')
            ->select('department.name as name', DB::raw('count(*) as value'))
            ->groupBy('department.name')
            ->get();

        // Get asset count grouped by location (floor)
        $assetsByFloor = DB::table('assets')
            ->select('location as name', DB::raw('count(*) as value'))
            ->groupBy('location')
            ->get();

        // Get asset count grouped by company
        $assetsByCompany = DB::table('assets')
            ->join('company', 'assets.company_id', '=', 'company.id')
            ->select('company.name as name', DB::raw('count(*) as value'))
            ->groupBy('company.name')
            ->get();

        // Fetch counts for loans, disposals, and available assets
        $loanCount = DB::table('history')->where('status', 'Loan')->count();
        $disposalCount = DB::table('history')->where('status', 'Disposal')->count();
        $availableCount = Asset::whereNotIn('id', function ($query) {
            $query->select('asset_id')->from('history')->whereIn('status', ['Loan', 'Disposal']);
        })->count();


            // Pass the data to the view
            return view('dashboard', [
                'totalAssets' => $totalAssets,
                'totalDepartments' => $totalDepartments,
                'totalFloors' => $totalFloors,
                'totalCompanies' => $totalCompanies,
                'assetsByDepartment' => $assetsByDepartment,
                'assetsByFloor' => $assetsByFloor,
                'assetsByCompany' => $assetsByCompany,
                'loanCount' => $loanCount,
                'disposalCount' => $disposalCount,
                'availableCount' => $availableCount
            ]);
    }
}


