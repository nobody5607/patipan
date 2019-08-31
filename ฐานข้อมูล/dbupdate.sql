/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : 127.0.0.1:3306
 Source Schema         : chanpan

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 31/07/2019 23:10:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dbupdate
-- ----------------------------
DROP TABLE IF EXISTS `dbupdate`;
CREATE TABLE `dbupdate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sql` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` int(1) DEFAULT NULL,
  `create_date` datetime(0) DEFAULT NULL,
  `create_by` bigint(20) DEFAULT NULL,
  `update_date` datetime(0) DEFAULT NULL,
  `update_by` bigint(20) DEFAULT NULL,
  `rstat` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dbupdate
-- ----------------------------
INSERT INTO `dbupdate` VALUES (1, 'CREAE TABLE systemlog', 'CREATE TABLE IF NOT EXISTS  `systemlog` (\r\n  `id` int(11) NOT NULL,\r\n  `logname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,\r\n  `logtype` int(1) DEFAULT NULL,\r\n  `logdetail` longtext COLLATE utf8_unicode_ci,\r\n  `rstat` int(1) DEFAULT NULL,\r\n  `create_by` bigint(20) DEFAULT NULL,\r\n  `create_date` datetime DEFAULT NULL,\r\n  `update_by` bigint(20) DEFAULT NULL,\r\n  `update_date` datetime DEFAULT NULL,\r\n  PRIMARY KEY (`id`)\r\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;', 0, '2019-07-31 22:36:55', 1, '2019-07-31 23:09:49', 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
