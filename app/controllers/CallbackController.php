<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use \Firebase\JWT\JWT;

require __DIR__.'/../config/auth.php';
require __DIR__ . '/../../vendor/autoload.php'; // !!

class CallbackController extends Controller
{
    private function _registerSession($user)
    {
    	$this->session->set(
    		'auth',
    		[
    			'id' => $user->id,
    			'name' => $user->name,
    		]
    	);
    }

    /*
    private function test()
    {
    	echo "TTTTTT!!!";
    }
	*/

    private function _generateJWT($user)
    {
    	$key = JWT_SECRET;
    	$issuedAt = time();
    	$expirationTime = $issuedAt + 2 * 60; // valid for 2 minutes from iat
    	$payload = array(
    		'username' => $user->name,
    		'iat' => $issuedAt,
    		'exp' => $expirationTime,
    	);
    	$alg = 'HS256';
    	$jwt = JWT::encode($payload, $key, $alg);

    	return $jwt;
    }


    public function indexAction()
    {
        $session_code = $this->request->getQuery()['code'];

        $url_token = 'https://github.com/login/oauth/access_token';
		$data = array(
			'client_id' => CLIENT_ID, 
			'client_secret' => CLIENT_SECRET,
			'code' => $session_code
		);

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => array(
		        	"Content-type: application/x-www-form-urlencoded",
		        	"Accept: application/json"
		        ),
		        'method'  => 'POST',
		        'content' => http_build_query($data),

		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url_token, false, $context);

		if ($result) {
			$tmp = json_decode($result);
			var_dump($tmp);
			if (array_key_exists('error', $tmp)) {
				return json_encode(['status' => 'ERROR', 'messages' => $tmp]);
			} else {
				$access_token = $tmp->access_token;
				$scope = $tmp->scope;
			}	
		}

		# uses access_token to get user profile $profile.
		if ($access_token) {
			$url_user = 'https://api.github.com/user';
			// use key 'http' even if you send the request to https://...
			$data = array(
				'access_token' => $access_token
			);
			$query = http_build_query($data);
			$options = array(
			    'http' => array(
			    	'header'  => array(
			        	'User-Agent: PHP' // User-Agent header is required by GitHub.
		        		),
			        'method'  => 'GET',
			    )  
			);
			$context  = stream_context_create($options);
			$auth_result = json_decode(file_get_contents($url_user.'?'.$query, false, $context));
			// $this->test();
			// var_dump($auth_result);
		}
		# checks whether the user is in the database
		$user = Users::findFirst([
			[
				'conditions' => 'github_id = ?1',
				'bind' => [1 => $auth_result->id],
			]

		 ]);
		
		if ($user !== false) {
			$this->_registerSession($user);

			// generates JWT token and save it to DB.
			$token = $this->_generateJWT($user);
			if ($user->save(['token' => $token])) {
				return $this->response->redirect('/profile/'.$user->name);
			}

		}

		/* 
		// check later...
		$this->flash->error(
			'User does not exist'
		);
		*/

		return $this->response->redirect('/login'); 
	}

	public function endsessionAction() 
	{
		$this->session->remove('auth');

		return $this->response->redirect('/login');

	}


}
