create table user (
	`id` int not null AUTO_INCREMENT,
	`user_name` varchar(50) not null,
	`password` varchar(50) not null,
	`email`  varchar(50) not null,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

create table post (
	`id` int not null AUTO_INCREMENT,
	`user_id` int not null,
	`title` varchar(150) not null,
	`content` text not null,
	`modification_date` timestamp not null DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	FOREIGN KEY(`user_id`) REFERENCES user(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE logged_user (
	`session_id` varchar(100) NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (`session_id`),
	FOREIGN KEY(`user_id`) REFERENCES user(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO user(`username`, `password`, `email`) VALUES
('user1', MD5('12345'), 'user1@mail.com'),
('user2', MD5('12345'), 'user2@mail.com');

INSERT INTO post(`user_id`, `title`, `content`) VALUES
(1, 'My first post!', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Etiam quis augue est. Donec erat orci, tristique et metus sit amet, pretium semper neque. 
In lobortis sem vel dui dapibus mattis. Donec posuere eros quis nisi hendrerit tristique. 
Maecenas sollicitudin est eget mi vulputate molestie. Aliquam ligula tellus, interdum vitae congue et, 
pellentesque vitae nisi. Morbi et ultrices urna, in rhoncus nisi. Maecenas magna mauris, feugiat quis lorem ac, 
consectetur ultrices nibh.</p><p>Aliquam eros risus, laoreet in scelerisque ac, congue nec magna. 
Pellentesque tempus consequat lacus luctus varius. Etiam auctor dolor sed tellus sollicitudin placerat. 
Morbi ut justo ex. In sem nulla, pretium in tincidunt eu, scelerisque et dui. In interdum euismod leo, 
vitae porttitor elit elementum ut. Cras congue massa finibus pulvinar laoreet. Aenean aliquam eros vitae 
ex finibus lobortis. Etiam nec ultrices lectus. Quisque ultricies lorem odio, eget vehicula risus pretium non. 
Sed sit amet nisi non tortor convallis.</p>'),
(2, 'My first post too!', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Etiam quis augue est. Donec erat orci, tristique et metus sit amet, pretium semper neque. 
In lobortis sem vel dui dapibus mattis. Donec posuere eros quis nisi hendrerit tristique. 
Maecenas sollicitudin est eget mi vulputate molestie. Aliquam ligula tellus, interdum vitae congue et, 
pellentesque vitae nisi. Morbi et ultrices urna, in rhoncus nisi. Maecenas magna mauris, feugiat quis lorem ac, 
consectetur ultrices nibh.</p><p>Aliquam eros risus, laoreet in scelerisque ac, congue nec magna. 
Pellentesque tempus consequat lacus luctus varius. Etiam auctor dolor sed tellus sollicitudin placerat. 
Morbi ut justo ex. In sem nulla, pretium in tincidunt eu, scelerisque et dui. In interdum euismod leo, 
vitae porttitor elit elementum ut. Cras congue massa finibus pulvinar laoreet. Aenean aliquam eros vitae 
ex finibus lobortis. Etiam nec ultrices lectus. Quisque ultricies lorem odio, eget vehicula risus pretium non. 
Sed sit amet nisi non tortor convallis.</p>');











