<?php
namespace  es;
use Elasticsearch\ClientBuilder;

class Elastic
{
    private $client;
    // 构造函数
    public function __construct($params)
    {
        $this->client = ClientBuilder::create()->setHosts($params)->build();
    }

    /**
     * 创建一个索引
     * @param $name 索引名字
     * @return array
     */
    public function addIndex($name)
    {
        $params = [
            'index' => $name,
            'body' => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ]
            ]
        ];
        try{
            return $this->client->indices()->create($params);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 删除索引
     * @param $name 索引名字
     * @return array
     */
    public function delIndex($name)
    {
        $params = [
            'index' => $name
        ];
        try{
            return $this->client->indices()->delete($params);
        }catch (\Exception $e){
            return  json_decode($e->getMessage(), true);
        }
    }



}