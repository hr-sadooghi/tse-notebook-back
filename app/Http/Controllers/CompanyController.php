<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Event;
use App\Link;
use App\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function apiGetAllCompanies()
    {
        return Company::all();
    }

    public function apiGetAllCompaniesAndFavoriteState()
    {
        $user_id = 1;//auth()->id();
        return DB::table('companies')
            ->leftJoin('favorites', function ($join) use ($user_id) {
                $join->on('user_id', '=', DB::raw($user_id))
                    ->on('company_id', '=', 'companies.id');
            })
            ->select(
                'companies.id',
                'companies.symbol',
                'companies.name',
                DB::raw('IF(favorites.company_id IS NULL, false, true) AS favorite')
            )
            ->get();
    }

    public function apiGetCurrentUserFavoriteCompanies()
    {
        $user_id = 1;//auth()->id();
        /** @var User $user */
        $favorites = User::find($user_id)->favorites()->get(['id', 'symbol', 'name']);
        if (!$favorites) {
            abort(404);
        }
        $list = [];
        foreach ($favorites as $favorite) {
            $list[] = [
                'id' => $favorite->id,
                'symbol' => $favorite->symbol,
                'name' => $favorite->name,
                'favorite' => 1,
            ];
        }
        return $list;
    }

    public function apiPostAddCompanyToCurrentUserFavorite($company_id)
    {
        $user_id = 1;//auth()->id();
        /** @var User $user */
        $user = User::find($user_id);
        $user->favorites()->attach($company_id);
        return response('', 201);
    }

    public function apiDeleteRemoveCompanyFromCurrentUserFavorite($company_id)
    {
        $user_id = 1;//auth()->id();
        /** @var User $user */
        $user = User::find($user_id);
        $user->favorites()->detach($company_id);
        return response('', 200);
    }

    public function apiGetCompaniesItem(Company $company)
    {
        $companyInfo = [
            'id' => $company->id,
            'name' => $company->name,
            'symbol' => $company->symbol,
            'category' => [
                'id' => $company->category_id,//$company->category()->id,
                'name' => 'نام دسته بندی'/*$company->category()->name,*/
            ],
            'last_price' => 1210,
            'avg_price' => 1311,
            'amount' => 3000
        ];
        return $companyInfo;
    }

    public function apiGetEventList(Company $company)
    {
        $user_id = 1;//auth()->id();
        $events = Event::
            where('company_id', $company->id)
            ->where('user_id', $user_id)
            ->with('detail')->get();
        return $events;
    }
}
