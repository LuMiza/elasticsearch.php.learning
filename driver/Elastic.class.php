<?php
namespace  es;
use Elasticsearch\ClientBuilder;

class Elastic
{
    /**
     * 连接信息
     * @var \Elasticsearch\Client
     */
    private $client;

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

    /**
     * 设置索引映射
     */
    public function setMapping($type_name, $index_name)
    {
        #  设置索引和类型
        $params['index'] = $index_name;
        $params['type']  = $type_name;

        #  向现有索引添加新类型
        $myTypeMapping = array(
            '_source' => array(
                'enabled' => true
            ),
            'properties' => array(
                'id' => array(
                    'type' => 'integer', // 整型
                ),
                'title' => array(
                    'type' => 'string', // 字符串型
                ),
                'content' => array(
                    'type' => 'string',
                ),
                'price' => array(
                    'type' => 'integer'
                )
            )
        );
        $params['body'][$type_name] = $myTypeMapping;
        #  更新索引映射
        try {
            return $this->client->indices()->putMapping($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 创建文档模板
     * @param string $type_name
     * @param string $index_name
     * @return array
     */
    public function createMappings($type_name = null, $index_name = null)
    {
        if (!$type_name || !$index_name) {
            return false;
        }

        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'body' => [
                $type_name => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer', // 整型
                            'index' => 'not_analyzed',
                        ],
                        'title' => [
                            'type' => 'string', // 字符串型
                            'index' => 'analyzed', // 全文搜索
                            'analyzer' => 'ik_max_word'
                        ],
                        'content' => [
                            'type' => 'string',
                            'index' => 'analyzed',
                            'analyzer' => 'ik_max_word'
                        ],
                        'price' => [
                            'type' => 'integer'
                        ]
                    ]
                ]
            ]
        ];
        try {
            return  $this->client->indices()->putMapping($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 查看映射
     * @param string $type_name
     * @param string $index_name
     * @return array
     */
    public function getMapping($type_name=null, $index_name=null)
    {
        if (!$type_name || !$index_name) {
            return false;
        }
        $params = [
            'index' => $index_name,
            'type' => $type_name
        ];
        try {
            return $this->client->indices()->getMapping($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 添加文档
     * @param $id
     * @param $doc
     * @param $index_name
     * @param $type_name
     * @return array|bool|mixed
     */
    public function addDoc($id, $doc, $index_name, $type_name) {
        if (! isset($id, $doc, $index_name, $type_name)) {
            return false;
        }
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id,
            'body' => $doc
        ];
        try {
            return $this->client->index($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 判断文档存在
     * @param $id
     * @param $index_name
     * @param $type_name
     * @return array|bool|mixed
     */
    public function existsDoc($id, $index_name, $type_name) {
        if (! isset($id, $index_name, $type_name)) {
            return false;
        }
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id
        ];
        try {
            return $this->client->exists($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 获取文档
     * @param $id
     * @param $index_name
     * @param $type_name
     * @return array|mixed
     */
    public function getDoc($id, $index_name, $type_name) {
        if (! isset($id, $index_name, $type_name)) {
            return false;
        }
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id
        ];
        try {
            return $this->client->get($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 更新文档
     * @param $id
     * @param $index_name
     * @param $type_name
     * @return array|bool|mixed
     */
    public function updateDoc($id, $index_name, $type_name) {
        if (! isset($id, $index_name, $type_name)) {
            return false;
        }
        // 可以灵活添加新字段,最好不要乱添加
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id,
            'body' => [
                'doc' => [
                    'title' => '苹果手机iPhoneX'
                ]
            ]
        ];
        try {
            return $this->client->update($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 删除文档
     * @param $id
     * @param $index_name
     * @param $type_name
     * @return array|bool|mixed
     */
    public function deleteDoc($id, $index_name, $type_name) {
        if (! isset($id, $index_name, $type_name)) {
            return false;
        }
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id
        ];
        try {
            return $this->client->delete($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }



}