# WP Post Queue

This plugin is designed to help you manage and schedule your blog posts efficiently. It allows you to configure the number of posts to publish per day, set start and end times for publishing, and pause or resume the queue as needed.

Unlike scheduled posts, queued posts are not published at user specific time, but rather based on the queue settings.

This allows for maintaining a steady flow of content, such as regularly publishing blog posts or social media content, without needing to manually schedule each post.

## Features

- **Automatic Scheduling**: Automatically publish queued posts a specified number of times per day.
- **Time Configuration**: Set start and end times for publishing posts.
- **Queue Management**: Pause and resume the queue with ease.
- **Shuffle Queue**: Randomize the order of posts in the queue.

## Installation

### From ZIP

1. Download the plugin and upload it to your WordPress site's `wp-content/plugins` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the settings panel to configure your post queue settings.

### From GitHub

1. Clone the repository in your WordPress site's `wp-content/plugins` directory.
2. Run `npm install` to install the dependencies.
3. Run `npm run build` to build the plugin.
4. Activate the plugin through the 'Plugins' menu in WordPress.
5. Navigate to the settings panel to configure your post queue settings.

## Usage

- Access the settings panel from the WordPress admin dashboard by going to Posts > Queue.
- Configure the number of posts to publish per day and set the start and end times.
- Use the "Pause Queue" button to temporarily stop the queue.
- Use the "Resume Queue" button to restart the queue.
- Click "Shuffle Queue" to randomize the order of posts.
- Add new posts to the queue by selecting "Queued" under the post status and visibility dropdown in the editor.

## Development

### Prerequisites

- Node.js and npm
- WordPress development environment, such as [Studio](https://developer.wordpress.com/studio/).

### Building the Plugin

Run the following commands to build the plugin:

```bash
npm install
npm run build
```

### Running in Development Mode

To start the development server, use:

```bash
npm run start
```

### Creating a Plugin ZIP

To create a plugin ZIP file, use:

```bash
npm run plugin-zip
```

### Running Tests

If neccessary, a Docker setup is available for the WordPress tests, since they require MySQL, unlike Studio which uses SQLite.

After installing and starting Docker, run the following command to start the containers:
```bash
docker-compose up -d
```

Add this to your shell config (.bashrc, .zshrc):

```bash
export WP_TESTS_DIR="/tmp/wordpress-tests-lib"
```

To run the tests, follow these steps:

1. **Install the WordPress Test Suite**: You need to install the WordPress test suite. You can do this by running the following command in your terminal:

    ```bash
    bash bin/install-wp-tests.sh <db_name> <db_user> <db_pass> <db_host> <wp_version>
    ```

    Replace `<db_name>`, `<db_user>`, `<db_pass>`, `<db_host>`, and `<wp_version>` with your database name, database user, database password, database host, and WordPress version, respectively. If you've used the defaults it will be something like:

	```bash
	bash bin/install-wp-tests.sh wordpress_test wp_test password 127.0.0.1:3306
	```

2. **Run the Tests**: Once the test suite is installed, you can run the tests using:

    ```bash
    vendor/bin/phpunit 
    ```

3. **Troubleshooting**: If you encounter any issues, ensure that your database credentials are correct and that the database is accessible. Also, verify that the WordPress version specified is available.

### Linting & Code Standards

This project uses a combination of ESLint, Stylelint, and PHP_CodeSniffer to enforce WordPress code standards.

#### JavaScript

To lint JavaScript files, we use ESLint. You can run the linter with the following command:

```bash
npm run lint:scripts
```

To automatically fix some of the issues, you can use:

```bash
npm run lint:fix:scripts
```

#### CSS

To lint CSS files, we use Stylelint. You can run the linter with the following command:

```bash
npm run lint:styles
```

To automatically fix some of the issues, you can use:

```bash
npm run lint:fix:styles
```

#### PHP

For PHP files, we use PHP_CodeSniffer. You can run the linter with the following command:

```bash
composer run lint:php
```

To automatically fix some of the issues, you can use:

```bash
composer run format:php
```
