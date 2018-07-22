create table snowkeld_admin_Users(
    Email varchar(255) PRIMARY KEY,
    Secret varchar(255) NOT NULL
);

create table snowkeld_admin_Roles(
    Email varchar(255) PRIMARY KEY,
    Roles varchar(255)
);