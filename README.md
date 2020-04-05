
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

###
Perform these steps, and it should be working!
##

<details>

#### Build Tools:

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

<details>

#### Update `php.ini`

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

<details>

#### Build MySQL Database

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

<details>

#### Update `users` Table

<summary>Expand</summary>

- Either delete the original rows or modify them to your own accord
	- If creating new rows, `uuid` is set to Auto-Increment - no need to enter a value
	- `name` will be whatever you want the user's username to be
	- `hash` will be the hashed version of the user's password
		- I included my easy hashing tool with the rest of the project in `includes/tools/hash_gen.php`. You'll have to include it manually if you want to use it, or create your own HTML that includes it.
	- `role` will either `user` or `admin`
		- As of now, the only difference is the ability to delete a project. Admins will have more access soon.

</details>
