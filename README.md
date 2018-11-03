
Thinkphp5.1-Api 
===================
作者:yangzhibin
===================

Thinkphp5.1-Api 使用ThinkPHP5.10核心版框架开发.

整理下这套代码：主要针对接口开发，我已经把常用的基础模块分离出来，直接拉取下来可以快速基于此进入模块化开发,扩展性好

项目中主要分离出来的处理有：
  +service             逻辑层的处理
  +cache               缓存层
  +validate            验证层
  +model               model映射层
  +exception           错误接管
  +errorcode           错误码管理
  +sms                 短信接入管理
  +route               路由处理【新增:post 删除:del 修改:put 查询:get】

更多细节参阅 https://github.com/smallgrass-mr/Thinkphp5.1-Api
框架方面的知识请参阅：https://www.kancloud.cn/manual/thinkphp5_1/353946
