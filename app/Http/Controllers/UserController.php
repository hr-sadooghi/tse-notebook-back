<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users/favorites/companies",
     *     summary="list favorite companies",
     *     @OA\Response(
     *          response="200",
     *          description="Get list of favorite companies.",
     *          @OA\JsonContent()
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/users/favorites/{companyId}",
     *     summary="add company to favorite",
     *     @OA\Parameter(
     *          name="companyId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="add company from favorite.",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function apiPostAddCompanyToCurrentUserFavorite($company_id)
    {
        $user_id = 1;//auth()->id();
        /** @var User $user */
        $user = User::find($user_id);
        $user->favorites()->attach($company_id);
        return response('', 201);
    }

    /**
     * @OA\Delete(
     *     path="/users/favorites/{companyId}",
     *     summary="remove company from favorite",
     *     @OA\Parameter(
     *          name="companyId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="remove company from favorite.",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function apiDeleteRemoveCompanyFromCurrentUserFavorite($company_id)
    {
        $user_id = 1;//auth()->id();
        /** @var User $user */
        $user = User::find($user_id);
        $user->favorites()->detach($company_id);
        return response('', 200);
    }
}
