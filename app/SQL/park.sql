USE park

--用户表
CREATE TABLE `park_user`(
  `userId` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `realName` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名 ',
  `passWord` varchar(128) NOT NULL DEFAULT '' COMMENT '密码',
  `mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `cardType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '证件类型：1 身份证，2 军官证，3 护照',
  `cardId` varchar(64) NOT NULL DEFAULT '' COMMENT '证件号',
  `stat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 正常 1 标记删除',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updateTime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=100000000 DEFAULT CHARSET=utf8 COMMENT '用户信息';

--地址表
CREATE TABLE `park_loation` (
  `locId` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省级名称',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市级名称',
  `district` varchar(30) NOT NULL DEFAULT '' COMMENT '区域名称',
  `location` varchar(100) NOT NULL DEFAULT '' COMMENT '具体街道',
  `desc` varchar(30) NOT NULL DEFAULT '' COMMENT '详细说明',
  `stat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 1删除',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updateTime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`locId`)
) ENGINE=InnoDB AUTO_INCREMENT=100000000 DEFAULT CHARSET=utf8  COMMENT '详细地址';

--车位信息表
CREATE TABLE `park_space` (
  `spaceId` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `locId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '地址id',
  `address`  varchar(128) NOT NULL DEFAULT '' COMMENT '地址',
  `desc`  varchar(4096) NOT NULL DEFAULT '' COMMENT '描述',
  `longitude` varchar(20) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude`  varchar(20) NOT NULL DEFAULT '' COMMENT '纬度',
  `exact` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0精确 1模糊',
  `facePic` varchar(64) NOT NULL DEFAULT '' COMMENT '首图',
  `picList` varchar(128) NOT NULL DEFAULT '' COMMENT '图片List',
  `type`  tinyint(1) NOT NULL DEFAULT '0' COMMENT '0共享 1短租 2交易',
  `price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '租金/分',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未使用 1已锁定 2使用中',
  `startTime` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `endTime` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `remark` varchar(512) NOT NULL DEFAULT '' COMMENT '备注',
  `stat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 1删除',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updateTime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`spaceId`),
  KEY `id_type` (`type`),
  KEY `idx_lat_lon` (`longitude`,`latitude`)
) ENGINE=InnoDB AUTO_INCREMENT=100000000 DEFAULT CHARSET=utf8  COMMENT '车位信息表';

--订单表
CREATE TABLE  `park_order` (
  `orderId` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单Id',
  `sellerId` int(10) unsigned NOT NULL COMMENT '卖家ID ',
  `userId`  bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `spaceId` int(10) unsigned NOT NULL COMMENT '停车位Id ',
  `orderTime` int(11) NOT NULL DEFAULT '0' COMMENT '下单时间',
  `orderStatus` tinyint(4) NOT NULL COMMENT '订单状态',
  `payStatus` tinyint(4) NOT NULL COMMENT '支付状态',
  `payTime` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `finishTime` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `parkPrice`  int(10) unsigned NOT NULL COMMENT '租金/分',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0共享 1短租',
  `stat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标记是否删除 {0:正常, 1:已删除}。',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updateTime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`orderId`),
  KEY `idx_userid` (`userId`),
  KEY `idx_sellerId` (`sellerId`),
  KEY `idx_spaceId` (`spaceId`),
  KEY `idx_orderTime` (`orderTime`)
) ENGINE=InnoDB AUTO_INCREMENT=1000000000000 DEFAULT CHARSET=utf8 COMMENT='订单';


--博文表

CREATE TABLE `park_blog` (
  `blogId` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(512) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(4096) NOT NULL DEFAULT '' COMMENT '内容',
  `userId`   bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `tag` varchar(512) NOT NULL DEFAULT '' COMMENT '标签List',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞量',
  `browse` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `picList` varchar(128) NOT NULL DEFAULT '' COMMENT '图片List',
  `localtion` varchar(512) NOT NULL DEFAULT '' COMMENT '位置',
  `stat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标记是否删除 {0:正常, 1:已删除}。',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updateTime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
   PRIMARY KEY (`blogId`),
   KEY `idx_userid` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=100000000 DEFAULT CHARSET=utf8  COMMENT '博文表';


--评论表
CREATE TABLE `park_comment` (
  `comId` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容',
  `blogId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '博文ID',
  `userId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `replyComId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复评论ID',
  `stat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标记是否删除 {0:正常, 1:已删除}。',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updateTime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`comId`),
  KEY `idx_blogId` (`blogId`)
) ENGINE=InnoDB AUTO_INCREMENT=100000000 DEFAULT CHARSET=utf8  COMMENT '评论';




