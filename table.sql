CREATE TABLE Identity(
    Id varchar(255) PRIMARY KEY,
    Secret Text not null
);

create table IdentityRole(
    Id varchar(255) primary key,
    Roles text not null
);

create table IdentityEmail(
    Id varchar(255) primary key,
    Email text not null
);