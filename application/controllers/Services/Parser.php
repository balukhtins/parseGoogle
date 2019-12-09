<?php

class Services_Parser
{
    public function parser($post)
    {
        extract($post);
        $url = "https://www.google.com/search?q=$word&num=100";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        //var_dump($result);
        $doc = new DOMDocument();
        $res = @$doc->loadHTML($result);
      if($res){
           $tags = $doc->getElementsByTagName('a');
           $i=1;
           foreach ($tags as $a){
               if ($a->hasAttribute('href')){
                   preg_match_all('{/url\?q=(.+)&sa.+}xu',$a->getAttribute('href'),$body);
                  if(isset($body[1][0])){
                       if ( strstr ($body[1][0],$domain)){
                            return $i;
                        }
                        $i++;
                    }
                }
            }
        }
        curl_close($ch);
   }
}
