<?php

use Illuminate\Http\Request;
use \DrewM\MailChimp\MailChimp;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('campaign', 'CampaignController@sendCampaignAndStoreNews');

//Route::post('campaign', function (Request $request) {
    /*$MailChimp = new MailChimp(env('MAILCHIMP_APIKEY'));
    $result1 = $MailChimp->post("campaigns", [
        'type' => 'regular',
        'recipients' => ['list_id' => env('MAILCHIMP_LIST_ID')],
        'settings' => ['subject_line' => 'Nová aktualita 4',
            'reply_to' => 'xsnider@stuba.sk',
            'from_name' => 'xsnider@stuba.sk'
        ]
    ]);

    $response = $MailChimp->getLastResponse();
    $responseObj = json_decode($response['body']);

    $html_1 = "<!DOCTYPE html>
                <html>
                <body>
                
                <h1>Raw html test.</h1>
                
                <p><strong>TESTING SENDING NEWSLETTER</strong></p>
                
                </body>
                </html>";

    $result2 = $MailChimp->put('campaigns/' . $responseObj->id . '/content', [
        'html' => $html_1
    ]);
    $result3 = $MailChimp->post('campaigns/' . $responseObj->id . '/actions/send');
    return view('adminnews', ['result' => $responseObj->id, 'post_res' => $responseObj->id]);*/
   // return ['title' => $request->input('title'), 'content' => $request->input('content')];
///});























