/*
Navicat MySQL Data Transfer

Source Server         : locahost
Source Server Version : 50714
Source Host           : 127.0.0.1:3306
Source Database       : lms

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-09-22 14:05:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lms_action
-- ----------------------------
DROP TABLE IF EXISTS `lms_action`;
CREATE TABLE `lms_action` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `aname` varchar(20) NOT NULL DEFAULT '' COMMENT '路由名称',
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '路由信息,例如/main/user/list',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 非菜单 1 一级菜单 2 二级菜单',
  `first_menu` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '若未二级菜单，此处存所属的一级菜单id',
  `menusort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '菜单排序，大值排前列',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `aname` (`aname`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_action
-- ----------------------------
INSERT INTO `lms_action` VALUES ('1', '编辑用户', '/main/user/edit', '0', '-1', '0', '2017-09-21 21:51:28');
INSERT INTO `lms_action` VALUES ('2', '用户列表', '/main/user/list', '2', '56', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('3', '编辑角色', '/main/role/edit', '0', '-1', '0', '2017-09-21 21:51:28');
INSERT INTO `lms_action` VALUES ('4', '角色列表', '/main/role/list', '2', '56', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('5', '编辑路由', '/main/action/edit', '0', '-1', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('6', '路由列表', '/main/action/list', '2', '56', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('68', '用户列表ajax', '/main/user/listajax', '0', '0', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('49', '删除用户', '/main/user/del', '0', '-1', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('55', '用户首页', '/main/user/index', '0', '-1', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('56', '系统功能', '/main/index', '1', '-1', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('57', '删除路由', '/main/action/del', '0', '-1', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('64', '路由列表ajax', '/main/action/listajax', '0', '0', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('65', '角色列表ajax', '/main/role/listajax', '0', '0', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('66', '删除角色', '/main/role/del', '0', '0', '0', '2017-09-21 16:12:36');
INSERT INTO `lms_action` VALUES ('69', '欢迎页', '/site/index', '1', '0', '100', '2017-09-21 16:12:36');

-- ----------------------------
-- Table structure for lms_book
-- ----------------------------
DROP TABLE IF EXISTS `lms_book`;
CREATE TABLE `lms_book` (
  `bookcode` varchar(30) NOT NULL DEFAULT '0' COMMENT '图书编号',
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图书id',
  `typeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图书类型',
  `price` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `stroge` int(10) unsigned NOT NULL COMMENT '库存',
  `in_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `location` varchar(30) NOT NULL DEFAULT '' COMMENT '位置',
  `page` int(10) unsigned NOT NULL COMMENT '页数',
  `update_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bid`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_book
-- ----------------------------

-- ----------------------------
-- Table structure for lms_book_type
-- ----------------------------
DROP TABLE IF EXISTS `lms_book_type`;
CREATE TABLE `lms_book_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '图书分类id',
  `name` varchar(30) NOT NULL COMMENT '图书分类名称',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_book_type
-- ----------------------------

-- ----------------------------
-- Table structure for lms_borrow
-- ----------------------------
DROP TABLE IF EXISTS `lms_borrow`;
CREATE TABLE `lms_borrow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '借阅信息id',
  `readerid` int(10) unsigned NOT NULL COMMENT '借阅者id',
  `bookid` int(10) unsigned NOT NULL COMMENT '图书id',
  `borrow_time` datetime NOT NULL,
  `back_time` datetime NOT NULL,
  `is_back` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已还',
  `update_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `readerid` (`readerid`),
  KEY `bookid` (`bookid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_borrow
-- ----------------------------

-- ----------------------------
-- Table structure for lms_info
-- ----------------------------
DROP TABLE IF EXISTS `lms_info`;
CREATE TABLE `lms_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图书馆信息id',
  `name` varchar(50) NOT NULL COMMENT '图书馆名称',
  `create_date` date DEFAULT NULL COMMENT '创建时间',
  `introduce` text COMMENT '介绍',
  `address` varchar(50) DEFAULT NULL COMMENT '地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_info
-- ----------------------------

-- ----------------------------
-- Table structure for lms_reader
-- ----------------------------
DROP TABLE IF EXISTS `lms_reader`;
CREATE TABLE `lms_reader` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '借阅者id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '借阅者姓名',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '借阅者编号',
  `idcard` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `birthday` date NOT NULL COMMENT '生日',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `upda_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `typeid` int(10) NOT NULL COMMENT '借阅者类型id',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id(关联user表）',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_reader
-- ----------------------------

-- ----------------------------
-- Table structure for lms_reader_type
-- ----------------------------
DROP TABLE IF EXISTS `lms_reader_type`;
CREATE TABLE `lms_reader_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '借阅者类型id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '借阅者类型名称',
  `update_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_reader_type
-- ----------------------------

-- ----------------------------
-- Table structure for lms_role
-- ----------------------------
DROP TABLE IF EXISTS `lms_role`;
CREATE TABLE `lms_role` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `rname` varchar(20) NOT NULL DEFAULT '' COMMENT '角色名称',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`),
  UNIQUE KEY `name` (`rname`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_role
-- ----------------------------
INSERT INTO `lms_role` VALUES ('1', '管理员', '2017-09-21 21:51:28');
INSERT INTO `lms_role` VALUES ('2', '借阅者', '2017-09-21 16:11:51');

-- ----------------------------
-- Table structure for lms_role_action
-- ----------------------------
DROP TABLE IF EXISTS `lms_role_action`;
CREATE TABLE `lms_role_action` (
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '路由id',
  `menu_pos` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '无用',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`,`aid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_role_action
-- ----------------------------

-- ----------------------------
-- Table structure for lms_user
-- ----------------------------
DROP TABLE IF EXISTS `lms_user`;
CREATE TABLE `lms_user` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `uname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名称',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `pwd` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`uname`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lms_user
-- ----------------------------
INSERT INTO `lms_user` VALUES ('1', 'admin', 'admin@lms.com', 'd41d8cd98f00b204e9800998ecf8427e', '1', '2017-09-21 21:51:28');
