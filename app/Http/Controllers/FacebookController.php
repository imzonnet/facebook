<?php namespace App\Http\Controllers;


use App\Http\Requests\FacebookRequest;

class FacebookController extends Controller
{

    public $token;
    public $curl;

    public function __construct()
    {
        $this->curl = new \cURL();
    }

    public function index()
    {
        return redirect()->route('fb.group');
    }

    public function pushGroups()
    {
        return view('groups.index');
    }
    public function test() {
        $token = 'CAACW5Fg5N2IBACBQeyNUNjrZCliajwowDjohZAo9FEUZCbepV4rAR9ruNkix17UmgNO6Jvy5T07xsOaj5iiPNwItZCXSTG2KGsZCs08fa4fvtm0qyvH6J6xgbNktkDxrtNC3xJJjZCT8TmhZBOBgKzYjXEdUSekZBFPXLOvm5Tvcljvm9oy8h0ihnChn9SvPGKOBAuZCcqyWXldq5ZB79lZC7keWZAOluLVoUKUZD';
        $rs = $this->curl->post("https://graph.facebook.com/v2.1/333069883422442/feed", 'link=https%3A%2F%2Fwww.facebook.com%2F1685526368345808&access_token=CAACW5Fg5N2IBACBQeyNUNjrZCliajwowDjohZAo9FEUZCbepV4rAR9ruNkix17UmgNO6Jvy5T07xsOaj5iiPNwItZCXSTG2KGsZCs08fa4fvtm0qyvH6J6xgbNktkDxrtNC3xJJjZCT8TmhZBOBgKzYjXEdUSekZBFPXLOvm5Tvcljvm9oy8h0ihnChn9SvPGKOBAuZCcqyWXldq5ZB79lZC7keWZAOluLVoUKUZD');
        dd(json_decode($rs));
    }
    /**
     * Get Group Data
     * @param $token
     * @return mixed
     */
    public function getGroups($token)
    {
        $result = json_decode($this->curl->get('https://graph.facebook.com/v2.5/me/groups?access_token=' . $token . '"'));
        return $this->getIds($result);
    }

    /**
     * Post link to user group
     * @param FacebookRequest $request
     * @return array
     */
    public function postGroups(FacebookRequest $request)
    {
        $tokens = explode(PHP_EOL, trim($request->get('token')));
        /**
         * Set Path
         */
        $data = [];
        if($request->has('message')) {
            $data[] = 'message='.urlencode($request->get('message'));
        }
        $data[] = 'link='.urlencode($request->get('link'));
        /**
         * Process
         */
        $list = array();
        foreach($tokens as $token) {
            //set token
            $data[] = 'access_token='.$token;

            $ids = $this->getGroups($token);
            var_dump($ids);
            /*
            if(is_array($ids)) {
                foreach($ids as $id) {
                    $url = "https://graph.facebook.com/v2.1/{$id}/feed";
                    $list[] = json_decode($this->curl->post($url, implode('&', $data)));
                }
            };
            */
        }
        $status = $this->getStatus($list);
        return view('groups.index', compact('status'));
    }

    /**
     *
     */
    public function checkToken(){
        return view('token');
    }

    /**
     * Get list friends
     * @param $token
     * @return array|bool
     */
    public function getFriends($token)
    {
        $result = json_decode($this->curl->get('https://graph.facebook.com/v2.5/me/groups?access_token=' . $token));
        return $this->getIds($result);
    }

    /**
     * Execute cURL
     * @param $path
     * @return mixed
     */
    public function execute($path)
    {
        return json_decode(exec($path));
    }

    /**
     * Get list IDs
     * @param $result
     * @return array|bool
     */
    public function getIds($result)
    {
        if (!isset($result->data)) return false;

        $ids = array();
        foreach ($result->data as $data) {
            $ids[] = $data->id;
        }
        return $ids;
    }

    /**
     * Get Status Processed
     * @param $args
     * @return array
     */
    public function getStatus($args)
    {
        $status = [
            'success' => [
                'count' => 0,
                'id' => []
            ],
            'error' => [
                'count' => 0,
                'msg' => []
            ],
        ];
        foreach($args as $item) {
            if(isset($item->id)) {
                $status['success']['count'] += 1;
                $status['success']['id'][] = $item->id;
            } else {
                $status['error']['count'] += 1;
                $status['error']['msg'][] = $item->error->message;
            }
        }
        return $status;
    }
}