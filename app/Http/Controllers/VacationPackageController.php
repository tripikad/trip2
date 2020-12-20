<?php

namespace App\Http\Controllers;

use App\VacationPackage;
use App\VacationPackageCategory;
use Illuminate\Http\Request;

class VacationPackageController extends Controller
{
    public function index(Request $request)
    {
        $requestedCategory = (int)$request->get('category');
        $query = VacationPackage::where('active', true)
            ->with('vacationPackageCategories', 'company.user');

        $allPackages = $packages = $query->get();
        if ($requestedCategory) {
            $query->whereHas('vacationPackageCategories', function ($query) use ($requestedCategory) {
                $query->where('vacation_package_categories.id', $requestedCategory);
            });

            $packages = $query->get();
        }

        $allCategories = VacationPackageCategory::get();
        $categories[0] = [
            'title' => 'Kõik',
            'route' => $requestedCategory ? route('vacation_package.index') : '#',
            'active' => !$requestedCategory,
            'count' => count($allPackages)
        ];

        foreach ($allCategories as $category) {
            $categories[$category->id] = [
                'title' => $category->name,
                'route' => $requestedCategory !== $category->id ? route('vacation_package.index', ['category' => $category->id]) : '#',
                'active' => $requestedCategory === $category->id,
                'count' => 0
            ];
        }

        foreach ($allPackages as $package) {
            $packageCategories = $package->vacationPackageCategories;
            if ($packageCategories) {
                foreach ($packageCategories as $packageCategory) {
                    $categories[$packageCategory->id]['count'] += 1;
                }
            }
        }

        return view('pages.vacation_package.index', [
            'packages' => $packages,
            'categories' => $categories,
        ]);
    }
}
