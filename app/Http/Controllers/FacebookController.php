<?php namespace App\Http\Controllers;


use App\Http\Requests\FacebookRequest;

class FacebookController extends Controller
{

    public $token;
    public $friends;

    public function __construct()
    {
    }

    public function index()
    {
        return redirect()->route('fb.group');
    }

    public function pushGroups()
    {
        return view('groups.index');
    }
    /**
     * Get Group Data
     * @param $token
     * @return mixed
     */
    public function getGroups($token)
    {
        $path = 'curl -i -X GET \ "https://graph.facebook.com/v2.5/me/groups?access_token=' . $token . '"';
        $result = $this->execute($path);
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
        $path = [];
        $path[] = 'curl -i -X POST';
        if($request->has('message')) {
            $path[] = '-d "message='.urlencode($request->get('message')).'"';
        }
        $path[] = '-d "link='.urlencode($request->get('link')).'"';
        /**
         * Process
         */
        $list = array();
        foreach($tokens as $token) {
            //set token
            $path[] = '-d "access_token='.$token.'"';

            $ids = $this->getGroups($token);
            if(!is_array($ids)) continue;
            foreach($ids as $id) {
                $path[] = '"https://graph.facebook.com/v2.1/'.$id.'/feed"';
                $list[] = $this->execute(implode(' \ ', $path));
            }
        }
        $status = $this->getStatus($list);
        return view('groups.index', compact('status'));
    }

    /**
     * Get list friends
     * @return array|bool
     */
    public function getFriends()
    {
        $path = 'curl -i -X GET \ "https://graph.facebook.com/v2.5/me/groups?access_token=' . $this->token . '"';
        $result = $this->execute($path);
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
     * Decode API Result
     * Get list data array
     * @param $result
     * @return bool
     */
    public function render($result)
    {
        $args = json_decode($result);
        return isset($args->data) ? $args->data : false;
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