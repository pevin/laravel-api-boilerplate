<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/1.0/users/me",
     *      operationId="getUserMe",
     *      tags={"Users"},
     *      summary="Get the authenticated User",
     *      description="Returns the details of the authenticated user",
     *      @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_OK,
     *          description="successful operation"
     *       ),
     *       @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED,
     *          description="Unauthorized."
     *        ),
     *       security={
     *           {"bearerAuth": {}}
     *       }
     *     )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * @OA\Get(
     *      path="/api/1.0/user/{id}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="Get specific user",
     *      description="Returns the details of a specific user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of user to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_OK,
     *          description="successful operation"
     *       ),
     *       @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
     *          description="Not found."
     *        ),
     *       @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED,
     *          description="Unauthorized."
     *        ),
     *       security={
     *           {"bearerAuth": {}}
     *       }
     *     )
     * )
     *
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'data' => ['id' => $id],
        ]);
    }
}
