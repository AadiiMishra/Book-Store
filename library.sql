CREATE TABLE Books (
    BookID int PRIMARY KEY, 
    Title varchar(30), 
    PublisherName varchar(30)
);
CREATE TABLE Authors (
    BookID int,
    AuthorName varchar(30),
    FOREIGN KEY (BookID) REFERENCES Books(BookID)
);
CREATE TABLE Copies (
    BookID int,
    Genre varchar(40),
    No_Of_Copies int,
    FOREIGN KEY (BookID) REFERENCES Books(BookID)
);
insert into Books values
(101,'A passage to india','jaico'),
(102,'A revenue stamp','westland'),
(103,'Pinjar','penguin random'),
(104,'Tale of two cities','roli'),
(105,'Oliver Twist','rupa'),
(106,'Aadhe Adhure','rupa'),
(107,'Anand Math','jaico');
select* from Books;
insert into Authors values
(101,'E.M.Foster'),
(102,'Amrita Pritam'),
(103,'Amrita Pritam'),
(104,'Charles Darwin'),
(105,'charles Darwin'),
(106,'Mohan Rakesh'),
(107,'Bankim C chatarjee');
select* from Authors;
insert into Copies values
(101,'political fiction',5),
(102,'autobiography',3),
(103,'social novel',6),
(104,'historical fiction',2),
(105,'fiction',3),
(106,'Soap opera',9),
(107,'historical fiction',12);
select* from Copies;

SELECT b.*, a.AuthorName, c.Genre, c.No_Of_Copies
FROM Books b
INNER JOIN Authors a ON b.BookID = a.BookID
INNER JOIN Copies c ON b.BookID = c.BookID
WHERE b.BookID = 101;

