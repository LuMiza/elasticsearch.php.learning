<?php
namespace  es;
use Elasticsearch\ClientBuilder;

trait Elastic
{
    /**
     * 连接信息
     * @var \Elasticsearch\Client
     */
    protected $client;

    public function __construct()
    {
        $params = config('elastic');
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
                    'number_of_shards' => 2,//分片数
                    'number_of_replicas' => 0//副本数
                ]
            ]
        ];
        try {
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
        try {
            return $this->client->indices()->delete($params);
        } catch (\Exception $e) {
            return  json_decode($e->getMessage(), true);
        }
    }

    /**
     * 获取所有索引
     * @return array|mixed
     */
    public function indexs()
    {
        try {
            return $this->client->indices()->getSettings();
        } catch (\Exception $e) {
            return  json_decode($e->getMessage(), true);
        }
    }

}