# Change the project folder name to:

```
abc-nepal-wp
```

# ABC Nepal TV - Transfer Setup Guide

This package contains a complete backup of the ABC Nepal TV WordPress website.

It includes:

- Complete WordPress database
- Complete WordPress installation
- All uploaded media
- All plugins
- All settings
- Complete custom theme

After following this guide, your website will be identical to the original.

---

# Requirements

- Docker Desktop installed
- Docker Compose installed

---

# Package Contents

```
abc-nepal-wp/

├── docker-compose.yml
├── db_data.tar.gz
├── wp_data.tar.gz
├── theme/
├── setup/
├── README.md
└── SETUP.md
```

---

# Step 1

Rename the project folder to:

```
abc-nepal-wp
```

Open Terminal inside the project folder.

Example:

```bash
cd ~/Desktop/abc-nepal-wp
```

---

# Step 2

Stop any existing containers for this project.

```bash
docker compose down
```

---

# Step 3

Check the existing Docker volumes.

```bash
docker volume ls
```

You should see volumes similar to:

```
abc-nepal-wp_db_data
abc-nepal-wp_wp_data
```

---

# Step 4

Delete the old Docker volumes.

```bash
docker volume rm abc-nepal-wp_db_data
docker volume rm abc-nepal-wp_wp_data
```

Verify they are removed:

```bash
docker volume ls
```

---

# Step 5

Restore the MySQL volume directly from the backup.

Docker will automatically recreate the volume if it does not exist.

```bash
docker run --rm \
-v abc-nepal-wp_db_data:/volume \
-v "$PWD":/backup \
ubuntu \
bash -c "tar xzf /backup/db_data.tar.gz -C /volume"
```

---

# Step 6

Restore the WordPress volume.

```bash
docker run --rm \
-v abc-nepal-wp_wp_data:/volume \
-v "$PWD":/backup \
ubuntu \
bash -c "tar xzf /backup/wp_data.tar.gz -C /volume"
```

---

# Step 7

Start the website.

```bash
docker compose up -d
```

Docker will automatically detect the restored volumes and start the website using the restored data.

---

# Access

Website

```
http://localhost:8080
```

WordPress Admin

```
http://localhost:8080/wp-admin
```

phpMyAdmin

```
http://localhost:8081
```

---

# What Is Restored?

Everything.

- WordPress Core
- Complete MySQL Database
- Posts
- Pages
- Categories
- Users
- Passwords
- Plugins
- Plugin Settings
- Media Library
- Uploaded Files
- Menus
- Widgets
- Comments
- Theme Configuration
- WordPress Settings
- Custom Code

The restored website will be identical to the original.

---

# Notes

- If the Ubuntu Docker image is not already installed, Docker will automatically download it the first time you run the restore commands. This is normal.
- The Ubuntu container is temporary and is removed automatically after extracting the backup files.
- The restore commands automatically recreate the Docker volumes if they do not already exist.
- Make sure the project folder is named **abc-nepal-wp** so the Docker volume names match the commands in this guide.