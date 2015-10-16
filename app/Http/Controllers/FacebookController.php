<?php namespace App\Http\Controllers;


class FacebookController extends Controller
{

    public $token;
    public $friends;

    public function __construct()
    {
        //$this->token = 'CAACW5Fg5N2IBACBQeyNUNjrZCliajwowDjohZAo9FEUZCbepV4rAR9ruNkix17UmgNO6Jvy5T07xsOaj5iiPNwItZCXSTG2KGsZCs08fa4fvtm0qyvH6J6xgbNktkDxrtNC3xJJjZCT8TmhZBOBgKzYjXEdUSekZBFPXLOvm5Tvcljvm9oy8h0ihnChn9SvPGKOBAuZCcqyWXldq5ZB79lZC7keWZAOluLVoUKUZD';
        //$this->token[] = 'CAAAACZAVC6ygBAP5GWJZC6mQqpZCVKZC1YpgSOfHvFmpo8ViImHiqmR0d7FrtxGvzlAj9ggZAU3RdGbkCVSgfsKKtZA7xB5WKpIiphdM5ZBi7h9vQ4KU5LmT0znqNmKOhoZB56QOrmj8ZBiF4C4GHgfAQP4BhWqxZBzSnjAyZCpXGxD9KbPVzl0zv5RA8IvYPaWZAjMZD';
        //$this->token[] = 'CAAAACZAVC6ygBABunBxeN8YfhbBvYiJT4XZCeZA1uwnoYaZBiUxnz6JWJl3C3NBJ7yXjhnZAKhfhaZCsaMi0FaM3iUg0ec1pqZBElFWBHfde00amKuy85HZBYmTFPDufYHZAZCaJId1cFdtySYfQdJ2DZBZASpzO81PsYzsIBuuPMaMMYmD4roZCf30KO';
        //$this->token[] = 'CAAAACZAVC6ygBAPy5jP22sMoj346hlFRY1KkQydWuvBLpPQ6fm4Kp7teHxqdIESZBGzpFrBDfcK1aE6dc1onmbvzdjPlDcRWdQhOc0L2SGifB0ZAB359U5jpEoZA7ShB9GBcYL2tII4XCaDozAfbcI3bxtSObCIZCihP4hv51T3D9mBy5Yfic';
        //$this->token[] = 'CAAAACZAVC6ygBAH2HgqikNJdaVMD1JbMPALhHkHZBZCNNU5UXnYkzl5Y5LPeNaN8AqTzoBZCgySuJzPsHeJ19XEYClfc3fI61glVKkGDQAqjOfSRVo8BhiZA4go4orThW5otUQuZAYZAnY9GUEVyPKZCoYy3cELWVgPENpWvBfUk5OdhHEUSvBes';
//        $this->token[] = 'CAAAACZAVC6ygBAGIjP219ujCsuGvjH39G913awyeXkQbhZBZByH2yWsIb1ZB9LbVFxdXoEPoWnTHBOUA1sys5GyQJRHZAwl3NMyZBZAjevV68fYOMxOZCkoYYDmEw4EgixY2ZBtTcMQFGaYE6xtJ0HTlRVKOK95V4gTPfNvEJ2B9KGuChal2LN4Q5WWHjRHAi6pMZD';
        $this->token = 'CAAAACZAVC6ygBAIQYkiBoQU0eFvpoAFV5ZAaZCHZAPn0H2kdn4FZBJ1ZChTRlqbEtxjMozMgY8BzCJrMZB24bZB5XcJ1ZCX1eGsAvkA6psWQLAdZCZBHQfqVZCfqEbqMMcPfpC2R41rt1DXRroxl6hSyFVIWNLQLxe4Te2rsMenDUtZCWmTJ3iQtADZBi2';
        //$this->token[] = 'CAAAACZAVC6ygBAKLu2ZBYSFzLzZC1N34Rbf0dfkPZBvZATKf0AoX27VBFXEuvcVdZBAJF2tFqytDqCDZBS7iPnWmcYqjSSKT91E7dojli8uH1d9qxRDkt8oHXU0EbBLLXLL3sTZBEcFgw4n7MgpRzSloaxIXl0hprZCwZCuT2RexmXQeGQpZANc7UdV';
        //$this->token[] = 'CAAAACZAVC6ygBAC3158e7TxTV67g47MVgei9Fveh7ZALMKgiR5ZBVCAmbKzYMjsyyFw4sFYNHgnnwdxMNYssL5HS0riN4rda0cRKFUWIcMbwdvJYgirLHULnPVUKmOQSZB6ocskDrzRBiTVoZAitp0DsXMjRvXQdtRDs3si1z6r6IMDkcuVBT';
        //$this->token[] = 'CAAAACZAVC6ygBAKtMbfsZCvLKMDX5lTr3ML8urrjti8ZConCF7HhgaRYUbPDKgIv7p4sNcsq9T3P5TQUbJrBdwIxeOz1DLogZBu6tjR9YwnrRnMBSDfsCkE14atk1jmYRwQf66IZBZAU8YLvOocQDTE8fWAChZA8jubiEfeh08iX3HNW6BlescT5Q6MUKcXajIZD';
    }

    public function index()
    {
        dd($this->getGroups($this->token));
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
        dd($result);
        return $this->getData($result);
    }

    public function postGroups()
    {
        $list = array();
        foreach($this->token as $token) {
            $ids = $this->getGroups($token);
            if(!is_array($ids)) continue;
            foreach($ids as $id) {
                $path = 'curl -i -X POST \ -d "message='.urlencode('Welcome To RosyGroup').'" \ -d "link='.urlencode('https://www.facebook.com/517718418406479').'" \ -d "access_token='.$token.'" \ "https://graph.facebook.com/v2.1/'.$id.'/feed"';
                $list[] = $this->execute($path);
            }
        }
        dd($list);
    }


    public function getFriends()
    {
        $path = 'curl -i -X GET \ "https://graph.facebook.com/v2.5/me/groups?access_token=' . $this->token . '"';
        $result = $this->execute($path);
        return $this->getData($result);
    }

    /**
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

    public function getData($result)
    {
        if (!isset($result->data)) return false;

        $ids = array();
        foreach ($result->data as $data) {
            $ids[] = $data->id;
        }
        return $ids;
    }

}