/*
 Navicat Premium Data Transfer

 Date: 30/03/2020 16:50:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for casbin_rule
-- ----------------------------
DROP TABLE IF EXISTS `casbin_rule`;
CREATE TABLE `casbin_rule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ptype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `v0` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of casbin_rule
-- ----------------------------
INSERT INTO `casbin_rule` VALUES (1, 'g', 'user:2', 'role:1', NULL, NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (2, 'p', 'role:1', '/login', 'POST', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (3, 'p', 'role:1', '/sys/users', 'POST', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (4, 'p', 'role:1', '/sys/roles', 'POST', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (5, 'p', 'role:1', '/sys/menus', 'POST', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (6, 'p', 'role:1', '/sys/resources', 'POST', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (7, 'p', 'role:1', '/permissions', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (8, 'p', 'role:1', '/roles', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (9, 'p', 'role:1', '/menus', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (10, 'p', 'role:1', '/resources', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (11, 'p', 'role:1', '/account', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (12, 'p', 'role:1', '/sys/users', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (13, 'p', 'role:1', '/sys/roles', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (14, 'p', 'role:1', '/sys/menus', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (15, 'p', 'role:1', '/sys/resources', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (16, 'p', 'role:1', '/account/password', 'PUT', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (17, 'p', 'role:1', '/sys/users/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (18, 'p', 'role:1', '/sys/users/*', 'PATCH', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (19, 'p', 'role:1', '/sys/users/*', 'DELETE', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (20, 'p', 'role:1', '/sys/roles/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (21, 'p', 'role:1', '/sys/roles/*', 'PATCH', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (22, 'p', 'role:1', '/sys/roles/*', 'DELETE', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (23, 'p', 'role:1', '/sys/menus/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (24, 'p', 'role:1', '/sys/menus/*', 'PATCH', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (25, 'p', 'role:1', '/sys/menus/*', 'DELETE', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (26, 'p', 'role:1', '/sys/resources/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (27, 'p', 'role:1', '/sys/resources/*', 'PATCH', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (28, 'p', 'role:1', '/sys/resources/*', 'DELETE', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (29, 'p', 'role:1', '/sys/userRoles/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (30, 'p', 'role:1', '/sys/userRoles/*', 'PATCH', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (31, 'p', 'role:1', '/sys/roleMenus/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (32, 'p', 'role:1', '/sys/roleMenus/*', 'PATCH', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (33, 'p', 'role:1', '/sys/roleResources/*', 'GET', NULL, NULL, NULL);
INSERT INTO `casbin_rule` VALUES (34, 'p', 'role:1', '/sys/roleResources/*', 'PATCH', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `seq` tinyint(4) NOT NULL DEFAULT 99 COMMENT '排序',
  `name` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1：菜单，2：按钮',
  `path` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前端路由路径 或者 url',
  `icon` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '只支持 mdi icon',
  `state` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:启用，0：未启用',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 0, 0, '首页', 1, '/home', 'home', 1, NULL, NULL);
INSERT INTO `menu` VALUES (2, 0, 0, '系统设置', 1, '/system', 'cog', 1, NULL, NULL);
INSERT INTO `menu` VALUES (3, 2, 0, '用户管理', 1, '/system/user', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (4, 3, 0, '查看', 2, 'user:query', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (5, 3, 0, '编辑', 2, 'user:edit', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (6, 3, 0, '角色分配', 2, 'user:setRole', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (7, 3, 0, '删除', 2, 'user:delete', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (8, 2, 0, '角色管理', 1, '/system/role', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (9, 8, 0, '查看', 2, 'role:query', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (10, 8, 0, '编辑', 2, 'role:edit', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (11, 8, 0, '菜单分配', 2, 'role:setMenu', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (12, 8, 0, '权限分配', 2, 'role:setResource', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (13, 8, 0, '删除', 2, 'role:delete', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (14, 2, 0, '菜单管理', 1, '/system/menu', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (16, 14, 0, '编辑', 2, 'menu:edit', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (17, 14, 0, '删除', 2, 'menu:delete', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (18, 2, 0, '资源管理', 1, '/system/resource', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (19, 18, 0, '查看', 2, 'resource:query', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (20, 18, 0, '编辑', 2, 'resource:edit', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (21, 18, 0, '删除', 2, 'resource:delete', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (23, 0, 0, '级联菜单', 1, '', 'roman-numeral-1', 1, NULL, NULL);
INSERT INTO `menu` VALUES (24, 23, 0, '二级菜单', 1, '', '', 1, NULL, NULL);
INSERT INTO `menu` VALUES (25, 24, 0, '三级菜单1', 1, '', 'roman-numeral-3', 1, NULL, NULL);
INSERT INTO `menu` VALUES (26, 24, 0, '三级菜单2', 1, '', 'roman-numeral-3', 1, NULL, NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2020_02_26_170945_create_user_table', 1);

-- ----------------------------
-- Table structure for resource
-- ----------------------------
DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '资源路径',
  `action` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '操作',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of resource
-- ----------------------------
INSERT INTO `resource` VALUES (1, '/login', 'POST', NULL, NULL);
INSERT INTO `resource` VALUES (2, '/sys/users', 'POST', NULL, NULL);
INSERT INTO `resource` VALUES (3, '/sys/roles', 'POST', NULL, NULL);
INSERT INTO `resource` VALUES (4, '/sys/menus', 'POST', NULL, NULL);
INSERT INTO `resource` VALUES (5, '/sys/resources', 'POST', NULL, NULL);
INSERT INTO `resource` VALUES (6, '/permissions', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (7, '/roles', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (8, '/menus', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (9, '/resources', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (10, '/account', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (11, '/sys/users', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (12, '/sys/roles', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (13, '/sys/menus', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (14, '/sys/resources', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (15, '/account/password', 'PUT', NULL, NULL);
INSERT INTO `resource` VALUES (16, '/sys/users/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (17, '/sys/users/*', 'PATCH', NULL, NULL);
INSERT INTO `resource` VALUES (18, '/sys/users/*', 'DELETE', NULL, NULL);
INSERT INTO `resource` VALUES (19, '/sys/roles/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (20, '/sys/roles/*', 'PATCH', NULL, NULL);
INSERT INTO `resource` VALUES (21, '/sys/roles/*', 'DELETE', NULL, NULL);
INSERT INTO `resource` VALUES (22, '/sys/menus/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (23, '/sys/menus/*', 'PATCH', NULL, NULL);
INSERT INTO `resource` VALUES (24, '/sys/menus/*', 'DELETE', NULL, NULL);
INSERT INTO `resource` VALUES (25, '/sys/resources/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (26, '/sys/resources/*', 'PATCH', NULL, NULL);
INSERT INTO `resource` VALUES (27, '/sys/resources/*', 'DELETE', NULL, NULL);
INSERT INTO `resource` VALUES (28, '/sys/userRoles/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (29, '/sys/userRoles/*', 'PATCH', NULL, NULL);
INSERT INTO `resource` VALUES (30, '/sys/roleMenus/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (31, '/sys/roleMenus/*', 'PATCH', NULL, NULL);
INSERT INTO `resource` VALUES (32, '/sys/roleResources/*', 'GET', NULL, NULL);
INSERT INTO `resource` VALUES (33, '/sys/roleResources/*', 'PATCH', NULL, NULL);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:启用，0：未启用',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, '超级管理员', 'administrator', '超级管理员', 1, NULL, NULL);
INSERT INTO `role` VALUES (2, '测试角色', 'test', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (3, 'test1', 'test1', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (4, 'test2', 'test2', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (5, 'test3', 'test3', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (6, 'test4', 'test4', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (7, 'test5', 'test5', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (8, 'test6', 'test6', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (9, 'test7', 'test7', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (10, 'test8', 'test8', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (11, 'test9', 'test9', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (12, 'test10', 'test10', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (13, 'test11', 'test11', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (14, 'test12', 'test12', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (15, 'test13', 'test13', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (16, 'test14', 'test14', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (17, 'test15', 'test15', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (18, 'test16', 'test16', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (19, 'test17', 'test17', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (20, 'test18', 'test18', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (21, 'test19', 'test19', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (22, 'test20', 'test20', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (23, 'test21', 'test21', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (24, 'test22', 'test22', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (25, 'test23', 'test23', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (26, 'test24', 'test24', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (27, 'test25', 'test25', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (28, 'test26', 'test26', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (29, 'test27', 'test27', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (30, 'test28', 'test28', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (31, 'test29', 'test29', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (32, 'test30', 'test30', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (33, 'test31', 'test31', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (34, 'test32', 'test32', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (35, 'test33', 'test33', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (36, 'test34', 'test34', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (37, 'test35', 'test35', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (38, 'test36', 'test36', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (39, 'test37', 'test37', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (40, 'test38', 'test38', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (41, 'test39', 'test39', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (42, 'test40', 'test40', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (43, 'test41', 'test41', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (44, 'test42', 'test42', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (45, 'test43', 'test43', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (46, 'test44', 'test44', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (47, 'test45', 'test45', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (48, 'test46', 'test46', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (49, 'test47', 'test47', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (50, 'test48', 'test48', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (51, 'test49', 'test49', '测试角色', 1, NULL, NULL);
INSERT INTO `role` VALUES (52, 'test50', 'test50', '测试角色', 1, NULL, NULL);

-- ----------------------------
-- Table structure for role_menu
-- ----------------------------
DROP TABLE IF EXISTS `role_menu`;
CREATE TABLE `role_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID',
  `is_dir` int(11) NOT NULL DEFAULT 0 COMMENT '是否目录节点',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_menu
-- ----------------------------
INSERT INTO `role_menu` VALUES (1, 1, 1, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (2, 1, 2, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (3, 1, 3, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (4, 1, 4, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (5, 1, 5, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (6, 1, 6, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (7, 1, 7, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (8, 1, 8, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (9, 1, 9, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (10, 1, 10, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (11, 1, 11, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (12, 1, 12, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (13, 1, 13, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (14, 1, 14, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (15, 1, 15, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (16, 1, 16, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (17, 1, 17, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (18, 1, 18, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (19, 1, 19, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (20, 1, 20, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (21, 1, 21, 0, NULL, NULL);
INSERT INTO `role_menu` VALUES (22, 1, 22, 0, NULL, NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:启用，0：未启用',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '$2y$10$WqrJrA2BPx9Z1GWTyy8j3erlEpiuWJ1SbvSaKzw1XUqi6NVwVOw2C', 1, NULL, '2020-03-30 15:38:17', NULL);
INSERT INTO `user` VALUES (2, 'test', '$2y$10$FJrPpI9PRGR2F.QAw7FyUO256wSMzOs7BA.by/oxNPjxiFMHoio56', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (3, 'test1', '$2y$10$RdJNyX9WxEFtRnP5tsmr1en8ZBV9foOXOtLEw0Z.ZyY7TohhC7FES', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (4, 'test2', '$2y$10$hjeWiCz5o9MqS9wO8rwrHezMSjfIB6x9/HXt9du3yRbiY8EH1/J.q', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (5, 'test3', '$2y$10$OmJubwmynwI6XAQxxrWX4ukAWuwxGNRrhhe80YbCB171w5CVnNiYO', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (6, 'test4', '$2y$10$woQ5FrZo7A7ujn/koOE58exdID6671a0G/y/bmGW.H4GeZWWforb.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (7, 'test5', '$2y$10$EzApSk9A2KRV5vW6GPP8N.i5V5jdtesQK28AL8ayHztyU7DEKL8I.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (8, 'test6', '$2y$10$J3qoR0mqcuemK96bgxIeX.d52Let/EQHCskKCY/whMS6eGKOYBPDK', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (9, 'test7', '$2y$10$SxwZ/0eAe575K8AuNS2aQ.DkT1ucajd7nbA4.vjbVix6FBuo2oDz.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (10, 'test8', '$2y$10$ey7j4mvlywVgpmg5KOCJ/uzQ4pr6JlhGvg5od3/4Klo33qo5zmIIW', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (11, 'test9', '$2y$10$G5olgBAtWlvu12ssVCPI.eWlJzEpRIW10ucukeyusJyDR74RRryXm', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (12, 'test10', '$2y$10$fyf57AxT67Grp8sZEtzTuucCKihhrhsfZhKUu.qC/nutvg2RJ7ZE.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (13, 'test11', '$2y$10$vi9.iD8NyHVMT.zxplk//ek19UUY.XMYl8Vz91swdYazjaYupu/bG', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (14, 'test12', '$2y$10$NpqLxjY1.pMgkjwuvVvtC.94S2XRciQnmz9o7N6e3hFEj6MfCaVya', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (15, 'test13', '$2y$10$vrs.LJRyvEAmCqusoTt/QOwrROrwBUcDa3n2.0i9OY37I/.FKYLky', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (16, 'test14', '$2y$10$MtB0pR3iyxj5nAtWf8JdB.Ft8CEnoclPKlfiKuw76sR.wzjG4hUuG', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (17, 'test15', '$2y$10$VIk5Yaulz34O1znKxoWssOpga/d6HjZ8j.REhMt0CegYjSoL7Kw5C', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (18, 'test16', '$2y$10$XKwCydpwTkbO4Z/sL5zh3OaDus64PgqWqYvtcRL8zW/IEiZQH2p4O', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (19, 'test17', '$2y$10$nQCu0b6DuOtWyUlqYkixQeWiOOO80hikpNQCEThOkTvO3CPmQnd.y', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (20, 'test18', '$2y$10$4vEjI1v19eqjx/e/aXTB1O4H7PbzJ0gHVugILxLIvV2huWcQ81vYa', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (21, 'test19', '$2y$10$E63chZG1sDyBaRNXsJ7tku74SrI06GZcIJg4C7Y5JLjGfumRAojcu', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (22, 'test20', '$2y$10$ugAeB.mbwuhRVruSJJXWdOHUVnTOGR6jJHfDzUffF3ZSwiINnoYs2', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (23, 'test21', '$2y$10$4wKFCSc0RDixCmENJ4GSLuHu7ExSUZo3xLdVZeRW68.aDG1DrpBKW', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (24, 'test22', '$2y$10$WJYA1C3JQQwFLSSPhAN2UelR2ALnGfpefsd7IYcqtGXLFAnLNSLka', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (25, 'test23', '$2y$10$Wuruzx8ZiJa3xFiBE2ObaOckfJhCqjv6BImG4TAG/PKKm874gSCee', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (26, 'test24', '$2y$10$d0C3epTLRO2Vu3JA0QkZ7uhNBlJw7V0kq.KepcEzyJrdWYD08eC7W', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (27, 'test25', '$2y$10$peUWTIcvth2MvjVtpY9L1eP7B34xaHSXXFptKGmoByYNylB7ifNE2', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (28, 'test26', '$2y$10$ZIdkefWu7130WjYe2te20.oKWzhLr2Y9VI1.2Ed77uumcoAlZ12NC', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (29, 'test27', '$2y$10$TI4OAx/Uh69b01CZhTwF6ONomNFV245llu8kQsjvsRxupb5bIJpo6', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (30, 'test28', '$2y$10$wMhWsPjt1b9mRJM7CVO.3OJkmw43reTotov3f9y9g5jobKhoAplmK', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (31, 'test29', '$2y$10$PnLUpfpY/8UZevU3Um8ucurrWS2hWinQEBNZKG16s5M0Z9C8DXCp2', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (32, 'test30', '$2y$10$WoRMX7ORFnP3YTqM.N6trOVjpT.PIGkzL/WntQRpklZJRHV44olZC', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (33, 'test31', '$2y$10$MVPqzch/pzHAmUoC5jaBVObXnzem3OfDRl1oL3zS7l7mX53ZlY.dq', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (34, 'test32', '$2y$10$QFJkTACXFEJzkeQ.ORGbjOszSe7nLbLRP7hpop41M9o/Y3QukLxsy', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (35, 'test33', '$2y$10$.0MnS/PHIwP73IY8gOYA.OEa1FHu2U1rTaIVCDO8BzLnEUOkYWPR2', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (36, 'test34', '$2y$10$91PnkywhMYKcYii6e8V8xupE1gfRgrU0b6cBxGZQuAcWP.X35lac.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (37, 'test35', '$2y$10$TCMO.jrk7c8JkT52UBGWT.Br4HMr1VewCobIFKfGb2702PUrvKVgy', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (38, 'test36', '$2y$10$qmgfrtF./MoTcRgu0cNQi.9byeCRdwW/TsLX99zcvZPy8OOian.u.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (39, 'test37', '$2y$10$atbMA8jBuyO7SgbfvPB8VOnpSzrFkmabDhPUbRoxLcmb50LMqT37u', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (40, 'test38', '$2y$10$DKKOjzjqmmVzFcWrA.G4UOQOAw8ZgUt.St0PZDYKtpOYIX/LSDqOS', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (41, 'test39', '$2y$10$/ThX0emf15lFFNTEHjAwZeVvkoGERUfkAYwhtJl0rU/yOFtrvkPCy', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (42, 'test40', '$2y$10$mDjtJZxTUJw7BRY9G4GYzuC1FOT9AvWc/XCX5bp8tb5V0/enCtNIC', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (43, 'test41', '$2y$10$kjIuR5JBboq7MXhhDI/cUeOkzhjybekxE5N6Y2xiMFElS3qxLQugq', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (44, 'test42', '$2y$10$X8cQMskz6crQNFfigcZ0budIONc1onSQ2nhUkdDbmqyXON2z1uWsS', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (45, 'test43', '$2y$10$6KKbeFeJmBAFTra2UInRPOp5VvrKTL.BZCa7nSOUHfuCi4dQn5C4C', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (46, 'test44', '$2y$10$GiTKfti4q34VvA5mYCDtC..RTRhcuoAK2wOeUcyXsrQR3aIWrjR86', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (47, 'test45', '$2y$10$GN4wonG9C9r7.pLZdeGAmeshCsqzQkKklDvnVRoLRzFD2lQDuALL2', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (48, 'test46', '$2y$10$5SEWm1tNKYfwPzJn9Dq/s.QV/gYTQbOGISMoiHWeqnVcMs3s4GVBW', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (49, 'test47', '$2y$10$TTAIfwBd34R.tq9e5XAqJu3WYC2L6HHeY7rkGXkK8EywSluu9OP/6', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (50, 'test48', '$2y$10$CMUwM/wym6cScyjA9HEot.dYRDyfOFv.JcMmj2d3zwroAtNSkGEX.', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (51, 'test49', '$2y$10$AveDFnxRqanQCdZid.rdxOCTdtoVKOoC6UhNmJJoZk8UoHAJibiYq', 1, NULL, NULL, NULL);
INSERT INTO `user` VALUES (52, 'test50', '$2y$10$MHbBmuE5rt76Ko5dbN3jbeKQ4BtEseGawwB2eV4tzRgLzCNPYO3Bm', 1, NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
