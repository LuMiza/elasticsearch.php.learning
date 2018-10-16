<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/16
 * Time: 9:49
 */

namespace inter;


interface ElasticsearchCurd
{
    /**
     * 更新文档
     * @param $id  id
     * @param $index  索引
     * @param $type   类型
     * @return mixed
     */
    public function updateDoc($id, $index, $type);

    /**
     * 添加文档
     * @param $id
     * @param $doc   一位关联数组
     * @param $index  索引
     * @param $type   类型
     * @return mixed
     */
    public function addDoc($id, $doc, $index, $type);

    /**
     * 删除文档
     * @param $id  id
     * @param $index_name  索引
     * @param $type_name   类型
     * @return mixed
     */
    public function deleteDoc($id, $index_name, $type_name);

    /**
     * 为索引设置映射 【类似mysql 给database 建 table】
     * @param $type  类型
     * @param $index  索引名
     * @return mixed
     */
    public function setMapping($type, $index);

    /**
     * 获取对应索引的映射
     * @param $index   索引
     * @param $type   类型
     * @return mixed
     */
    public function getMapping($index, $type);

}