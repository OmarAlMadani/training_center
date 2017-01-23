DELIMITER $$

DROP SCHEMA IF EXISTS training_center $$
CREATE SCHEMA IF NOT EXISTS training_center DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci $$
USE training_center $$

CREATE  TABLE IF NOT EXISTS training_center.person (
  person_id INT(11) NOT NULL AUTO_INCREMENT ,
  first_name VARCHAR(45) NOT NULL ,
  last_name VARCHAR(45) NOT NULL ,
  address VARCHAR(45) NOT NULL ,
  zip_code VARCHAR(5) NOT NULL ,
  town VARCHAR(45) NOT NULL ,
  email VARCHAR(45) NOT NULL ,
  mobile_phone VARCHAR(10) NOT NULL ,
  phone VARCHAR(10) NULL DEFAULT NULL ,
  is_trainer TINYINT(1) NOT NULL DEFAULT false ,
  is_admin TINYINT(1) NOT NULL DEFAULT false ,
  password VARCHAR(45) NOT NULL ,
  picture_location VARCHAR(45) NULL DEFAULT NULL ,
  created_at DATETIME NOT NULL ,
  confirmed_at DATETIME NULL DEFAULT NULL ,
  confirmation_token VARCHAR(45) NULL DEFAULT NULL ,
  renew_password_token VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (person_id) ,
  UNIQUE INDEX un_person_email (email ASC) ,
  UNIQUE INDEX un_person_contact (first_name ASC, last_name ASC, address ASC, zip_code ASC, town ASC, mobile_phone ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$

CREATE  TABLE IF NOT EXISTS training_center.class (
  class_id INT(11) NOT NULL AUTO_INCREMENT ,
  name VARCHAR(45) NOT NULL ,
  PRIMARY KEY (class_id) ,
  UNIQUE INDEX un_class_name (name ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$

CREATE  TABLE IF NOT EXISTS training_center.class_member (
  person_id INT(11) NOT NULL ,
  class_id INT(11) NOT NULL ,
  INDEX fk_class_member_member (person_id ASC) ,
  INDEX fk_class_member_class (class_id ASC) ,
  PRIMARY KEY (person_id, class_id) ,
  CONSTRAINT fk_class_member_member
    FOREIGN KEY (person_id )
    REFERENCES training_center.person (person_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_class_member_class
    FOREIGN KEY (class_id )
    REFERENCES training_center.class (class_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$

CREATE  TABLE IF NOT EXISTS training_center.project (
  project_id INT(11) NOT NULL AUTO_INCREMENT ,
  owner_id INT(11) NOT NULL ,
  class_id INT(11) NOT NULL ,
  title VARCHAR(255) NOT NULL ,
  created_at DATETIME NOT NULL DEFAULT NOW() ,
  deadline DATETIME NOT NULL ,
  subject VARCHAR(1024) NOT NULL ,
  PRIMARY KEY (project_id) ,
  INDEX fk_project_member (owner_id ASC) ,
  INDEX fk_project_class (class_id ASC) ,
  CONSTRAINT fk_project_member
    FOREIGN KEY (owner_id )
    REFERENCES training_center.person (person_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_project_class
    FOREIGN KEY (class_id )
    REFERENCES training_center.class (class_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$


CREATE  TABLE IF NOT EXISTS training_center.team (
  team_id INT(11) NOT NULL AUTO_INCREMENT ,
  project_id INT(11) NOT NULL ,
  owner_id INT(11) NOT NULL ,
  created_at DATETIME NOT NULL ,
  summary VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (team_id) ,
  INDEX fk_team_project (project_id ASC) ,
  INDEX fk_team_member (owner_id ASC) ,
  CONSTRAINT fk_team_project
    FOREIGN KEY (project_id )
    REFERENCES training_center.project (project_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_team_member
    FOREIGN KEY (owner_id )
    REFERENCES training_center.person (person_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$



CREATE  TABLE IF NOT EXISTS training_center.document (

  document_id INT NOT NULL AUTO_INCREMENT ,
  author_id INT NOT NULL ,
  team_id INT NOT NULL ,
  location VARCHAR(45) NOT NULL ,
  created_at DATETIME NOT NULL ,
  updated_at DATETIME NULL ,
  content VARCHAR(45) NULL ,
  PRIMARY KEY (document_id) ,
  INDEX fk_document_member (author_id ASC) ,
  INDEX fk_document_team (team_id ASC) ,
  CONSTRAINT fk_document_member
    FOREIGN KEY (author_id )
    REFERENCES training_center.person (person_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_document_team
    FOREIGN KEY (team_id )
    REFERENCES training_center.team (team_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$

CREATE  TABLE IF NOT EXISTS training_center.team_member (
  team_id INT(11) NOT NULL ,
  student_id INT(11) NOT NULL ,
  INDEX fk_team_member_team (team_id ASC) ,
  INDEX fk_team_member_person (student_id ASC) ,
  PRIMARY KEY (team_id, student_id) ,
  CONSTRAINT fk_team_member_team
    FOREIGN KEY (team_id )
    REFERENCES training_center.team (team_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_team_member_person
    FOREIGN KEY (student_id )
    REFERENCES training_center.person (person_id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci $$


CREATE TRIGGER `DeleteClassMember` BEFORE DELETE ON `class`
 FOR EACH ROW DELETE FROM `class_member` WHERE (`class_id` = OLD.`class_id`)
$$

CREATE TRIGGER `CreateAtDocument` BEFORE Insert ON `document`
 FOR EACH ROW SET new.`created_at` = NOW()
$$

CREATE TRIGGER `UpdateAtDocument` BEFORE Update ON `document`
 FOR EACH ROW SET new.`updated_at` = NOW()
$$

CREATE TRIGGER `CreateAtPerson` BEFORE INSERT ON `person`
 FOR EACH ROW SET new.`created_at` = NOW()
$$

CREATE TRIGGER `DeleteFromClass` BEFORE DELETE ON `person`
 FOR EACH ROW DELETE FROM `class_member` WHERE (`person_id` = OLD.`person_id`)
$$

CREATE TRIGGER `DeleteFromTeam` BEFORE DELETE ON `person`
 FOR EACH ROW DELETE FROM `Team_member` WHERE (`person_id` = OLD.`person_id`)
$$

CREATE TRIGGER `CreatedAt` BEFORE INSERT ON `project`
 FOR EACH ROW SET new.`created_at` = NOW()
$$

CREATE TRIGGER `CreationDate` BEFORE INSERT ON `team`
 FOR EACH ROW SET new.`created_at` = NOW()
$$

CREATE TRIGGER `DeleteMember` BEFORE DELETE ON `team`
 FOR EACH ROW DELETE FROM `team_member` WHERE (`team_id` = OLD.`team_id`)
$$




DROP PROCEDURE IF EXISTS training_center_reset $$

CREATE PROCEDURE training_center_reset()
BEGIN
	INSERT INTO person (person_id, first_name, last_name, address, zip_code, town, email, mobile_phone, is_trainer, is_admin, password, created_at) VALUES
	(1,'Dupont','Pont', 'france', '75001', 'paris', 'dupont@gmail.com', '0775456781', false, false, 'helloworld', '2005-12-23'),
	(2,'Tintin','Tin', 'france', '67101', 'strasbourg', 'tintin@gmail.com', '0767891510', false, false, 'hihellobonjour', '2003-12-03'),
	(3,'Haddock','Dock', 'france', '68300', 'colmar', 'haddock@gmail.com', '0615752358', false, false, 'mercithanks', '2012-03-22'),
	(4,'Castafiore','Fiore', 'france', '43200', 'rennes', 'fiore@gmail.com', '0458752365', false, false, 'abcd123', '2015-02-23'),
	(5,'Haribo','Ribo', 'spain', '12345', 'valencia', 'germany@gmail.com', '0875511213', false, false, 'germany123', '2016-02-01'),
	(6,'Milka','Ka', 'UK', '23312', 'london', 'milka@gmail.com', '0182739209', false, false, '123uk', '2013-05-01'),
	(7,'Lu','U', 'UK', '23411', 'cardif', 'cardif@gmail.com', '0257456045', false, false, 'falsefalse123', '2011-01-30'),
	(8,'Bonmaman','Man', 'Germany', '54500', 'berlin', 'Bonmaman@gmail.com', '1234567891', false, false, 'tartelove', '2016-11-14'),
	(9,'Kinder','Der', 'vietnam', '54100', 'saigon', 'kinder@gmail.com', '0234123442', false, false, 'chocolate', '2015-11-11'),
	(10,'Cheetos','Tos', 'france', '45870', 'marseille', 'cheetos@gmail.com', '1096040607', false, false, 'snackgood', '2011-11-11'),
	(11,'Ben','Cohrn', 'USA', '56291', 'LA', 'ben@gmail.com', '0569874521', true, false, 'ihaventbeentthere', '2012-12-12'),
	(12,'Jerry','Greenfield', 'USA', '56291', 'LA', 'jerry@gmail.com', '0796456325', false, true, 'chickenlover', '2014-11-14') ;

	INSERT INTO class (class_id, name) VALUES
	(1, 'Java'),
	(2, 'Web') ;

	INSERT INTO project (project_id, owner_id, class_id, title, created_at, deadline, subject) VALUES
	(1, 10, 1, 'java_programming', '2016-12-10', '2017-01-26', 'game'),
	(2, 1, 2, 'web_programming', '2016-12-14', '2017-01-18', 'pokemon_center');

	INSERT INTO class_member (person_id, class_id) VALUES
	(10,1),
	(9,1),
	(8,1),
	(7,1),
	(6,1),
	(5,1),
	(4,2),
	(3,2),
	(2,2),
	(11,2),
	(12,2),
	(1,2) ;

	INSERT INTO team (team_id, project_id, owner_id, created_at, summary) VALUES
	(1,1,10,'2016-12-09','cheer up'),
	(2,2,1,'2016-12-13','too hard') ;

	INSERT INTO document (document_id, author_id, team_id, location,content, created_at, updated_at) VALUES
	(1, 10, 1, 'paris','Thank you', '2016-12-15', '2016-12-16') ;

	INSERT INTO team_member (team_id, student_id) VALUES
	(1,10),
	(1,9),
	(1,8),
	(1,7),
	(1,6),
	(1,5),
	(2,4),
	(2,3),
	(2,2),
	(2,1),
	(2,11),
	(2,12) ;

	COMMIT ;


END $$

CALL training_center_reset();