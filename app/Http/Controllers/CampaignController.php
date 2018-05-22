<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;
use \DrewM\MailChimp\MailChimp;
use Mysqli;

class CampaignController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    function connect_to_db($db_host, $db_user, $db_pass, $db_name)
    {
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno) {
            echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
        }
        $conn->set_charset("utf8");
        return $conn;
    }

    public function index()
    {
        $conn = $this->connect_to_db(env('DB_HOST', '127.0.0.1'), env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge'));

        $newsResult = array();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT title, content FROM news";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($newsResult, ["title" => $row['title'], "content" => $row['content']]);
            }
        } else {
            echo "0 results";
        }

        return view( 'adminnews', ["news" => $newsResult] );
    }

    public function sendCampaign(Request $request)
    {
        $MailChimp = new MailChimp(env('MAILCHIMP_APIKEY'));
        $result1 = $MailChimp->post("campaigns", [
            'type' => 'regular',
            'recipients' => ['list_id' => env('MAILCHIMP_LIST_ID')],
            'settings' => ['subject_line' => 'Nová aktualita',
                'reply_to' => 'xsnider@stuba.sk',
                'from_name' => 'xsnider@stuba.sk'
            ]
        ]);

        $response = $MailChimp->getLastResponse();
        $responseObj = json_decode($response['body']);

        $html = "<h3>".$request->input('title')."</h3><p>".$request->input('content')."</p>";
        /*$result2 = $MailChimp->put('campaigns/' . $responseObj->id . '/content', [
            'template' => ['id' => intval(env('TEMPLATE_ID')),
                'sections' => ['body' => $html]
            ]
        ]);*/
        $result2 = $MailChimp->put('campaigns/' . $responseObj->id . '/content', [
            'html' => $html
        ]);

        $result3 = $MailChimp->post('campaigns/' . $responseObj->id . '/actions/send');
        //return view('adminnews', ['result' => $responseObj->id, 'post_res' => $responseObj->id]);
        return $responseObj->id;
        //return ['title' => $request->input('title'), 'content' => $request->input('content')];
    }

    function insertTableRecord($title, $content) {
        $conn = $this->connect_to_db(env('DB_HOST', '127.0.0.1'), env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge'));

        $newsResult = array();

        $query1 = "INSERT INTO news(title, content) VALUES (?, ?);";

        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param('ss', $title, $content);
        $stmt1->execute();


        $sql = "SELECT title, content FROM news";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($newsResult, ["title" => $row['title'], "content" => $row['content']]);
            }
        } else {
            echo "0 results";
        }

        return $newsResult;
    }

    public function sendCampaignAndStoreNews(Request $request) {
        $this->sendCampaign($request);
        $newRes = $this->insertTableRecord($request->input('title'), $request->input('content'));
        return $newRes;
    }

}
