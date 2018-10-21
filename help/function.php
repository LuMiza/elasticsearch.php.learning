<?php

if (! function_exists('dd')) {
    /**
     * 开发调试 ，格式化输出内容，并且终止程序
     * dd 函数参数可以一次性传入多个
     */
    function dd()
    {
        require 'Dump.class.php';
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        if (isset($bt[0]['file'], $bt[0]['line'])) {
            $file =  "{$bt[0]['file']}(line:{$bt[0]['line']})";
            echo '<code><small style="margin:50px 0px;">' . $file . '</small><br /><br /><br />'  . '</code>';
            unset($bt, $file);
        }
        call_user_func_array(array(new \Common\Helper\Dump(), '__construct'), func_get_args());
        exit();
    }
}

if (! function_exists('config')) {
    /**
     * 获取配置信息
     * @param null $index   获取配置信息：比如elastic.master 是获取[ elastic=> [master => ''] ]
     *
     * @param null $path   配置文件：  比如 remote  是config/remote.php的配置信息
     *                                  比如 file/remote  是config/file/remote.php的配置信息
     *                                  未设置则取默认配置文件
     * @return bool|mixed
     */
    function config($index=null, $path=null)
    {
        $path = !$path? ROOT.'config/config.php': ROOT.'config/'.$path.'.php';
        $config = require $path;
        if ($index ===  null) {
            return $config;
        }
        $indexs = explode('.', $index);
        $pos = false;
        foreach ($indexs as $key => $val) {
            if ($pos === false) {
                $pos = isset($config[$val])? $config[$val]: null;
            } else {
                $pos = isset($pos[$val])? $pos[$val]: null;
            }
        }
        return $pos;
    }
}

if (! function_exists('db')) {
    /**
     * 数据库助手函数
     * @return medoo
     * @throws Exception
     */
    function db(){
        $config = config('medoo');
        return new  medoo($config);
    }
}

