<?php
include("simple_html_dom.php");

class binotel {

	public $type = "gcStatistics";

	public $widgetID = "";

	public $startDay = "";
	public $startMonth = "";
	public $startYear = "";

	public $stopDay = "";
	public $stopMonth = "";
	public $stopYear = "";


	public $login = "";
	public $password = "";

	private $url;

	private $html;



	public function arrayTOxml($array, $parent, $name) {

		header("Content-Type: text/xml");


		$xml = "";

  $xml .=  "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\n";
    $xml .=  "<$parent>\n";
    foreach ($array as $element) {
       $xml .=  "  <$name>\n";
        foreach ($element as $child => $value) {
            $xml .=  "    <$child>$value</$child>\n";
        }
       $xml .=  "  </$name>\n";
    }
    $xml .=  "</$parent>\n";

    return $xml;
}





    


	public function start(){
			$url = "https://my.binotel.ua/?module=";
			$url .= $this->type . "&";
			$url .= "widgetID=".$this->widgetID . "&";
			$url .= "startDay=".$this->startDay . "&";
			$url .= "startMonth=".$this->startMonth . "&";
			$url .= "startYear=".$this->startYear . "&";
			$url .= "stopDay=".$this->stopDay . "&";
			$url .= "stopMonth=".$this->stopMonth . "&";
			$url .= "stopYear=".$this->stopYear;
			$this->url = $url;
			// $this->html = str_get_html($this->dowunload());
	}


	public function dowunload(){



		$ch = curl_init();
      	curl_setopt($ch, CURLOPT_URL, $this->url); // отправляем на
     	curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
		curl_setopt($ch, CURLOPT_POST, 1); // использовать данные в post
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(
				  'logining[email]'=>$this->login,
				  'logining[password]'=>$this->password,
				  'logining[submit]'=>''
					));
			$data = curl_exec($ch);
			curl_close($ch);
          return $data;
	}









 public function getGetCall($type) {


					 	$html = str_get_html($this->dowunload());

					 	$data = "";




					 
					$array = array();

					 	foreach ($html->find(".gc-statistics-data tbody tr") as $key => $value) {

					        if($key >= 2):
					        	$array[]  = array(
					        		'number' => strip_tags($value->find("td",1)->find(".number",0)->innertext),
					        		'site' => strip_tags($value->find("td",6)->find(".row-with-two-cells",7)->find(".right-cell",0)->innertext),
					        		'customer'=>strip_tags($value->find("td",2)->find(".name",0)->innertext),
					        		'customer_number'=>strip_tags($value->find("td",2)->find(".number",0)->innertext)

					        		);
					          endif;
					 	}



      if($type == "xml"):
      	 return $this->arrayTOxml($array,'root','clients');
      elseif($type == 'json'):
      	 return json_encode($array);
      elseif($type == 'array'):
      	 return $array;
      endif;
 }


}
