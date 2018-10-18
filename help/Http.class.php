<?php
/**
 * 该类用于处理elasticsearch原生操作
 * User: Administrator
 * Date: 2018/10/18
 * Time: 11:33
 */

namespace help;


class Http{

    /**
     * 对elasticsearch进行post 操作
     *              $result = \help\Http::curlPost('http://192.168.80.139:9200/_search', '{"query":{"match_all":{}}}');
     * @param $url
     * @param null $data json_encode 处理过的数据【json数据】
     * @param bool $ssl
     * @return bool|mixed
     */
    public static function curlPost($url, $data=null, $ssl=true)
    {
        $headers = [
            'Accept:application/json',
            'Content-Type:application/json;charset=utf-8'
        ];
        //curl完成请求
        $curl = curl_init();
        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);
        //referer 头，请求来源
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //ssl相关的
        if( $ssl )
        {
            //禁用后cURL将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            /*
             * 1 检查服务器SSL证书中是否存在一个公用名(common name)。
             * 译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。
             * 2 检查公用名是否存在，并且是否与提供的主机名匹配。
             * */
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        }
        //处理post相关选项
        curl_setopt($curl, CURLOPT_POST, true);//是否为post请求
        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//处理请求数据
        }
        //是否处理响应头
        curl_setopt($curl,CURLOPT_HEADER,false);
        //curl_exec()是否返回响应结果
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        //发出请求
        $response = curl_exec($curl);
        curl_close($curl);
        if (! $response ) {
            return false;
        }
        return $response;
    }

    /**
     * 对elasticsearch进行get操作
     *                  $result =  \help\Http::curlGet('http://192.168.80.139:9200/_cluster/health?pretty=true');
     * @param $url
     * @param null $json
     * @param bool $ssl
     * @return bool|mixed
     */
    public static function curlGet($url, $json=null, $ssl=true)
    {
        $headers = [
            'Accept:application/json',
            'Content-Type:application/json;charset=utf-8'
        ];
        //curl完成请求
        $curl = curl_init();
        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);
        //referer 头，请求来源
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        //ssl相关的
        if( $ssl )
        {
            //禁用后cURL将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            /*
             * 1 检查服务器SSL证书中是否存在一个公用名(common name)。
             * 译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。
             * 2 检查公用名是否存在，并且是否与提供的主机名匹配。
             * */
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        }
        //是否处理响应头  设置头文件的信息作为数据流输出
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //curl_exec()是否返回响应结果
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        if ($json) {
            //发送json数据
            curl_setopt($curl,CURLOPT_POSTFIELDS, $json);
        }
        //发出请求
        $response = curl_exec($curl);
        curl_close($curl);
        if (! $response) {
            return false;
        }
        return $response;
    }

    /**
     * 通用curl请求
     * @param null $url
     * @param null $method   put   get post delete
     * @param null $params 数组
     * @param null $auth 传递一个连接中需要的用户名和密码，格式为："[username]:[password]"。
     * @return mixed
     */
    public static function curl($url=null, $method=null, $params=null, $auth=null)
    {
        //初始化CURL句柄
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);//设置请求的URL
//        curl_setopt($curl, CURLOPT_HEADER, false);// 不要http header 加快效率
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出

        //SSL验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求时要设置为false 不验证证书和hosts  FALSE 禁止 cURL 验证对等证书（peer's certificate）, 自cURL 7.10开始默认为 TRUE。从 cURL 7.10开始默认绑定安装。
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);//检查服务器SSL证书中是否存在一个公用名(common name)。
        $header = [
            'Accept:application/json',
            'Content-Type:application/json;charset=utf-8'
        ];
        if(!empty($header)){
            curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );//设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
        }
        //请求时间
        $timeout = 30;
        curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $timeout);//设置连接等待时间

        //不同请求方法的数据提交
        switch (strtoupper($method)){
            case "GET" :
                curl_setopt($curl, CURLOPT_HTTPGET, true);//TRUE 时会设置 HTTP 的 method 为 GET，由于默认是 GET，所以只有 method 被修改时才需要这个选项。
                break;
            case "POST":
                if(is_array($params)){
                    $params = json_encode($params,320);
                }
                //#curl_setopt($curl, CURLOPT_POST,true);//TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。
                //#curl_setopt($curl, CURLOPT_NOBODY, true);//TRUE 时将不输出 BODY 部分。同时 Mehtod 变成了 HEAD。修改为 FALSE 时不会变成 GET。
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");//HTTP 请求时，使用自定义的 Method 来代替"GET"或"HEAD"。对 "DELETE" 或者其他更隐蔽的 HTTP 请求有用。 有效值如 "GET"，"POST"，"CONNECT"等等；
                //设置提交的信息
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);//全部数据使用HTTP协议中的 "POST" 操作来发送。
                break;
            case "PUT" :
                curl_setopt ($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($params,320));
                break;
            case "DELETE":
                curl_setopt ($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
                break;
            default:
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
        }
        //传递一个连接中需要的用户名和密码，格式为："[username]:[password]"。
        if (!empty($auth) && isset($auth['username']) && isset($auth['password'])) {
            curl_setopt($curl, CURLOPT_USERPWD, "{$auth['username']}:{$auth['password']}");
        }
        $data = curl_exec($curl);//执行预定义的CURL
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);//获取http返回值,最后一个收到的HTTP代码
        curl_close($curl);//关闭cURL会话
        return json_decode($data,true);
    }

}