/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.32-MariaDB : Database - filipino_cookbook_api
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`filipino_cookbook_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `filipino_cookbook_api`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`category_id`,`category_name`) values 
(1,'Appetizer'),
(2,'Dessert'),
(3,'Grilled Dish'),
(4,'Main Dish'),
(5,'Noodle Dish'),
(6,'Soup'),
(7,'Vegetable Dish');

/*Table structure for table `food_ingredients` */

DROP TABLE IF EXISTS `food_ingredients`;

CREATE TABLE `food_ingredients` (
  `food_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY (`food_id`,`ingredient_id`),
  KEY `fk_food_ingredients_ingredient` (`ingredient_id`),
  CONSTRAINT `fk_food_ingredients_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `food_ingredients` */

insert  into `food_ingredients`(`food_id`,`ingredient_id`) values 
(0,1),
(0,2),
(0,3),
(1,4),
(1,14),
(1,18),
(1,26),
(1,44),
(1,54),
(1,64),
(2,28),
(2,32),
(2,47),
(2,49),
(2,57),
(2,60),
(2,61),
(3,2),
(3,3),
(3,23),
(3,31),
(3,41),
(3,42),
(3,57),
(4,13),
(4,25),
(4,26),
(4,27),
(4,29),
(4,37),
(4,40),
(5,15),
(5,17),
(5,26),
(5,40),
(5,45),
(5,53),
(6,7),
(6,23),
(6,39),
(6,53),
(6,56),
(6,57),
(6,61),
(7,15),
(7,16),
(7,17),
(7,21),
(7,26),
(7,27),
(7,40),
(7,53),
(8,12),
(8,26),
(8,36),
(8,40),
(8,45),
(8,48),
(8,50),
(8,62),
(9,6),
(9,12),
(9,14),
(9,26),
(9,40),
(9,48),
(9,62),
(10,9),
(10,11),
(10,12),
(10,14),
(10,26),
(10,40),
(10,52),
(10,54),
(11,12),
(11,18),
(11,22),
(11,26),
(11,30),
(11,40),
(11,55),
(12,4),
(12,18),
(12,26),
(12,44),
(12,46),
(12,51),
(13,1),
(13,10),
(13,13),
(13,26),
(13,27),
(13,35),
(13,64),
(14,5),
(14,8),
(14,9),
(14,19),
(14,40),
(14,43),
(14,44),
(15,20),
(15,24),
(15,33),
(15,34),
(15,38),
(15,58),
(15,59),
(15,63),
(16,1),
(16,2),
(16,3),
(24,2),
(24,4),
(24,5),
(25,1),
(25,2),
(25,3),
(27,6),
(27,11),
(27,14),
(28,6),
(28,11),
(28,14),
(30,6),
(30,11),
(30,14),
(31,6),
(31,11),
(31,14);

/*Table structure for table `foods` */

DROP TABLE IF EXISTS `foods`;

CREATE TABLE `foods` (
  `food_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `instructions` text NOT NULL,
  PRIMARY KEY (`food_id`),
  UNIQUE KEY `food_name` (`food_name`),
  KEY `fk_food_category` (`category_id`),
  KEY `fk_food_origin` (`origin_id`),
  CONSTRAINT `fk_food_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_food_origin` FOREIGN KEY (`origin_id`) REFERENCES `origins` (`origin_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `foods` */

insert  into `foods`(`food_id`,`food_name`,`category_id`,`origin_id`,`instructions`) values 
(1,'Adobo',4,4,'Marinate the meat with soy sauce, vinegar, garlic, bay leaves, and peppercorn. Simmer until the meat becomes tender and the sauce is reduced.'),
(2,'Sinigang',6,4,'Boil the meat or seafood with tomatoes. Add tamarind mix and vegetables, then simmer until cooked.'),
(3,'Kare-Kare',4,4,'Boil the meat until tender. Add peanut sauce, ground rice, and vegetables. Serve with bagoong.'),
(4,'Tinola',6,4,'Saute garlic, onion, and ginger. Add chicken and fish sauce. Pour water and simmer, then add papaya and malunggay.'),
(5,'Bicol Express',4,2,'Saute garlic and onion. Add pork, shrimp paste, coconut milk, and chili peppers. Simmer until the sauce thickens.'),
(6,'Pinakbet',7,3,'Saute tomato, garlic, and onion. Add vegetables and shrimp paste, then cook until vegetables are tender.'),
(7,'Laing',7,2,'Cook dried taro leaves in coconut milk with garlic, onion, ginger, chili, and shrimp paste until creamy.'),
(8,'Menudo',4,4,'Saute garlic and onion. Add pork and liver, then simmer with tomato sauce, potatoes, carrots, and raisins.'),
(9,'Afritada',4,4,'Saute garlic and onion. Add meat, tomato sauce, potatoes, carrots, and bell pepper. Simmer until cooked.'),
(10,'Pancit Canton',5,4,'Saute garlic, onion, meat, and shrimp. Add vegetables, soy sauce, and noodles. Cook until noodles are tender.'),
(11,'Lumpiang Shanghai',1,4,'Mix ground pork, vegetables, and egg. Wrap in spring roll wrappers and deep-fry until golden brown.'),
(12,'Lechon Kawali',4,4,'Boil pork belly with spices until tender. Dry the pork, then deep-fry until crispy.'),
(13,'Chicken Inasal',3,1,'Marinate chicken in calamansi, vinegar, garlic, ginger, and lemongrass. Grill while brushing with annatto oil.'),
(14,'Bulalo',6,4,'Boil beef shank and bone marrow until tender. Add corn and vegetables, then simmer before serving.'),
(15,'Halo-Halo',2,4,'Layer sweet ingredients in a glass. Add crushed ice, evaporated milk, leche flan, and ube ice cream.'),
(16,'Dinengdeng',3,4,'Boil vegetables with bagoong-based broth.'),
(24,'Pinapaitan',1,2,'Cook beef or goat innards with bile, ginger, garlic, and spices to create a bitter and savory soup.'),
(28,'Kansi',1,4,'Simmer beef shank with batwan fruit and vegetables until the meat is tender and the broth becomes flavorful.'),
(31,'Atchara',1,4,'Boil it for 30 minutes, then fry it');

/*Table structure for table `ingredients` */

DROP TABLE IF EXISTS `ingredients`;

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(150) NOT NULL,
  PRIMARY KEY (`ingredient_id`),
  UNIQUE KEY `ingredient_name` (`ingredient_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ingredients` */

insert  into `ingredients`(`ingredient_id`,`ingredient_name`) values 
(1,'Annatto oil'),
(2,'Bagoong'),
(3,'Banana blossom'),
(4,'Bay leaves'),
(5,'Beef shank'),
(6,'Bell pepper'),
(7,'Bitter melon'),
(8,'Bone marrow'),
(9,'Cabbage'),
(10,'Calamansi juice'),
(11,'Canton noodles'),
(12,'Carrots'),
(13,'Chicken'),
(14,'Chicken or pork'),
(15,'Chili peppers'),
(16,'Coconut cream'),
(17,'Coconut milk'),
(18,'Cooking oil'),
(19,'Corn'),
(20,'Crushed ice'),
(21,'Dried taro leaves'),
(22,'Egg'),
(23,'Eggplant'),
(24,'Evaporated milk'),
(25,'Fish sauce'),
(26,'Garlic'),
(27,'Ginger'),
(28,'Green chili'),
(29,'Green papaya'),
(30,'Ground pork'),
(31,'Ground rice'),
(32,'Kangkong'),
(33,'Kaong'),
(34,'Leche flan'),
(35,'Lemongrass'),
(36,'Liver'),
(37,'Malunggay leaves'),
(38,'Nata de coco'),
(39,'Okra'),
(40,'Onion'),
(41,'Oxtail or beef'),
(42,'Peanut sauce'),
(43,'Pechay'),
(44,'Peppercorn'),
(45,'Pork'),
(46,'Pork belly'),
(47,'Pork, shrimp, or fish'),
(48,'Potatoes'),
(49,'Radish'),
(50,'Raisins'),
(51,'Salt'),
(52,'Shrimp'),
(53,'Shrimp paste'),
(54,'Soy sauce'),
(55,'Spring roll wrapper'),
(56,'Squash'),
(57,'String beans'),
(58,'Sweet beans'),
(59,'Sweetened banana'),
(60,'Tamarind mix'),
(61,'Tomato'),
(62,'Tomato sauce'),
(63,'Ube ice cream'),
(64,'Vinegar');

/*Table structure for table `origins` */

DROP TABLE IF EXISTS `origins`;

CREATE TABLE `origins` (
  `origin_id` int(11) NOT NULL,
  `origin_name` varchar(100) NOT NULL,
  PRIMARY KEY (`origin_id`),
  UNIQUE KEY `origin_name` (`origin_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `origins` */

insert  into `origins`(`origin_id`,`origin_name`) values 
(1,'Bacolod'),
(2,'Bicol Region'),
(3,'Ilocos Region'),
(4,'Philippines');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
