<?php
/**
 * 对应elasticsearch的类型全部继承该类处理
 * User: Administrator
 * Date: 2018/10/16
 * Time: 10:03
 */

namespace es;


use inter\ElasticsearchCurd;

class EsModel  implements ElasticsearchCurd
{
    use Elastic;

    /**
     * 添加文档
     * @param $id   主键
     * @param $doc   一位关联数组
     * @param $index_name  索引
     * @param $type_name   类型
     * @return mixed
     */
    public function addDoc($id, $doc, $index_name, $type_name)
    {
        // TODO: Implement addDoc() method.
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
     * 删除文档
     * @param $id  id
     * @param $index_name  索引
     * @param $type_name   类型
     * @return mixed
     */
    public function deleteDoc($id, $index_name, $type_name)
    {
        // TODO: Implement deleteDoc() method.
    }

    /**
     * 更新文档
     * @param $id  id
     * @param $index  索引
     * @param $type   类型
     * @return mixed
     */
    public function updateDoc($id, $index, $type)
    {
        // TODO: Implement updateDoc() method.
    }

    /**
     * 为索引设置映射 【类似mysql 给database 建 table】
     * @param $type  类型
     * @param $index  索引名
     * @return mixed
     */
    public function setMapping($type, $index)
    {
        // TODO: Implement setMapping() method.
    }

    /**
     * 获取对应索引的映射
     * @param null $index_name
     * @param null $type_name
     * @return mixed
     */
    public function getMapping($index_name=null, $type_name=null)
    {
        // TODO: Implement getMapping() method.
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

}