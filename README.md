<h1 align="center">一条开放接口SDK</h1>

## 安装

```shell
$ composer require wored/yitiao-sdk -vvv
```

## 使用
```php
<?php

use \Wored\YitiaoSdk\YitiaoSdk;

$config = [
  'thirdPartyId'  => '***********',
  'rsaPrivateKey' => '***********************************',
  "rootUrl"       => 'https://open.yit.com/apigw/m.api',
];

// 实例化一条sdk
$yitiao = new YitiaoSdk($config);

```
> 按付款时间查询时间段内的所有订单，最多查询30天的订单
```php
<?php
   $ret = $yitiao->request('logisticsOpenApi.getOrderByPeriod', [
       'searchOrderParam' => [
           'startDate' => '2020-07-21 00:00:00',//付款开始时间
           'endDate'   => '2020-07-28 00:00:00',//付款结束时间
           'lastId'    => 0,//本次查询大于此id的订单，首次查询传0
           'size'      => 200,//本次查询数量，最大200条
           'status'    => 'WAIT_DELIVERY',//订单状态, 不想指定状态时为空或null CANCEL 已取消, CONFIRMED 已确认, SIGNED 已签收, STOCK_OUT 已发货, WAIT_DELIVERY 待发货
       ]
   ]);
```
> 根据订单商品id确认订单已下载
```php
<?php
    $ret = $yitiao->request('logisticsOpenApi.confirmDownload', [
        'ids' => [1]
    ]);
```
> 查询未下载过的待发货订单，每次最多返回200条订单数据，当返回条数不足200条时说明没有更多的未下载的待发货订单
```php
<?php
   $ret = $yitiao->request('logisticsOpenApi.getUnDownloadedPendingDeliveryOrder');
```
> 查询订单id大于lastId，且未下载过的待发货订单，每次最多返回200条订单数据，当返回条数不足200条时说明没有更多的未下载的待发货订单
```php
<?php
   $ret = $yitiao->request('logisticsOpenApi.getUnDownloadedPendingDeliveryOrderByLastId',[
       'lastId'=>224513
   ]);
```

> 根据一条sku发货 (单次发货最多100条记录)
```php
<?php
   $ret = $yitiao->request('logisticsOpenApi.sendLogisticsByItemId',[
       'logisticsEntities'=>[
           [//商品发货信息列表
            'subOrderNo'=>'218393554-0001',//一条订单编号
            'itemId'=>'23683375',//一条sku
            'logisticsCode'=>'3103402192494',//物流单号
            'companyName'=>'YUNDA',//物流公司 BAISHI 百世, BANMA 斑马物流, CHENGGUANGKUAIDI 程光, DEBANG 德邦快递/德邦物流, ECMS 易客满, EMS EMS, EMSINTERNATIONAL EMS-国际件, EPANEX 泛捷国际, EWE EWE全球, FAHUOSHANGFAHUO 其他物流, HUITONG 汇通, JD 京东, JIUYESCM 九曳供应链, KYEXPRESS 跨越, LIANBANGKUAIDI 联邦, LTEXP 乐天, NANJINGSHENGBANG 晟邦, NSF 新顺丰（NSF）, POST 邮政快递, QEXPRESS 易达通, RRS 日日顺, SF 顺丰, SHENTONG 申通, SZKKE 京广, TIANTIAN 天天, UBONEX 优邦速运, UEQ UEQ, WANXIANGWULIU 万象, WHEREEXPRESS 威盛快递, YOUSHUWULIU 优速, YOUZHENGGUONEI 邮政包裹/平邮, YT 圆通, YUNDA 韵达, ZHIMAKAIMEN 芝麻开门, ZHUANYUNSIFANG 转运四方, ZT 中通
           ]
       ]
   ]);
```
> 根据供应商sku发货 (单次发货最多100条记录)
```php
<?php
   $ret = $yitiao->request('logisticsOpenApi.sendLogisticsByVendorSkuCode',[
       'logisticsEntities'=>[
           [//商品发货信息列表
            'subOrderNo'=>'218393554-0001',//一条订单编号
            'vendorSkuCode'=>'090205035204X',//供应商sku
            'logisticsCode'=>'3103402192494',//物流单号
            'companyName'=>'YUNDA',//物流公司 BAISHI 百世, BANMA 斑马物流, CHENGGUANGKUAIDI 程光, DEBANG 德邦快递/德邦物流, ECMS 易客满, EMS EMS, EMSINTERNATIONAL EMS-国际件, EPANEX 泛捷国际, EWE EWE全球, FAHUOSHANGFAHUO 其他物流, HUITONG 汇通, JD 京东, JIUYESCM 九曳供应链, KYEXPRESS 跨越, LIANBANGKUAIDI 联邦, LTEXP 乐天, NANJINGSHENGBANG 晟邦, NSF 新顺丰（NSF）, POST 邮政快递, QEXPRESS 易达通, RRS 日日顺, SF 顺丰, SHENTONG 申通, SZKKE 京广, TIANTIAN 天天, UBONEX 优邦速运, UEQ UEQ, WANXIANGWULIU 万象, WHEREEXPRESS 威盛快递, YOUSHUWULIU 优速, YOUZHENGGUONEI 邮政包裹/平邮, YT 圆通, YUNDA 韵达, ZHIMAKAIMEN 芝麻开门, ZHUANYUNSIFANG 转运四方, ZT 中通
           ]
       ]
   ]);
```
## License

MIT