/*
 Navicat Premium Data Transfer

 Source Server         : LOCALE
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : travels

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 11/02/2021 13:17:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_tag` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES (1, 'Nice', 'FR');
INSERT INTO `city` VALUES (2, 'Grasse', 'FR');
INSERT INTO `city` VALUES (3, 'Cannes', 'FR');
INSERT INTO `city` VALUES (4, 'Nice Riquier', 'FR');
INSERT INTO `city` VALUES (5, 'Paris', 'FR');
INSERT INTO `city` VALUES (6, 'Londres', 'EN');
INSERT INTO `city` VALUES (7, 'New York JFK', 'US');
INSERT INTO `city` VALUES (8, 'Madrid', 'ES');
INSERT INTO `city` VALUES (9, 'Barcelone', 'ES');
INSERT INTO `city` VALUES (10, 'Stockholm', 'SE');
INSERT INTO `city` VALUES (11, 'Gerona Airport', 'ES');
INSERT INTO `city` VALUES (12, 'Hogwarts Castle', 'EN');

-- ----------------------------
-- Table structure for doctrine_migration_versions
-- ----------------------------
DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions`  (
  `version` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime(0) NULL DEFAULT NULL,
  `execution_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doctrine_migration_versions
-- ----------------------------
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20210209170607', '2021-02-09 17:06:17', 384);
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20210209175704', '2021-02-09 17:57:10', 78);

-- ----------------------------
-- Table structure for stage
-- ----------------------------
DROP TABLE IF EXISTS `stage`;
CREATE TABLE `stage`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `departure_id` int(11) NOT NULL,
  `arrival_id` int(11) NOT NULL,
  `number` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_date` datetime(0) NOT NULL,
  `arrival_date` datetime(0) NOT NULL,
  `seat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gate` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `baggage_drop` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_C27C9369C54C8C93`(`type_id`) USING BTREE,
  INDEX `IDX_C27C93697704ED06`(`departure_id`) USING BTREE,
  INDEX `IDX_C27C936962789708`(`arrival_id`) USING BTREE,
  CONSTRAINT `FK_C27C936962789708` FOREIGN KEY (`arrival_id`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_C27C93697704ED06` FOREIGN KEY (`departure_id`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_C27C9369C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stage
-- ----------------------------
INSERT INTO `stage` VALUES (1, 4, 2, 3, 'B1', '2021-02-09 18:30:00', '2021-02-09 19:20:00', NULL, NULL, NULL);
INSERT INTO `stage` VALUES (2, 2, 3, 4, 'TER-A', '2021-02-09 20:00:00', '2021-02-09 20:20:00', NULL, NULL, NULL);
INSERT INTO `stage` VALUES (3, 1, 1, 7, 'B3Z', '2021-02-10 19:53:00', '2021-02-11 19:53:00', NULL, NULL, '');
INSERT INTO `stage` VALUES (4, 4, 4, 1, 'B2', '2021-02-11 20:35:00', '2021-02-12 01:26:00', NULL, NULL, NULL);
INSERT INTO `stage` VALUES (5, 1, 1, 5, 'P455', '2021-02-12 20:41:00', '2021-02-13 20:41:00', '3A', '45B', NULL);
INSERT INTO `stage` VALUES (6, 1, 5, 6, 'P42', '2021-02-13 20:42:00', '2021-02-14 20:42:00', '96B', '12', '123');
INSERT INTO `stage` VALUES (7, 2, 6, 12, 'T9 3/4', '2021-02-13 20:43:00', '2021-02-14 20:43:00', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for travel
-- ----------------------------
DROP TABLE IF EXISTS `travel`;
CREATE TABLE `travel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of travel
-- ----------------------------
INSERT INTO `travel` VALUES (1, 'Londres', 2100, 1);
INSERT INTO `travel` VALUES (2, 'New York', 5100, 1);
INSERT INTO `travel` VALUES (3, 'Madrid', 1150, 1);
INSERT INTO `travel` VALUES (4, 'Test', 200, 0);
INSERT INTO `travel` VALUES (5, 'Metz', 10, 0);
INSERT INTO `travel` VALUES (6, 'Nancy', 50, 1);
INSERT INTO `travel` VALUES (7, 'Woippy', 3, 0);
INSERT INTO `travel` VALUES (8, 'dsfGSDFGd', 150, 1);
INSERT INTO `travel` VALUES (9, 'Saint Martin', 2450, 1);
INSERT INTO `travel` VALUES (10, 'Test 1', 10, 0);
INSERT INTO `travel` VALUES (11, 'Encore un test', 123, 0);

-- ----------------------------
-- Table structure for travel_stage
-- ----------------------------
DROP TABLE IF EXISTS `travel_stage`;
CREATE TABLE `travel_stage`  (
  `travel_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  PRIMARY KEY (`travel_id`, `stage_id`) USING BTREE,
  INDEX `IDX_6AD014DFECAB15B3`(`travel_id`) USING BTREE,
  INDEX `IDX_6AD014DF2298D193`(`stage_id`) USING BTREE,
  CONSTRAINT `FK_6AD014DF2298D193` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `FK_6AD014DFECAB15B3` FOREIGN KEY (`travel_id`) REFERENCES `travel` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of travel_stage
-- ----------------------------
INSERT INTO `travel_stage` VALUES (1, 1);
INSERT INTO `travel_stage` VALUES (1, 2);
INSERT INTO `travel_stage` VALUES (1, 4);
INSERT INTO `travel_stage` VALUES (1, 5);
INSERT INTO `travel_stage` VALUES (5, 6);
INSERT INTO `travel_stage` VALUES (5, 7);
INSERT INTO `travel_stage` VALUES (8, 2);
INSERT INTO `travel_stage` VALUES (8, 7);
INSERT INTO `travel_stage` VALUES (9, 3);

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES (1, 'Avion');
INSERT INTO `type` VALUES (2, 'Train');
INSERT INTO `type` VALUES (3, 'Voiture');
INSERT INTO `type` VALUES (4, 'Bus');

SET FOREIGN_KEY_CHECKS = 1;
