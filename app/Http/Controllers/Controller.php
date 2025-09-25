<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="PostBanner",
 *     version="1.0.0",
 *     description="API documentation for BannerApp"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="V1 API"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearer",
 *     in="header",
 *     name="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\PathItem(
 *     path="/login",
 *     @OA\Post(
 *         summary="login",
 *         description="Login",
 *         operationId="login",
 *         tags={"Auth"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass user credentials",
 *             @OA\JsonContent(
 *                  required={"is_social", "login_with","social_id","device_token","device_type","uu_id"},
 *                  @OA\Property(property="social_id", type="string", example="google_id/apple_id"),
 *                  @OA\Property(property="login_with", type="string", example="Email/Google/Apple"),
 *                  @OA\Property(property="email", type="string", example="cavin@mailinator.com"),
 *                  @OA\Property(property="device_token", type="string", format="string", example="123"),
 *                  @OA\Property(property="device_type", type="string", format="string", example="Android"),
 *                  @OA\Property(property="device_model", type="string", format="string", example="Samsung SM-M146B - 13"),
 *                  @OA\Property(property="device_os", type="integer", example="os"),
 *                  @OA\Property(property="app_version", type="integer", example="version"),
 *                  @OA\Property(property="api_version", type="integer", example="api version"),
 *                  @OA\Property(property="uu_id", type="string", format="string", example="123"),
 *                  @OA\Property(property="apple_auth_code", type="string", format="string", example="123avcaca123"),
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         )
 *     )
 * )
 * 
 * @OA\PathItem(
 *     path="/logout/{uu_id}",
 *     @OA\Get(
 *          summary="logout",
 *          description="logout",
 *          operationId="logout",
 *          tags={"Auth"},
 *          @OA\Parameter(
 *          name="uu_id",
 *          description="uu_id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *            type="string"
 *          )
 *       ),
 *       @OA\Response(
 *          response=422,
 *          description="Wrong credentials response",
 *          @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *              )
 *           ),
 *           security={ {"bearer": {}} }
 *     )
 * )
 * 
 * @OA\PathItem(
 *  path="/adddevicetoken",
 *  @OA\Post(
 *  summary="add device token",
 *     description="",
 *  operationId="adddevicetoken",
 *  tags={"Auth"},
 *  @OA\RequestBody(
 *     required=true,
 *     description="Pass user details",
 *     @OA\JsonContent(
 *        required={"user_id"},
 *        @OA\Property(property="user_id", type="integer", example=1),
 *        @OA\Property(property="uu_id", type="string", format="string", example="123"),
 *        @OA\Property(property="device_type", type="string", example="Android"),
 *        @OA\Property(property="device_token", type="string", example="token123"),
 *        @OA\Property(property="device_model", type="string", example="SAMSUNG F12"),
 *        @OA\Property(property="device_name", type="string", example="name"),
 *        @OA\Property(property="device_os", type="integer", example="os"),
 *        @OA\Property(property="app_version", type="integer", example="version"),
 *        @OA\Property(property="api_version", type="integer", example="api version"),
 *      ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Device token added successfully!"
 *      ),
 *  @OA\Response(
 *     response=401,
 *     description="Something went wrong, Please try again."
 *      ),
 *  )
 * )
 * 
 * @OA\PathItem(
 *     path="/verifyotp",
 *     @OA\Post(
 *         summary="verify OTP",
 *         description="verify OTP",
 *         operationId="verifyotp",
 *         tags={"Auth"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass user credentials",
 *             @OA\JsonContent(
 *                  required={"email_otp_number","email","mobile"},
 *                  @OA\Property(property="email", type="string", format="emailId", example="stiv@mailinator.com"),
 *                  @OA\Property(property="is_social", type="boolean", example=true),
 *                  @OA\Property(property="otp_number", type="integer", example="5648"),
 *                  @OA\Property(property="device_token", type="string", format="string", example="123"),
 *                  @OA\Property(property="device_type", type="string", format="string", example="Android"),
 *                  @OA\Property(property="device_model", type="string", format="string", example="Samsung SM-M146B - 13"),
 *                  @OA\Property(property="device_os", type="integer", example="os"),
 *                  @OA\Property(property="app_version", type="integer", example="version"),
 *                  @OA\Property(property="api_version", type="integer", example="api version"),
 *                  @OA\Property(property="uu_id", type="string", format="string", example="123"),
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         )
 *     )
 * )
 * 
 * @OA\PathItem(
 *     path="/resendotp",
 *     @OA\Post(
 *         summary="resendotp",
 *         description="resendotp",
 *         operationId="resendotp",
 *         tags={"Auth"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass user credentials",
 *             @OA\JsonContent(
 *                  required={"email"},
 *                  @OA\Property(property="source", type="string", format="email/forgot_email/new_mobile", example="email/forgot_email/new_email"),
 *                  @OA\Property(property="email", type="string", format="emailId", example="stiv@mailinator.com"),
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         )
 *     )
 * )
 * 
 * @OA\PathItem(
 *     path="/userdetails",
 *     @OA\Get(
 *         summary="Sign in",
 *         description="get logged user details",
 *         operationId="userdetails",
 *         tags={"Profile"},
 *         @OA\Response(
 *              response=200,
 *              description="success"
 *               ),
 *           @OA\Response(
 *              response=401,
 *              description="Something went wrong, Please try again."
 *               ),
 *           security={ {"bearer": {}} }
 *     )
 * )
 * 
 * @OA\PathItem(
 *     path="/updateprofile",
 *     @OA\Post(
 *         summary="update profile",
 *         description="update profile",
 *         operationId="updateprofile",
 *         tags={"Profile"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass user credentials",
 *             @OA\JsonContent(
 *                  required={"image"},
 *                  @OA\Property(property="image", type="string", format="string", example="test.png"),
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         ),
 *         security={ {"bearer": {}} }
 *     )
 * )
 * 
 * @OA\PathItem(
 *     path="/getconfig/{config_key}/{device_type}",
 *     @OA\Get(
 *         summary="Get config",
 *         description="Get config",
 *         operationId="getconfig",
 *         tags={"Config"},
 *        @OA\Parameter(
 *        name="config_key",
 *        description="config_key",
 *        required=true,
 *        in="path",
 *        @OA\Schema(
 *            type="string"
 *        )
 *       ),
 *       @OA\Parameter(
 *        name="device_type",
 *        description="device_type (android/ios/general)",
 *        required=true,
 *        in="path",
 *        @OA\Schema(
 *            type="string"
 *        )
 *       ),
 *       @OA\Response(
 *          response=422,
 *          description="Wrong credentials response",
 *          @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *              )
 *           )
 *     )
 * )
 * 
 * @OA\PathItem(
 *      path="/getappversion",
 *      @OA\Post(
 *      summary="get app version",
 *         description="",
 *      operationId="getappversion",
 *      tags={"Config"},
 *      @OA\RequestBody(
 *        required=true,
 *        description="",
 *        @OA\JsonContent(
 *           required={"platform"},
 *           @OA\Property(property="platform", type="string", example="android/ios"),
 *       ),
 *    ),
 *      @OA\Response(
 *         response=200,
 *         description="success"
 *          ),
 *      @OA\Response(
 *         response=401,
 *         description="Something went wrong, Please try again."
 *          ),
 *      )
 * )
 * 
 * @OA\PathItem(
 *      path="/notificationonoff",
 *      @OA\Put(
 *      summary="notification on off",
 *      description="notification on off",
 *      operationId="notificationonoff",
 *      tags={"Setting"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="pass push_notify or text_notify",
 *         @OA\JsonContent(
 *            required={"push_notify"},
 *            @OA\Property(property="type", type="string", format="string", example="push_notify"),
 *            @OA\Property(property="is_notify", type="boolean", example=true),
 *         ),
 *      ),
 *      @OA\Response(
 *         response=200,
 *         description="Notification updated Successfully."
 *          ),
 *      @OA\Response(
 *         response=401,
 *         description="User ID is invalid."
 *          ),
 *      security={ {"bearer": {}} },
 *      )
 * )
 * 
 * @OA\PathItem(
 *      path="/deleteuser",
 *      @OA\Delete(
 *      summary="delete user",
 *      description="delete user",
 *      operationId="deleteuser",
 *      tags={"Setting"},
 *       @OA\Response(
 *           response=200,
 *              description="success"
 *               ),
 *           @OA\Response(
 *              response=401,
 *              description="Something went wrong, Please try again."
 *               ),
 *           security={ {"bearer": {}} }
 *      )
 * )
 * 
 * @OA\PathItem(
 *      path="/notificationlist",
 *      @OA\Post(
 *      summary="notification list",
 *      description="show notification list of logged in user",
 *      operationId="notificationlist",
 *      tags={"Notification"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Pass offset and limit",
 *         @OA\JsonContent(
 *            required={"offset","limit"},
 *            @OA\Property(property="offset", type="number", format="0", example="0"),
 *            @OA\Property(property="limit", type="number", format="1", example="10"),
 *         ),
 *      ),
 *      @OA\Response(
 *         response=401,
 *         description="No Notification to show.",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Invalid setting details.")
 *             )
 *          ),
 *      security={ {"bearer": {}} },
 *      )
 * )
 * 
 * @OA\PathItem(
 *      path="/unreadcount",
 *      @OA\Get(
 *      summary="get unread count",
 *      description="",
 *      operationId="unreadcount",
 *      tags={"Notification"},
 *      @OA\Response(
 *         response=200,
 *         description="success"
 *          ),
 *      @OA\Response(
 *         response=401,
 *         description="Something went wrong, Please try again."
 *          ),
 *      security={ {"bearer": {}} }
 *      )
 * )
 * 
 * @OA\PathItem(
 *     path="/addupdatebusinessprofile",
 *     @OA\Post(
 *         summary="add update business profile",
 *         description="add update business profile",
 *         operationId="addupdatebusinessprofile",
 *         tags={"Business Profile"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass user credentials",
 *             @OA\JsonContent(
 *                  required={"email"},
 *                  @OA\Property(property="business_profile_id", type="integer", example=5),
 *                  @OA\Property(property="type", type="string", example="business/personal"),
 *                  @OA\Property(property="user_name", type="string", example="cavin"),
 *                  @OA\Property(property="business_name", type="string", example="test business"),
 *                  @OA\Property(property="email", type="string", format="email", example="cavin@mailinator.com"),
 *                  @OA\Property(property="mobile", type="string", format="string", example="1234567890"),
 *                  @OA\Property(property="image", type="string", format="string", example="test.png"),
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         ),
 *         security={ {"bearer": {}} }
 *     )
 * )
 * 
 * @OA\PathItem(
 *      path="/getbusinesslist",
 *      @OA\Post(
 *      summary="get business list",
 *      description="get business list",
 *      operationId="getbusinesslist",
 *      tags={"Business Profile"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Pass offset and limit",
 *         @OA\JsonContent(
 *            required={"offset","limit"},
 *            @OA\Property(property="offset", type="number", format="0", example="0"),
 *            @OA\Property(property="limit", type="number", format="1", example="10"),
 *         ),
 *      ),
 *      @OA\Response(
 *         response=401,
 *         description="No Notification to show.",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Invalid setting details.")
 *             )
 *          ),
 *         security={ {"bearer": {}} }
 *      )
 * )
 * 
 * @OA\PathItem(
 *     path="/getbusinessdetail/{business_profile_id}",
 *     @OA\Get(
 *         summary="get business detail",
 *         description="get business detail",
 *         operationId="getbusinessdetail",
 *         tags={"Business Profile"},
 *         @OA\Parameter(
 *             name="business_profile_id",
 *             description="business_profile_id",
 *             required=true,
 *             in="path",
 *             @OA\Schema(
 *                 type="string"
 *             )
 *         ),
 *         @OA\Response(
 *              response=200,
 *              description="success"
 *         ),
 *         @OA\Response(
 *            response=401,
 *            description="Something went wrong, Please try again."
 *             ),
 *         security={ {"bearer": {}} }
 *     )
 * )
 * 
 * @OA\PathItem(
 *      path="/deletebusinessdetail/{business_profile_id}",
 *      @OA\Delete(
 *      summary="delete business detail",
 *      description="delete business detail",
 *      operationId="deletebusinessdetail",
 *      tags={"Business Profile"},
 *      @OA\Parameter(
 *          name="business_profile_id",
 *          description="business_profile_id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *         response=200,
 *         description=""
 *          ),
 *      @OA\Response(
 *         response=401,
 *         description=""
 *          ),
 *      security={ {"bearer": {}} }
 *    )
 * )
 * 
 * @OA\PathItem(
 *      path="/getposterlist",
 *      @OA\Post(
 *      summary="get poster list",
 *      description="get poster list",
 *      operationId="getposterlist",
 *      tags={"Poster"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Pass offset and limit",
 *         @OA\JsonContent(
 *            required={"offset","limit"},
 *            @OA\Property(property="offset", type="number", format="0", example="0"),
 *            @OA\Property(property="limit", type="number", format="1", example="10"),
 *            @OA\Property(property="search", type="string", format="string", example="test"),
 *            @OA\Property(property="category_id", type="number", format="1", example=5),
 *         ),
 *      ),
 *      @OA\Response(
 *         response=401,
 *         description="No Notification to show.",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Invalid setting details.")
 *             )
 *          ),
 *      )
 * )
 * 
 * @OA\PathItem(
 *      path="/getcategorylist",
 *      @OA\Post(
 *      summary="get category list",
 *      description="get category list",
 *      operationId="getcategorylist",
 *      tags={"Poster"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Pass offset and limit",
 *         @OA\JsonContent(
 *            required={"offset","limit"},
 *            @OA\Property(property="offset", type="number", format="0", example="0"),
 *            @OA\Property(property="limit", type="number", format="1", example="10"),
 *            @OA\Property(property="country_code", type="string", format="string", example="IN/CA"),
 *            @OA\Property(property="start_date", type="string", example="2025-11-05"),
 *            @OA\Property(property="end_date", type="string", example="2025-11-08"),
 *         ),
 *      ),
 *      @OA\Response(
 *         response=401,
 *         description="No Notification to show.",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Invalid setting details.")
 *             )
 *          ),
 *      )
 * )
 * 
 * @OA\PathItem(
 *     path="/addupdatesavedposter",
 *     @OA\Post(
 *         summary="add update saved poster",
 *         description="add update saved poster",
 *         operationId="addupdatesavedposter",
 *         tags={"Saved Poster"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass user credentials",
 *             @OA\JsonContent(
 *                  required={"email"},
 *                  @OA\Property(property="saved_poster_id", type="integer", example=5),
 *                  @OA\Property(property="business_id", type="integer", example=8),
 *                  @OA\Property(property="image", type="string", example="img.png"),
 *                  @OA\Property(property="poster_json", type="string", format="string", example="test json"),
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         ),
 *         security={ {"bearer": {}} }
 *     )
 * )
 * 
 * 
 * @OA\PathItem(
 *     path="/getsavedposterlist",
 *     @OA\Post(
 *         summary="get saved poster list",
 *         description="get saved poster list",
 *         operationId="getsavedposterlist",
 *         tags={"Saved Poster"},
 *         @OA\RequestBody(
 *            required=true,
 *            description="Pass offset and limit",
 *            @OA\JsonContent(
 *               required={"offset","limit"},
 *               @OA\Property(property="offset", type="number", format="0", example="0"),
 *               @OA\Property(property="limit", type="number", format="1", example="10"),
 *            ),
 *         ),
 *         @OA\Response(
 *            response=401,
 *            description="No Notification to show.",
 *            @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Invalid setting details.")
 *                )
 *             ),
 *             security={ {"bearer": {}} }
 *         )
 * )
 * 
 * @OA\PathItem(
 *      path="/deletesavedposter/{saved_poster_id}",
 *      @OA\Delete(
 *      summary="delete saved poster",
 *      description="delete saved poster",
 *      operationId="deletesavedposter",
 *      tags={"Saved Poster"},
 *      @OA\Parameter(
 *          name="saved_poster_id",
 *          description="saved_poster_id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *         response=200,
 *         description=""
 *          ),
 *      @OA\Response(
 *         response=401,
 *         description=""
 *          ),
 *      security={ {"bearer": {}} }
 *    )
 * )
 * @OA\PathItem(
 *     path="/sendpushnotification",
 *     @OA\Post(
 *         summary="Send push notification",
 *         description="Send push notification",
 *         operationId="sendpushnotification",
 *         tags={"Notification"},
 *         @OA\RequestBody(
 *             required=true,
 *             description="Pass devise detail",
 *             @OA\JsonContent(
 *                  required={"device_token","device_type"},
 *                  @OA\Property(property="device_token", type="string", format="string", example="123"),
 *                  @OA\Property(property="device_type", type="string", format="string", example="Android")
 *             )
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Wrong credentials response",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
 *             )
 *         )
 *     )
 * )
 */
class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
}
