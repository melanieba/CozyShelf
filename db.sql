-- SHOW DATABASES;
use sr_group7;

-- can change id size later if needed
create table Book(
book_id smallint auto_increment primary key,
book_title varchar(50) not null, 
author_last_name varchar(100) not null, 
author_first_name varchar(100), 
book_cover varchar(255), 
page_count smallint not null, 
book_rating smallint, 
current_progress smallint not null, 
book_description text
);

create table Note(
note_id smallint auto_increment primary key,
note_date date, 
note_time time, 
note_content tinytext, 
book_id smallint,
foreign key (book_id) references Book(book_id)
);

insert into Book (book_title, author_last_name, author_first_name, page_count, current_progress, book_description)
values ('The Great Gatsby', 'Fitzgerald', 'F. Scott', 180, 100, 'A classic novel about the American dream.');

insert into Note (note_date, note_time, note_content, book_id)
values (CURDATE(), CURTIME(), 'This quote really hit me.', 1);

show tables;
select * from Book;
select * from Note;

truncate table Note;
delete from Book where book_id=1;
alter table Book auto_increment = 1;