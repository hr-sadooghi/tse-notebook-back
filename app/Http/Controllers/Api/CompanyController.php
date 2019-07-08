<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * @OA\Get(path="/companies", summary="list of all companies", tags={"company"},
     *     @OA\Response(
     *          response="200",
     *          description="Get list of all Tehran stock companies.",
     *          @OA\JsonContent(
     *          ),
     *          @OA\Schema(type="array", items="object")
     *     )
     * )
     */
    public function getAll()
    {
        return Company::all();
    }

    /**
     * @OA\Get(path="/companies/favorites",
     *     summary="title and description of specified URL", tags={"company"},
     *     @OA\Response(
     *          response="200",
     *          description="Get list of all Tehran stock companies with favorite status.",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function getAllCompaniesAndFavoriteState()
    {
        $user_id = auth()->id();
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

    /**
     * @OA\Get(
     *     path="/companies/{companyId}",
     *     summary="get specified company",
     *     tags={"company"},
     *     @OA\Parameter(
     *          name="companyId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Get specified company.",
     *          @OA\JsonContent()
     *     )
     * )
     * @param Company $company
     * @return JsonResponse
     */
    public function getItem(Company $company)
    {
        return $company;
    }

    /**
     * @OA\Get(
     *     path="/companies/{companyId}/events",
     *     summary="list of events for specified company",
     *     tags={"company"},
     *     @OA\Parameter(
     *          name="companyId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Get list of events for specified company.",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function getEventList(Company $company)
    {
        $user_id = auth()->id();
        $events = Event::
        where('company_id', $company->id)
            ->where('user_id', $user_id)
            ->with('detail')->get();
        return $events;
    }
}
