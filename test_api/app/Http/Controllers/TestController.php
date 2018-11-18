<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;

class TestController extends Controller
{
    public function auth()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/auth");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"payload\": {
            \"login\": \"admin\",
            \"pass\": \"gonnacode\"
          }
    }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function posts()
    {
        $limit = Input::get('limit');
        $offset = Input::get('offset');

        $token = $_COOKIE['token'];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/posts?limit=$limit&offset=$offset");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function show_post()
    {
        $token = $_COOKIE['token'];
        $id = Input::get('post_id');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/posts/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public function create_post()
    {
        $token = $_COOKIE['token'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/posts");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
              \"payload\": {
                \"title\": \"Hello Woorld!\",
                \"text\": \"Lorem ipsum sit amet...\"
              }
            }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

    public function delete_post()
    {
        $id = Input::get('post_id');

        $token = $_COOKIE['token'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/posts/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

    public function comments()
    {
        $post_id = Input::get('post_id');

        $ch = curl_init();

        $token = $_COOKIE['token'];

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/comments/$post_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function create_comment()
    {
        $token = $_COOKIE['token'];

        $post_id = Input::get('post_id');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/comments/$post_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"payload\": {
                    \"author\": \"Vasya Pupkin\",
                    \"comment\": \"Hello World\"
                }
            }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }

    public function delete_comment()
    {
        $id = Input::get('comment_id');

        $token = $_COOKIE['token'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/comments/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

    public function logout()
    {
        $token = $_COOKIE['token'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://blogs.api/api/logout");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-REQUEST-TOKEN: Bearer $token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }
}
