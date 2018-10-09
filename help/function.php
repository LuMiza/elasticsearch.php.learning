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