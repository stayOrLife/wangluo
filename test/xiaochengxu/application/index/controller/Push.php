<?php


class Push {
	public $id;
	public $url;
	public function Data($typeid,$title,$body,$url) {
		$data['typeid'] = $typeid;
		$data['title'] = $title;
		$data['body'] = $body;
		$this->Post($url, $data);
		return $this->url;
	}
	public function Post($url, $post = null) {
		$context = array();
		if (is_array($post)) {
			ksort($post);
			$context['http'] = array (
				'timeout'=>60,
				'method' => 'POST',
				'content' => http_build_query($post, '', '&'),
			);
		}
        $re =  file_get_contents($url, false, stream_context_create($context)); //返回数据
        $reArray = json_decode($re, true);
        $this->id = $reArray['id'];
        $this->url = $reArray['arcurl'];
    }

	//curl拔数据
    public function https_request($url,$data = null){
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    	if (!empty($data)){
    		curl_setopt($curl, CURLOPT_GET, 1);
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    	}
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	$output = curl_exec($curl);
    	curl_close($curl);
    	return $output;
    }



}
