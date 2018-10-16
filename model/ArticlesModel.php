<?php
/**
 * 对goods类型的处理
 * User: Administrator
 * Date: 2018/10/16
 * Time: 10:13
 */

namespace Model;


use es\EsModel;

class ArticlesModel extends EsModel
{
    /**
     * 设置索引映射
     * @param $type_name 类型 【相当于mysql的table】
     * @param $index_name  索引 【相当于mysql的database】
     * @return array|mixed
     */
    public function setMapping($type_name, $index_name)
    {
        $params = [
            'index' => $index_name,
            'type'  => $type_name,
            'body'  => [
                $type_name => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer', // 整型
                        ],
                        'title' => [
                            'type' => 'string', // 字符串型
                        ],
                        'content' => [
                            'type' => 'string',
                        ],
                        'price' => [
                            'type' => 'integer'
                        ]
                    ]
                ],
            ]
        ];
        try {
            return $this->client->indices()->putMapping($params);
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    /**
     * 查看映射
     * @param string $index_name
     * @param string $type_name
     * @return array
     */
    public function getMapping($index_name=null, $type_name=null)
    {
        if (! $index_name) {
            return false;
        }
        $params = [
            'index' => $index_name,
        ];
        if ($type_name) {
            $params['type'] = $type_name;
        }
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