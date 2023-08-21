<?php

namespace app\model;

use think\Model;
use Chance\Log\facades\OperationLog;
use app\admin\service\log\AdminLogService;
use function app\admin\model\dataReturn;


class BasicModel extends Model
{
    protected $autoWriteTimestamp = false;

//    /**
//     * 获取带分页的列表
//     * @param $limit
//     * @param array $where
//     * @param string $order
//     * @param string $field
//     * @return array
//     */
//    public function getPageList($limit, $where = [], $field = "*", $order = "id desc"): array
//    {
//        try {
//
//            $list = $this->field($field)->where($where)->order($order)->paginate($limit);
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, 'success', $list);
//    }
//
//    /**
//     * 获取所有的数据不分页
//     * @param array $where
//     * @param string $order
//     * @param string $field
//     * @return array
//     */
//    public function getAllList($where = [], $field = "*", $order = "id desc"): array
//    {
//        try {
//
//            $list = $this->field($field)->where($where)->order($order)->select();
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, 'success', $list);
//    }
//
//    /**
//     * 获取指定条目的数据
//     * @param array $where
//     * @param int $limit
//     * @param string $field
//     * @param string $order
//     * @return array
//     */
//    public function getLimitList($where = [], $limit = 10, $field = "*", $order = "id desc"): array
//    {
//        try {
//
//            $list = $this->field($field)->where($where)->order($order)->limit($limit)->select();
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, 'success', $list);
//    }
//
//    /**
//     * 根据id获取信息
//     * @param $id
//     * @param string $pk
//     * @param string $field
//     * @return array
//     */
//    public function getInfoById($id, $pk = 'id', $field = '*'): array
//    {
//        try {
//
//            $info = $this->field($field)->where($pk, $id)->find();
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, 'success', $info);
//    }
//
//    /**
//     * 根据ids获取信息
//     * @param $ids
//     * @param string $pk
//     * @param string $field
//     * @return array
//     */
//    public function getInfoByIds($ids, $pk = 'id', $field = '*'): array
//    {
//        try {
//
//            $list = $this->field($field)->whereIn($pk, $ids)->select();
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, 'success', $list);
//    }
//
//    /**
//     * 根据id获取信息
//     * @param $where
//     * @param string $field
//     * @return array
//     */
//    public function findOne($where, $field = '*'): array
//    {
//        try {
//
//            $info = $this->field($field)->where($where)->find();
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, 'success', $info);
//    }
//
//    /**
//     * 添加单条数据
//     * @param $param
//     * @return array
//     */
//    public function insertOne($param): array
//    {
//        try {
//
//            $id = $this->insertGetId($param);
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '添加成功', $id);
//    }
//
//    /**
//     * 批量添加
//     * @param $param
//     * @return array
//     */
//    public function insertBatch($param): array
//    {
//        try {
//
//            $this->insertAll($param);
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '添加成功');
//    }
//
//    /**
//     * 根据id更新数据
//     * @param $param
//     * @param $id
//     * @param string $pk
//     * @return array
//     */
//    public function updateById($param, $id, $pk = 'id'): array
//    {
//        try {
//
//            $this->where($pk, $id)->update($param);
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '更新成功');
//    }
//
//    /**
//     * 根据where条件更新数据
//     * @param $param
//     * @param $where
//     * @return array
//     */
//    public function updateByWehere($param, $where): array
//    {
//        try {
//
//            $this->where($where)->update($param);
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '更新成功');
//    }
//
//    /**
//     * 根据ids更新
//     * @param $param
//     * @param $ids
//     * @param string $pk
//     * @return array
//     */
//    public function updateByIds($param, $ids, $pk = 'id'): array
//    {
//        try {
//
//            $this->whereIn($pk, $ids)->update($param);
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '更新成功');
//    }
//
//    /**
//     * 根据id删除
//     * @param $id
//     * @param string $pk
//     * @return array
//     */
//    public function delById($id, $pk = 'id'): array
//    {
//        try {
//
//            $this->where($pk, $id)->delete();
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '删除成功');
//    }
//
//    /**
//     * 根据$where条件删除
//     * @param $where
//     * @return array
//     */
//    public function delByWhere($where): array
//    {
//        try {
//
//            $this->where($where)->delete();
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '删除成功');
//    }
//
//    /**
//     * 根据ids删除
//     * @param $ids
//     * @param string $pk
//     * @return array
//     */
//    public function delByIds($ids, $pk = 'id'): array
//    {
//        try {
//
//            $this->whereIn($pk, $ids)->delete();
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '删除成功');
//    }
//
//    /**
//     * 检测数据唯一
//     * @param $where
//     * @param int $id
//     * @param string $pk
//     * @return array
//     */
    public function checkUnique($where, $id = 0, $pk = 'id'): array
    {
        try {
            if (empty($id)) {
                $has = $this->field($pk)->where($where)->find();
            } else {
                $has = $this->field($pk)->where($where)->where($pk, '<>', $id)->find();
            }
        } catch (\Exception $e) {
            return failed($e->getMessage());
        }

        return $has;
    }
//
//    /**
//     * 增加数据
//     * @param $where
//     * @param $field
//     * @param $num
//     * @return array
//     */
//    public function incData($where, $field, $num): array
//    {
//        try {
//
//            $this->where($where)->inc($field, $num)->update();
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '操作成功');
//    }
//
//    /**
//     * 减少数据
//     * @param $where
//     * @param $field
//     * @param $num
//     * @return array
//     */
//    public function decData($where, $field, $num): array
//    {
//        try {
//
//            $this->where($where)->dec($field, $num)->update();
//            (new AdminLogService())->write([], OperationLog::getLog());
//        } catch (\Exception $e) {
//            return dataReturn(-1, $e->getMessage());
//        }
//
//        return dataReturn(0, '操作成功');
//    }
}