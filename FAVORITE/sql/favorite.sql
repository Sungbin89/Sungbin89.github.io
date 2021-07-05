DROP TABLE IF EXISTS `favorite`;
CREATE TABLE `favorite`(
    `id` tinyint(4) NOT NULL AUTO_INCREMENT,
    `department` enum('공부용', '개인용', '업무용', '휴식용', '컴퓨터') NOT NULL,
    `title` char(20) NOT NULL,
    `user` char(20) NOT NULL,
    `introduction` text NOT NULL,
    `url` varchar(100) NOT NULL,
    `data` date NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_url` (`url`),
    KEY `idx_department` (`department`)
) ENGINE=MyISAM AUTO_INCREMENT=30;
INSERT INTO `favorite` VALUES (1, '개인용', '네이버', '관리자', '네이버 홈페이지', 'https://www.naver.com/', '2008-09-30');
INSERT INTO `favorite` VALUES (2, '공부용', 'Materila UI', '관리자', '색상 조합', 'https://www.materialui.co/', '2021-01-05');
INSERT INTO `favorite` VALUES (3, '업무용', 'PNGWING', '관리자', '누끼의 희망', 'https://www.pngwing.com/ko/', '2008-09-30');
INSERT INTO `favorite` VALUES (4, '휴식용', '와우인벤', '관리자', '와우 게임 가이드 페이지', 'http://wow.inven.co.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (5, '컴퓨터', '한국 펄사용자 모임', '관리자', '펄/정규식', 'http://www.perl.or.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (6, '개인용', '네이버', '관리자', '네이버 홈페이지', 'https://www.never.com/', '2008-09-30');
INSERT INTO `favorite` VALUES (7, '공부용', 'Materila UI', '관리자', '색상 조합', 'https://www.meterialui.co/', '2021-01-05');
INSERT INTO `favorite` VALUES (8, '업무용', 'PNGWING', '관리자', '누끼의 희망', 'https://www.pengwing.com/ko/', '2008-09-30');
INSERT INTO `favorite` VALUES (9, '휴식용', '와우인벤', '관리자', '와우 게임 가이드 페이지', 'http://w2w.inven.co.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (10, '컴퓨터', '한국 펄사용자 모임', '관리자', '펄/정규식', 'http://www.parl.or.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (11, '개인용', '네이버', '관리자', '네이버 홈페이지', 'https://www.navar.com/', '2008-09-30');
INSERT INTO `favorite` VALUES (12, '공부용', 'Materila UI', '관리자', '색상 조합', 'https://www.materielui.co/', '2021-01-05');
INSERT INTO `favorite` VALUES (13, '업무용', 'PNGWING', '관리자', '누끼의 희망', 'https://www.pngwang.com/ko/', '2008-09-30');
INSERT INTO `favorite` VALUES (14, '휴식용', '와우인벤', '관리자', '와우 게임 가이드 페이지', 'http://wo3.inven.co.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (15, '컴퓨터', '한국 펄사용자 모임', '관리자', '펄/정규식', 'http://www.peal.or.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (16, '개인용', '네이버', '관리자', '네이버 홈페이지', 'https://www.navel.com/', '2008-09-30');
INSERT INTO `favorite` VALUES (17, '공부용', 'Materila UI', '관리자', '색상 조합', 'https://www.maaterielui.co/', '2021-01-05');
INSERT INTO `favorite` VALUES (18, '업무용', 'PNGWING', '관리자', '누끼의 희망', 'https://www.pngwingg.com/ko/', '2008-09-30');
INSERT INTO `favorite` VALUES (19, '휴식용', '와우인벤', '관리자', '와우 게임 가이드 페이지', 'http://wow.iinven.co.kr/', '2008-09-30');
INSERT INTO `favorite` VALUES (20, '컴퓨터', '한국 펄사용자 모임', '관리자', '펄/정규식', 'http://www.perll.or.kr/', '2008-09-30');
