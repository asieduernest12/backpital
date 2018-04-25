<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group([],function(Router $api){

      //how to create a rest url end point
      $api->resource('hospital','App\\Http\\Controllers\\HospitalController');//completed
      $api->resource('doctor','App\\Http\\Controllers\\DoctorController');//completed
      $api->resource('user','App\\Http\\Controllers\\UserController');//completed
      $api->resource('post','App\\Http\\Controllers\\PostController');
      $api->resource('comment','App\\Http\\Controllers\\MealommentController');
      $api->resource('meal','App\\Http\\Controllers\\MealController');
      $api->resource('exercise','App\\Http\\Controllers\\ExerciseController');
      $api->resource('bookmark','App\\Http\\Controllers\\BookmarkController');
      $api->resource('Appointment','App\\Http\\Controllers\\AppointmentController');

    });

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');



    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
