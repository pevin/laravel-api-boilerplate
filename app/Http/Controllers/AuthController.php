<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/1.0/users/auth",
     *      operationId="postUserAuth",
     *      tags={"Users"},
     *      summary="Authenticate user",
     *      description="Returns access token of a user",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "test@email.com", "password": "password"}
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_OK,
     *          description="successful operation"
     *       ),
     *       @OA\Response(
     *          response=\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED,
     *          description="Unauthorized."
     *        ),
     *       security={}
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @OA\Post(
     *      path="/api/users/auth/refresh",
     *      operationId="postUserAuthRefresh",
     *      tags={"Users"},
     *      summary="Refresh authentication",
     *      description="Returns new access token of a user",
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
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'accessToken' => $token,
                'tokenType' => 'bearer',
                'expiresIn' => $this->guard()->factory()->getTTL() * 60,
            ]
        );
    }
}
