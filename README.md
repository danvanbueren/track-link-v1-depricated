
# TrackLink

A data-sharing tool to help musicians collaborate with each other.

## Overview

* Built with PHP & MySQL, along with various JavaScript libraries.
* [Bootstrap](http://getbootstrap.com) is used as a UI/UX foundation.
* Session-based interaction. All keys are hashed before they are stored in their table.

## Installation

1. Place all files and folders from `htdocs` in your own active directory.
2. Ensure your servers/services will support this specific project - [see below](#build-tools).
3. Update php.ini - [see below](#update-phpini).
4. Set up MySQL tables - [see below](#build-mysql-database).
5. Update `users` table with new login information - [see below](#update-users-table).
6. Update `settings.config` in root directory with applicable information - [see below](#update-settingsconfig).

###
Perform these steps, and it should be working!
##

#### Build Tools:

<details>

<summary>Expand</summary>

Here's a list of the external tools I used when developing this project.

| Service    | Version |
|------------|---------|
| MAMP       | 4.1.1   |
| Apache     | 2.2.31  |
| PHP        | 7.1.1   |
| MySQL      | 5.6.35  |
| phpMyAdmin | 4.6.5.2 |

</details>

#### Update `php.ini`

<details>

<summary>Expand</summary>

- Your php.ini will likely need to be updated to allow for larger file uploads, I recommend these values:

###### LINE 373

```php
post_max_size = 256M
```

###### LINE 481

```php
upload_max_filesize = 256M
```

</details>

#### Build MySQL Database

<details>

<summary>Expand</summary>

- Update username & password for MySQL server & in `includes/dbh.inc.php`.
- Create `tracklink` database, then run this SQL:

```sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `tracklink`
--

CREATE TABLE `projectfiles` (
  `uuid` int(11) NOT NULL,
  `proj_uuid` int(11) NOT NULL,
  `user_uuid` int(11) NOT NULL,
  `role` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `filetype` tinytext NOT NULL,
  `time_uploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `projects` (
  `uuid` int(11) NOT NULL,
  `user_uuid` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `lyrics` text NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `uuid` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `hash` tinytext NOT NULL,
  `role` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`uuid`, `name`, `hash`, `role`) VALUES
(1, 'admin-username', 'hashed-password', 'admin'),
(2, 'user-username', 'hashed-password', 'user');

ALTER TABLE `projectfiles`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `stem_id` (`uuid`);

ALTER TABLE `projects`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `uid` (`uuid`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `uuid` (`uuid`);

ALTER TABLE `projectfiles`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

ALTER TABLE `projects`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `users`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
```

</details>

#### Update `users` Table

<details>

<summary>Expand</summary>

- Either delete the original rows or modify them to your own accord
	- If creating new rows, `uuid` is set to Auto-Increment - no need to enter a value
	- `name` will be whatever you want the user's username to be
	- `hash` will be the hashed version of the user's password
		- You can use my easy hashing tool from its repo at [/php-hash-gen](https://github.com/danvanbueren/php-hash-gen)
	- `role` will either `user` or `admin`
		- As of now, the only difference is the ability to delete a project. Admins will have more access soon.

</details>

#### Update `settings.config`

<details>

<summary>Expand</summary>

By default, the settings configuration will be incomplete and will prevent your instance from connecting to your database correctly. Your band/group name will also be an eyesore if left unchanged and should serve as a reminder in the event you do not see this step.
- Below is the default `settings.config`:
```json
{
  "group-name":"--> UPDATE 'SETTINGS.CONFIG' <--",
  "sql-server-name":"localhost",
  "sql-username":"--> UPDATE ME <--",
  "sql-password":"--> UPDATE ME <--",
  "sql-database":"tracklink"
} 
```
- Change the value of `group-name` to your band/group name
  - i.e. `"group-name":"Queen",`
- Change the value of `sql-server-name` to the path to your MySQL server (if applicable)
  - If you are hosting your MySQL server on the same system as your webserver, leaving the value `localhost` will generally work. You should only change this if you are hosting your MySQL server on a different system
    - i.e. `"sql-server-name":"192.168.0.27",`
- Change the value of `sql-username` to your MySQL username
  - i.e. `"sql-username":"root",`
- Change the value of `sql-password` to your MySQL password
  - i.e. `"sql-password":"c&aA1$%Cx8y5@7iR",`
- Change the value of `sql-database` to your MySQL database name (if applicable)
  - The default value `tracklink` is already correct if you have been following this installation guide. Only change this if you decide to name your database something else.
    - i.e. `"sql-database":"queen-tracklink-db"`
  - Warning: Changing anything EXCEPT for the database name will break this program in it's default state. Even if you decide to use a different name for your database, all other SQL must mirror the previously mentioned format or you will run into a multitude of errors. Changing anything EXCEPT for the database name would require you to go through the whole program and edit all SQL queries - yikes!

</details>

