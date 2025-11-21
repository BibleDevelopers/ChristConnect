<div id="top">

<!-- HEADER STYLE: CLASSIC -->
<div align="left">
# ChristConnect
    
<img width="900" height="900" alt="logoNew" src="https://github.com/user-attachments/assets/c54b18cc-bfe7-4d05-8435-3f5bd04f47de" />

<em>Empowering Faith, Connecting Souls, Inspiring Growth</em>

<!-- BADGES -->
<img src="https://img.shields.io/github/license/unknownman77/ChristConnect?style=flat&logo=opensourceinitiative&logoColor=white&color=0080ff" alt="license">
<img src="https://img.shields.io/github/last-commit/unknownman77/ChristConnect?style=flat&logo=git&logoColor=white&color=0080ff" alt="last-commit">
<img src="https://img.shields.io/github/languages/top/unknownman77/ChristConnect?style=flat&color=0080ff" alt="repo-top-language">
<img src="https://img.shields.io/github/languages/count/unknownman77/ChristConnect?style=flat&color=0080ff" alt="repo-language-count">

<em>Built with the tools and technologies:</em>

<img src="https://img.shields.io/badge/JSON-000000.svg?style=flat&logo=JSON&logoColor=white" alt="JSON">
<img src="https://img.shields.io/badge/Markdown-000000.svg?style=flat&logo=Markdown&logoColor=white" alt="Markdown">
<img src="https://img.shields.io/badge/npm-CB3837.svg?style=flat&logo=npm&logoColor=white" alt="npm">
<img src="https://img.shields.io/badge/Composer-885630.svg?style=flat&logo=Composer&logoColor=white" alt="Composer">
<img src="https://img.shields.io/badge/JavaScript-F7DF1E.svg?style=flat&logo=JavaScript&logoColor=black" alt="JavaScript">
<br>
<img src="https://img.shields.io/badge/Docker-2496ED.svg?style=flat&logo=Docker&logoColor=white" alt="Docker">
<img src="https://img.shields.io/badge/XML-005FAD.svg?style=flat&logo=XML&logoColor=white" alt="XML">
<img src="https://img.shields.io/badge/PHP-777BB4.svg?style=flat&logo=PHP&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/Vite-646CFF.svg?style=flat&logo=Vite&logoColor=white" alt="Vite">
<img src="https://img.shields.io/badge/Axios-5A29E4.svg?style=flat&logo=Axios&logoColor=white" alt="Axios">

</div>
<br>

---

## 📄 Table of Contents

- [Overview](#-overview)
- [Getting Started](#-getting-started)
    - [Prerequisites](#-prerequisites)
    - [Installation](#-installation)
    - [Usage](#-usage)
    - [Testing](#-testing)
- [Features](#-features)
- [Project Structure](#-project-structure)
    - [Project Index](#-project-index)
- [Contributing](#-contributing)
- [License](#-license)

---

## ✨ Overview

ChristConnect is a comprehensive developer tool designed to facilitate the deployment and management of a Laravel-based biblical application within a containerized environment. It combines robust backend configurations with seamless biblical data handling, empowering developers to build secure, scalable, and maintainable web platforms. The core features include:

- 🛠️ **Docker Multi-Stage Build:** Streamlines asset compilation, dependency management, and deployment for efficient workflows.
- 📜 **Biblical Data Validation & Conversion:** Scripts to verify, normalize, and organize scripture texts for accurate retrieval and search.
- 🔗 **API Integrations:** External API access for biblical texts, search, and content management, ensuring dynamic and reliable data access.
- 🔒 **Secure User & Admin Management:** Role-based access control, email verification, and session handling for a safe user experience.
- ⚙️ **Modular Architecture:** Frontend and backend components designed for flexibility, real-time updates, and easy customization.

---

## 📌 Features

|      | Component       | Details                                                                                     |
| :--- | :-------------- | :------------------------------------------------------------------------------------------ |
| ⚙️  | **Architecture**  | <ul><li>Laravel MVC framework</li><li>RESTful API endpoints</li><li>Blade templating for views</li></ul> |
| 🔩 | **Code Quality**  | <ul><li>Adheres to PSR standards</li><li>Uses PHP namespaces and autoloading</li><li>Includes PHPDoc comments</li></ul> |
| 📄 | **Documentation** | <ul><li>Contains `how_to_run.txt` with setup instructions</li><li>Docker-related docs: Dockerfile, docker-compose.yml</li><li>README.md likely present for overview</li></ul> |
| 🔌 | **Integrations**  | <ul><li>Docker for containerization</li><li>Composer for PHP dependencies</li><li>npm with package.json for JS dependencies</li><li>Laravel Vite plugin for asset bundling</li><li>Tailwind CSS for styling</li><li>Axios for HTTP requests</li></ul> |
| 🧩 | **Modularity**    | <ul><li>Laravel service providers and facades</li><li>Separate config files (`default.conf`)</li><li>Component-based frontend with Tailwind and Vite</li></ul> |
| 🧪 | **Testing**       | <ul><li>PHPUnit configured (`phpunit.xml`)</li><li>Likely unit and feature tests</li></ul> |
| ⚡️  | **Performance**   | <ul><li>Uses Vite for fast asset bundling</li><li>Dockerized environment for consistent deployment</li></ul> |
| 🛡️ | **Security**      | <ul><li>Laravel security features (CSRF, validation)</li><li>Docker container isolation</li></ul> |
| 📦 | **Dependencies**  | <ul><li>PHP dependencies via `composer.json` and `composer.lock`</li><li>JavaScript dependencies via `package.json`</li></ul> |

---

## 📁 Project Structure

```sh
└── ChristConnect/
    ├── Dockerfile
    ├── Dockerfile.txt
    ├── Dockerfile.unknown
    ├── HOW_TO_RUN.txt
    ├── README.md
    ├── app
    │   ├── Console
    │   ├── Http
    │   ├── Mail
    │   ├── Models
    │   ├── Providers
    │   ├── Service
    │   └── Services
    ├── artisan
    ├── bootstrap
    │   ├── app.php
    │   ├── cache
    │   └── providers.php
    ├── composer.json
    ├── composer.lock
    ├── config
    │   ├── app.php
    │   ├── auth.php
    │   ├── cache.php
    │   ├── database.php
    │   ├── filesystems.php
    │   ├── logging.php
    │   ├── mail.php
    │   ├── queue.php
    │   ├── services.php
    │   └── session.php
    ├── database
    │   ├── .gitignore
    │   ├── factories
    │   ├── migrations
    │   └── seeders
    ├── docker-compose.prod.yml
    ├── docker-compose.yml
    ├── nginx
    │   └── conf.d
    ├── package-lock.json
    ├── package.json
    ├── phpunit.xml
    ├── resources
    │   ├── css
    │   ├── images
    │   ├── js
    │   └── views
    ├── routes
    │   ├── console.php
    │   └── web.php
    ├── scripts
    │   ├── check_bible.php
    │   ├── list_books_order.php
    │   └── tb_text_to_json.php
    ├── storage
    │   ├── app
    │   ├── framework
    │   └── logs
    └── vite.config.js
```

---

### 📑 Project Index

<details open>
	<summary><b><code>CHRISTCONNECT/</code></b></summary>
	<!-- __root__ Submodule -->
	<details>
		<summary><b>__root__</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ __root__</b></code>
			<table style='width: 100%; border-collapse: collapse;'>
			<thead>
				<tr style='background-color: #f8f9fa;'>
					<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
					<th style='text-align: left; padding: 8px;'>Summary</th>
				</tr>
			</thead>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/Dockerfile'>Dockerfile</a></b></td>
					<td style='padding: 8px;'>- Defines a multi-stage Docker configuration to build and deploy a web application<br>- It compiles frontend assets using Node.js, installs PHP dependencies with Composer, and sets up a PHP-FPM environment optimized for production<br>- This setup ensures efficient asset management and a streamlined, secure deployment process within a cohesive architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/composer.json'>composer.json</a></b></td>
					<td style='padding: 8px;'>- Defines the core project configuration for a Laravel-based web application, specifying dependencies, autoloading, and setup scripts<br>- Facilitates environment setup, database migrations, and development workflows, ensuring a consistent foundation for building and maintaining the applications features within a modular and scalable architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/HOW_TO_RUN.txt'>HOW_TO_RUN.txt</a></b></td>
					<td style='padding: 8px;'>- Provides guidance for deploying and running ChristConnect, a Laravel-based web application, by detailing setup, development, and production procedures<br>- Ensures users can initialize the environment, configure databases, and launch both frontend and backend servers, facilitating seamless local development and scalable deployment through Docker<br>- The instructions support maintaining a robust, secure, and efficient architecture for the entire codebase.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/docker-compose.prod.yml'>docker-compose.prod.yml</a></b></td>
					<td style='padding: 8px;'>- Defines the production deployment environment for a Laravel-based application, orchestrating services including the application backend, web server, and database<br>- Facilitates containerized setup with consistent configurations, enabling scalable, isolated, and reliable deployment of the full stack architecture<br>- Ensures seamless integration and communication among components within a unified Docker Compose network.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/docker-compose.yml'>docker-compose.yml</a></b></td>
					<td style='padding: 8px;'>- Defines the containerized environment for a Laravel application, orchestrating services such as the application server and web server<br>- Facilitates seamless development and deployment by managing container dependencies, network configurations, and volume mappings, ensuring consistent operation across different environments<br>- This setup streamlines the integration of application code with web server configurations, supporting efficient local development and testing workflows.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/README.md'>README.md</a></b></td>
					<td style='padding: 8px;'>- Defines the core structure and configuration for a Laravel-based web application, establishing the foundation for routing, database interactions, background processing, and real-time event broadcasting<br>- Serves as the central component that integrates various modules, enabling scalable, maintainable, and feature-rich development aligned with Laravel’s architecture principles.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/Dockerfile.txt'>Dockerfile.txt</a></b></td>
					<td style='padding: 8px;'>- Sets up a PHP 8.2 environment optimized for development and deployment by installing necessary system libraries, PHP extensions, and dependencies<br>- Configures the web server to run the application using Laravels artisan serve command, ensuring the application is accessible on port 8000<br>- Facilitates containerized deployment, streamlining the development workflow and environment consistency across systems.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/Dockerfile.unknown'>Dockerfile.unknown</a></b></td>
					<td style='padding: 8px;'>- Sets up the PHP 8.2-FPM environment for the application, ensuring all necessary dependencies and extensions are installed<br>- Facilitates the deployment of a scalable web service by preparing the runtime environment, managing dependencies with Composer, and establishing the working directory for the application code within the container<br>- This foundational configuration supports the overall architectures focus on efficient, maintainable PHP-based web services.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/phpunit.xml'>phpunit.xml</a></b></td>
					<td style='padding: 8px;'>- Defines the testing configuration for the project, specifying the structure and environment settings for executing unit and feature tests<br>- Facilitates reliable, isolated testing of application components within an in-memory database environment, ensuring code quality and stability across the entire codebase architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/package.json'>package.json</a></b></td>
					<td style='padding: 8px;'>- Defines project dependencies and scripts for building and developing a modern web application utilizing Vite, Tailwind CSS, and Axios<br>- It orchestrates the setup and execution environment, ensuring streamlined development workflows and optimized production builds within a modular architecture<br>- This configuration underpins the frontend tooling, enabling efficient asset compilation and live development features.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/vite.config.js'>vite.config.js</a></b></td>
					<td style='padding: 8px;'>- Configures the development environment by integrating Vite with Laravel, Tailwind CSS, and project assets<br>- It streamlines asset bundling, enabling efficient compilation and live reloading for CSS and JavaScript resources<br>- This setup ensures a cohesive build process within the overall architecture, supporting rapid development and seamless updates across the web applications frontend components.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/artisan'>artisan</a></b></td>
					<td style='padding: 8px;'>- Facilitates execution of Laravel CLI commands by bootstrapping the application environment and delegating command handling<br>- Integrates the core framework components to enable command-line interactions, such as migrations, scheduling, and maintenance tasks, ensuring smooth operation and management of the Laravel-based system within the project architecture.</td>
				</tr>
			</table>
		</blockquote>
	</details>
	<!-- config Submodule -->
	<details>
		<summary><b>config</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ config</b></code>
			<table style='width: 100%; border-collapse: collapse;'>
			<thead>
				<tr style='background-color: #f8f9fa;'>
					<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
					<th style='text-align: left; padding: 8px;'>Summary</th>
				</tr>
			</thead>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/cache.php'>cache.php</a></b></td>
					<td style='padding: 8px;'>- Defines cache configuration settings to manage multiple caching strategies within the application<br>- It specifies default cache store, various cache drivers (such as database, Redis, Memcached, and file), and their connection details<br>- Facilitates efficient data retrieval and storage, ensuring optimal performance and scalability across different environments by centralizing cache management.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/app.php'>app.php</a></b></td>
					<td style='padding: 8px;'>- Defines core application settings such as name, environment, debugging, URL, timezone, locale, encryption keys, and maintenance mode configuration<br>- Serves as the foundational configuration hub that orchestrates how the Laravel application initializes and operates across different environments, ensuring consistent behavior and security throughout the codebase.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/queue.php'>queue.php</a></b></td>
					<td style='padding: 8px;'>- Defines queue configuration settings for managing background job processing across multiple backends such as database, Redis, SQS, Beanstalkd, and synchronous execution<br>- Facilitates flexible, reliable, and scalable task execution, ensuring proper handling of job retries, batching, and failure logging within the applications architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/logging.php'>logging.php</a></b></td>
					<td style='padding: 8px;'>- Defines the applications logging architecture by configuring multiple log channels for capturing, routing, and managing log messages across various destinations such as files, Slack, syslog, and external services<br>- Facilitates flexible, scalable, and environment-specific logging strategies to monitor application behavior, troubleshoot issues, and ensure operational visibility within the overall system architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/filesystems.php'>filesystems.php</a></b></td>
					<td style='padding: 8px;'>- Defines the applications filesystem configuration, enabling flexible storage options across local and cloud environments<br>- It specifies default and multiple disk setups, including local storage for private and public files, as well as Amazon S3 integration<br>- Additionally, it manages symbolic links for seamless public access to stored assets, supporting scalable and organized file management within the architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/session.php'>session.php</a></b></td>
					<td style='padding: 8px;'>- Defines session management configuration for the application, specifying how user sessions are stored, secured, and maintained across requests<br>- It ensures consistent session handling by setting parameters such as storage driver, lifetime, security options, and cookie behavior, thereby supporting reliable user authentication and state persistence within the overall architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/mail.php'>mail.php</a></b></td>
					<td style='padding: 8px;'>- Defines email configuration settings, enabling the application to send notifications and transactional messages through various supported mail transport methods<br>- It centralizes email delivery options, including SMTP, SES, Postmark, and logging, while establishing default sender details<br>- This setup ensures flexible, reliable, and consistent email communication across the entire system architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/services.php'>services.php</a></b></td>
					<td style='padding: 8px;'>- Defines configuration settings for integrating third-party services such as email providers (Postmark, Resend, AWS SES) and communication tools (Slack)<br>- Facilitates secure and standardized access to external APIs across the application, supporting seamless communication, notifications, and email delivery within the overall system architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/database.php'>database.php</a></b></td>
					<td style='padding: 8px;'>- Defines database and Redis connection configurations for the application, enabling seamless integration with multiple database systems such as SQLite, MySQL, MariaDB, PostgreSQL, and SQL Server<br>- Facilitates flexible environment-specific settings, manages migration tracking, and supports caching mechanisms, ensuring robust data storage, retrieval, and synchronization across different deployment environments within the overall architecture.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/config/auth.php'>auth.php</a></b></td>
					<td style='padding: 8px;'>- Defines authentication configuration, establishing default guards, user providers, and password reset policies to manage user authentication and security within the application<br>- Facilitates flexible, secure user login, registration, and password recovery processes aligned with the overall system architecture<br>- Ensures consistent authentication behavior across different parts of the application, supporting scalable and maintainable user management.</td>
				</tr>
			</table>
		</blockquote>
	</details>
	<!-- scripts Submodule -->
	<details>
		<summary><b>scripts</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ scripts</b></code>
			<table style='width: 100%; border-collapse: collapse;'>
			<thead>
				<tr style='background-color: #f8f9fa;'>
					<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
					<th style='text-align: left; padding: 8px;'>Summary</th>
				</tr>
			</thead>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/scripts/check_bible.php'>check_bible.php</a></b></td>
					<td style='padding: 8px;'>- Provides a script to verify the integrity and contents of the Bible verses database, including total counts and sample entries<br>- It supports data validation and quality assurance within the applications architecture, ensuring the Bible verses are correctly stored and accessible for features that rely on accurate biblical text data.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/scripts/list_books_order.php'>list_books_order.php</a></b></td>
					<td style='padding: 8px;'>- Provides an ordered list of biblical books with their maximum chapter counts, facilitating navigation or referencing within the entire scripture collection<br>- It consolidates data from the database, sorts books according to a predefined sequence, and outputs a structured overview aligned with the canonical order, supporting features like chapter indexing or study tools across the project.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/scripts/tb_text_to_json.php'>tb_text_to_json.php</a></b></td>
					<td style='padding: 8px;'>- Converts structured biblical text from plaintext into a normalized JSON format, facilitating seamless integration and querying within the broader data architecture<br>- This script standardizes book names and preserves verse references, enabling efficient data ingestion for applications such as search, analysis, or content management across the project’s biblical data ecosystem.</td>
				</tr>
			</table>
		</blockquote>
	</details>
	<!-- routes Submodule -->
	<details>
		<summary><b>routes</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ routes</b></code>
			<table style='width: 100%; border-collapse: collapse;'>
			<thead>
				<tr style='background-color: #f8f9fa;'>
					<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
					<th style='text-align: left; padding: 8px;'>Summary</th>
				</tr>
			</thead>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/routes/console.php'>console.php</a></b></td>
					<td style='padding: 8px;'>- Defines a custom Artisan command to display an inspiring quote, enhancing developer engagement and productivity<br>- Integrates into the Laravel console interface, contributing to the applications command-line tools ecosystem by providing motivational prompts for users during development or maintenance tasks.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/routes/web.php'>web.php</a></b></td>
					<td style='padding: 8px;'>- Defines application routes for user authentication, content management, donations, and administrative functions, orchestrating navigation and access control across the platform<br>- Facilitates user registration, login, email verification, and profile updates while managing religious content, donations, and administrative oversight, ensuring secure and organized flow within the overall architecture.</td>
				</tr>
			</table>
		</blockquote>
	</details>
	<!-- bootstrap Submodule -->
	<details>
		<summary><b>bootstrap</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ bootstrap</b></code>
			<table style='width: 100%; border-collapse: collapse;'>
			<thead>
				<tr style='background-color: #f8f9fa;'>
					<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
					<th style='text-align: left; padding: 8px;'>Summary</th>
				</tr>
			</thead>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/bootstrap/app.php'>app.php</a></b></td>
					<td style='padding: 8px;'>- Initialize the core application environment by configuring routing, middleware, and exception handling within the framework<br>- Establishes essential services and request handling mechanisms, ensuring the application is properly set up to process web requests, commands, and health checks, forming the foundation for the entire codebase’s operational structure.</td>
				</tr>
				<tr style='border-bottom: 1px solid #eee;'>
					<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/bootstrap/providers.php'>providers.php</a></b></td>
					<td style='padding: 8px;'>- Registers application service providers to ensure core functionalities and dependencies are properly initialized during the bootstrap process, facilitating seamless integration and configuration within the overall architecture<br>- This setup supports modularity and extensibility by centralizing provider registration, enabling the application to efficiently manage services and dependencies across the codebase.</td>
				</tr>
			</table>
		</blockquote>
	</details>
	<!-- app Submodule -->
	<details>
		<summary><b>app</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ app</b></code>
			<!-- Console Submodule -->
			<details>
				<summary><b>Console</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Console</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Console/Kernel.php'>Kernel.php</a></b></td>
							<td style='padding: 8px;'>- Defines the scheduling and registration of console commands within the application, enabling automated task execution and command management<br>- Serves as the central point for integrating scheduled jobs and custom commands, ensuring streamlined task orchestration aligned with the overall application architecture.</td>
						</tr>
					</table>
					<!-- Commands Submodule -->
					<details>
						<summary><b>Commands</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ app.Console.Commands</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Console/Commands/SyncUserBadges.php'>SyncUserBadges.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates the synchronization of user badges based on their total donation amounts, ensuring badge statuses accurately reflect user contributions<br>- Integrates with the BadgeService to update badges for all users with a donation history, supporting the platform’s goal of recognizing and rewarding user engagement within the broader application architecture.</td>
								</tr>
							</table>
						</blockquote>
					</details>
				</blockquote>
			</details>
			<!-- Models Submodule -->
			<details>
				<summary><b>Models</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Models</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/EmailVerification.php'>EmailVerification.php</a></b></td>
							<td style='padding: 8px;'>- Defines the EmailVerification model to manage email verification records within the application<br>- Facilitates storage of verification codes, associated emails, and expiration timestamps, enabling validation of email authenticity and expiration status<br>- Integrates seamlessly into user registration or authentication workflows, ensuring secure and timely email verification processes across the system.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/User.php'>User.php</a></b></td>
							<td style='padding: 8px;'>- Defines the User model within the application, encapsulating user attributes, authentication, and verification logic<br>- Manages relationships with wallets, transactions, and badges, enabling seamless user account handling and associated data interactions<br>- Ensures automatic wallet creation upon user registration, supporting core functionalities related to user identity, financial activities, and engagement within the overall system architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/Badge.php'>Badge.php</a></b></td>
							<td style='padding: 8px;'>- Defines the Badge model within the applications data layer, representing achievement markers linked to users<br>- Facilitates management of badge attributes such as name, minimum donation, and icon, while establishing relationships to associate badges with multiple users<br>- Serves as a core component for tracking and displaying user accomplishments within the broader system architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/Renungan.php'>Renungan.php</a></b></td>
							<td style='padding: 8px;'>- Defines the Renungan model representing reflections or meditations within the application, facilitating data management and relationships<br>- It enables associating each reflection with a user and multiple comments, supporting the core functionality of creating, retrieving, and managing user-generated content related to spiritual or personal reflections in the overall system architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/Wallet.php'>Wallet.php</a></b></td>
							<td style='padding: 8px;'>- Defines the Wallet model within the applications data layer, representing user financial accounts<br>- Facilitates management of user balances and establishes the relationship between wallets and users, supporting core functionalities related to user funds and transactions within the overall system architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/Donation.php'>Donation.php</a></b></td>
							<td style='padding: 8px;'>- Defines the Donation model representing fundraising campaigns within the application<br>- It manages core attributes such as title, description, goal amount, and collected funds, while establishing relationships to associated donation options<br>- Serves as a central data structure for tracking and organizing donation campaigns, facilitating the overall donation management and reporting functionalities of the platform.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/DonationOption.php'>DonationOption.php</a></b></td>
							<td style='padding: 8px;'>- Defines the DonationOption model, representing selectable donation amounts linked to specific donations within the applications architecture<br>- Facilitates management of multiple donation options per donation, enabling dynamic and flexible donation configurations<br>- Serves as a core component for handling donation options, ensuring proper relationships and data integrity in the overall donation management system.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/Transaction.php'>Transaction.php</a></b></td>
							<td style='padding: 8px;'>- Defines the Transaction model representing financial activities within the application<br>- Facilitates recording and managing user transactions linked to donations, enabling tracking of amounts, types, and descriptions<br>- Serves as a core component for handling monetary exchanges, ensuring proper associations with users and donations to support accurate financial reporting and auditability across the system.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Models/RenunganComment.php'>RenunganComment.php</a></b></td>
							<td style='padding: 8px;'>- Defines the data structure for user comments on reflections within the application, enabling users to add, associate, and manage their feedback on specific reflections<br>- Facilitates relational integrity between comments, reflections, and users, supporting interactive engagement and content moderation within the broader reflection and community features of the platform.</td>
						</tr>
					</table>
				</blockquote>
			</details>
			<!-- Services Submodule -->
			<details>
				<summary><b>Services</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Services</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Services/AlkitabService.php'>AlkitabService.php</a></b></td>
							<td style='padding: 8px;'>- Provides an interface to access biblical texts and search functionalities via external Alkitab APIs<br>- Facilitates retrieval of book lists, specific chapters, and search results across multiple API endpoints, ensuring flexible and reliable integration of biblical content within the broader application architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Services/BadgeService.php'>BadgeService.php</a></b></td>
							<td style='padding: 8px;'>- Manages user donation badges by evaluating total contributions and assigning the highest qualifying badge<br>- Ensures users are accurately recognized for their donation milestones, maintaining badge consistency within the overall user engagement and reward system<br>- This service supports the platform’s gamification and recognition features, fostering increased user participation and loyalty.</td>
						</tr>
					</table>
				</blockquote>
			</details>
			<!-- Providers Submodule -->
			<details>
				<summary><b>Providers</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Providers</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Providers/AppServiceProvider.php'>AppServiceProvider.php</a></b></td>
							<td style='padding: 8px;'>- Defines application-wide service bootstrapping, ensuring secure startup procedures by avoiding automatic privileged account creation<br>- Registers middleware aliases to enforce user authorization policies, contributing to the overall security and integrity of the applications architecture during initialization<br>- Handles database availability gracefully, maintaining stability across different deployment environments.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Providers/EventServiceProvider.php'>EventServiceProvider.php</a></b></td>
							<td style='padding: 8px;'>- Registers and manages event observers within the applications architecture, facilitating automatic handling of model lifecycle events<br>- Ensures that relevant actions are triggered in response to data changes, supporting decoupled and maintainable event-driven workflows across the system<br>- This setup enhances the modularity and responsiveness of the overall application.</td>
						</tr>
					</table>
				</blockquote>
			</details>
			<!-- Mail Submodule -->
			<details>
				<summary><b>Mail</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Mail</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Mail/EmailVerificationCode.php'>EmailVerificationCode.php</a></b></td>
							<td style='padding: 8px;'>- Facilitates the delivery of email verification codes within the applications user onboarding process<br>- It constructs and sends personalized email messages containing verification codes, supporting secure user authentication and account validation workflows across the system.</td>
						</tr>
					</table>
				</blockquote>
			</details>
			<!-- Http Submodule -->
			<details>
				<summary><b>Http</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Http</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Kernel.php'>Kernel.php</a></b></td>
							<td style='padding: 8px;'>- Defines the applications global and route-specific HTTP middleware, orchestrating request handling, security, session management, and access control within the Laravel architecture<br>- It ensures consistent application behavior, enforces security policies, and manages middleware groupings for web requests, forming a core component of the request lifecycle and overall system security.</td>
						</tr>
					</table>
					<!-- Controllers Submodule -->
					<details>
						<summary><b>Controllers</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ app.Http.Controllers</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/BibleController.php'>BibleController.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates retrieval and display of specific Bible passages by processing user input, querying a GraphQL API, and rendering the results within the applications view<br>- Integrates user requests with external biblical data sources, ensuring accurate passage fetching and error handling, thereby supporting the core functionality of Bible reference lookup within the overall application architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/DonationController.php'>DonationController.php</a></b></td>
									<td style='padding: 8px;'>- Manages donation campaigns, facilitating creation, updates, and deletions of donation boxes while enforcing admin-only access<br>- Handles user donations securely through transactional operations, updating wallet balances, recording transactions, and tracking progress toward campaign goals<br>- Integrates badge awarding based on donation milestones, fostering user engagement and recognition within the platforms broader donation and reward architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/RegisterController.php'>RegisterController.php</a></b></td>
									<td style='padding: 8px;'>- Handles user registration by validating input, creating new user accounts, generating and emailing email verification codes, and redirecting users to verify their email addresses<br>- This component ensures secure onboarding, integrates with the user model for wallet initialization, and maintains the registration flow within the overall authentication architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/VerificationController.php'>VerificationController.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates email verification workflows within the application by managing verification code generation, validation, and expiration<br>- Ensures secure user onboarding and account confirmation through email-based authentication, while seamlessly integrating with user sessions and email delivery systems to enhance account security and user experience.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/AlkitabController.php'>AlkitabController.php</a></b></td>
									<td style='padding: 8px;'>- Provides core functionality for retrieving and displaying biblical texts, supporting multiple versions and fallback options<br>- Manages user requests for book lists, chapters, and search queries, integrating external API data with local database storage<br>- Ensures flexible, reliable access to biblical content within the application’s architecture, facilitating seamless user interaction with scripture data.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/DashboardController.php'>DashboardController.php</a></b></td>
									<td style='padding: 8px;'>- Provides the main entry point for rendering the user-specific dashboard view within the web application<br>- It facilitates personalized content delivery by passing the authenticated users data to the dashboard interface, supporting the overall architecture of user-centric features and enhancing the user experience across the platform.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/Controller.php'>Controller.php</a></b></td>
									<td style='padding: 8px;'>- Defines a foundational abstract controller class that serves as a base for all HTTP controllers within the application<br>- It establishes a common structure and shared functionality, ensuring consistency and simplifying the development of specific controllers that handle user requests and orchestrate responses across the web applications architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/LoginController.php'>LoginController.php</a></b></td>
									<td style='padding: 8px;'>- Handles user authentication by validating login credentials, managing session regeneration, and directing users based on email verification status<br>- Ensures secure login flow, prompts email verification for unverified users with code generation and email delivery, and redirects authenticated users to the dashboard, supporting the overall security and user onboarding architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/ProfileController.php'>ProfileController.php</a></b></td>
									<td style='padding: 8px;'>- Provides user profile management functionalities, enabling profile name updates and secure password changes within the application<br>- Ensures validation, authentication, and password security, supporting seamless user account customization and maintaining data integrity in the overall system architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/RenunganController.php'>RenunganController.php</a></b></td>
									<td style='padding: 8px;'>- Manages the creation, display, editing, and deletion of reflective writings and their comments within the application<br>- Facilitates user interactions by handling content submission, moderation, and access control, thereby supporting community engagement and content management in the broader platform architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/WalletController.php'>WalletController.php</a></b></td>
									<td style='padding: 8px;'>- Manages user wallet operations including viewing balance and transaction history, ensuring wallet creation if absent<br>- Facilitates secure fund top-ups and withdrawals with transactional integrity, updating balances and recording transaction logs<br>- Integrates seamlessly into the applications architecture to support financial interactions, maintaining data consistency and user account security within the broader system.</td>
								</tr>
							</table>
							<!-- Admin Submodule -->
							<details>
								<summary><b>Admin</b></summary>
								<blockquote>
									<div class='directory-path' style='padding: 8px 0; color: #666;'>
										<code><b>⦿ app.Http.Controllers.Admin</b></code>
									<table style='width: 100%; border-collapse: collapse;'>
									<thead>
										<tr style='background-color: #f8f9fa;'>
											<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
											<th style='text-align: left; padding: 8px;'>Summary</th>
										</tr>
									</thead>
										<tr style='border-bottom: 1px solid #eee;'>
											<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/Admin/UserManagementController.php'>UserManagementController.php</a></b></td>
											<td style='padding: 8px;'>- Manages user administration within the application, enabling listing, searching, and pagination of user records, along with secure deletion of user accounts<br>- Ensures administrators can efficiently oversee user data while preventing self-deletion, supporting overall user management and system integrity in the admin interface.</td>
										</tr>
										<tr style='border-bottom: 1px solid #eee;'>
											<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Controllers/Admin/TransactionManagementController.php'>TransactionManagementController.php</a></b></td>
											<td style='padding: 8px;'>- Facilitates administrative management of transaction records by enabling listing, searching, and pagination of transactions within the admin interface<br>- Integrates user data for comprehensive insights and supports filtering transactions based on user email, ensuring efficient oversight and review of financial activities in the broader application architecture.</td>
										</tr>
									</table>
								</blockquote>
							</details>
						</blockquote>
					</details>
					<!-- Middleware Submodule -->
					<details>
						<summary><b>Middleware</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ app.Http.Middleware</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Middleware/EnsureUserIsAdmin.php'>EnsureUserIsAdmin.php</a></b></td>
									<td style='padding: 8px;'>- Enforces administrative access control within the applications middleware layer, ensuring that only users with the admin role can proceed with specific requests<br>- This component plays a critical role in maintaining security and proper authorization flow across the system, supporting the overall architecture by safeguarding sensitive operations and resources from unauthorized access.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Middleware/PreventBackHistory.php'>PreventBackHistory.php</a></b></td>
									<td style='padding: 8px;'>- Implements middleware to prevent browser back navigation after logout by disabling caching<br>- Ensures sensitive pages are not stored in cache, enhancing security and user session integrity within the applications overall architecture<br>- This component plays a crucial role in maintaining proper session management and safeguarding user data across the web interface.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Http/Middleware/RedirectIfAuthenticated.php'>RedirectIfAuthenticated.php</a></b></td>
									<td style='padding: 8px;'>- Enforces user redirection for authenticated sessions, ensuring logged-in users are directed to the dashboard to prevent access to guest-only pages<br>- Integrates seamlessly within the applications middleware stack, maintaining smooth navigation flow and enhancing security by managing user access based on authentication status across different guards.</td>
								</tr>
							</table>
						</blockquote>
					</details>
				</blockquote>
			</details>
			<!-- Service Submodule -->
			<details>
				<summary><b>Service</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ app.Service</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/app/Service/DonationService.php'>DonationService.php</a></b></td>
							<td style='padding: 8px;'>- Facilitates user donations by securely deducting funds, recording transactions, and ensuring data integrity through database transactions<br>- Additionally, manages badge awarding based on cumulative donation amounts, promoting user engagement and recognition within the applications ecosystem<br>- This service centralizes donation processing and badge management, supporting the platforms goal of fostering active user participation.</td>
						</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<!-- resources Submodule -->
	<details>
		<summary><b>resources</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ resources</b></code>
			<!-- views Submodule -->
			<details>
				<summary><b>views</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ resources.views</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/dashboard.blade.php'>dashboard.blade.php</a></b></td>
							<td style='padding: 8px;'>- Render the main dashboard view within the application, providing a welcoming interface for users<br>- It integrates the core layout component to ensure consistent styling and structure across the platform<br>- Serving as the entry point for user interactions, it facilitates navigation and access to key features within the overall web application architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/welcome.blade.php'>welcome.blade.php</a></b></td>
							<td style='padding: 8px;'>- Render the main welcome page layout within the application, providing users with an initial entry point to the website<br>- It integrates the core application structure and styling, establishing a consistent user interface for visitors<br>- This view serves as the foundation for the landing experience, guiding users into the broader features and content of the web platform.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/alkitab.blade.php'>alkitab.blade.php</a></b></td>
							<td style='padding: 8px;'>- Provides an interactive interface for exploring biblical texts by selecting versions, books, chapters, and verses, as well as performing search queries<br>- Facilitates dynamic content loading and rendering of scripture passages and search results, enabling users to navigate and access biblical content seamlessly within the application architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/profile.blade.php'>profile.blade.php</a></b></td>
							<td style='padding: 8px;'>- Provides a user profile interface within the application, enabling users to view personal details, update security settings such as password and two-factor authentication, and receive feedback on actions<br>- Serves as a central component for managing user account information, integrating profile display, validation messages, and security controls to enhance user account management and security posture.</td>
						</tr>
					</table>
					<!-- auth Submodule -->
					<details>
						<summary><b>auth</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.auth</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/auth/verify-code.blade.php'>verify-code.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates user email verification by providing an interface for entering and submitting a 6-digit code, displaying success or error messages, and allowing code resending<br>- Integrates into the authentication flow of the application, ensuring users confirm their email addresses to enhance account security and integrity within the overall system architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/auth/registration.blade.php'>registration.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates user registration by rendering a registration form integrated within the authentication flow<br>- It captures essential user details such as full name, email, and password, while providing validation feedback<br>- This component supports the overall architecture by enabling new user onboarding, ensuring seamless account creation within the applications authentication system.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/auth/verify_code.blade.php'>verify_code.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates user email verification by providing an interface for entering and submitting a 6-digit verification code<br>- Enables users to confirm their email addresses or request a resend of the code, supporting the overall authentication flow and ensuring secure account activation within the applications user onboarding process.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/auth/login.blade.php'>login.blade.php</a></b></td>
									<td style='padding: 8px;'>- Provides the user interface for the login process within the authentication flow, enabling users to input credentials and receive feedback on login success or errors<br>- Integrates seamlessly with the overall application architecture by connecting form submissions to backend authentication routes, facilitating secure user access and navigation between login and registration pages.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/auth/verification-notice.blade.php'>verification-notice.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates user email verification by displaying a styled notification page that automatically redirects authenticated users to the verification code input route, ensuring seamless progression within the authentication flow<br>- This component integrates visual branding and user experience elements while maintaining the overall architectures focus on secure, verified access to application features.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- profile Submodule -->
					<details>
						<summary><b>profile</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.profile</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/profile/show.blade.php'>show.blade.php</a></b></td>
									<td style='padding: 8px;'>- Provides a user profile interface enabling viewing and editing personal details, wallet information, badges, and security settings<br>- Facilitates profile updates, password changes, and toggling between account info and security views, ensuring a seamless user experience within the overall application architecture focused on user account management and personalization.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- renungan Submodule -->
					<details>
						<summary><b>renungan</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.renungan</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/renungan/edit.blade.php'>edit.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates editing of devotional entries within the application, enabling users to update titles and content seamlessly<br>- Integrates with the overall content management system to ensure devotional materials remain current and accurate<br>- Serves as a key interface for content modification, supporting the broader architectures goal of dynamic, user-driven content updates.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/renungan/renungan.php'>renungan.php</a></b></td>
									<td style='padding: 8px;'>- Render the main presentation layer for daily reflections within the application, facilitating user engagement with spiritual or motivational content<br>- It integrates seamlessly into the broader web interface, supporting content display and user interaction for the renungan feature, thereby enhancing the overall user experience and content accessibility in the project’s architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/renungan/renungan.blade.php'>renungan.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates user engagement with daily devotional content by providing an interface for creating, viewing, and managing devotionals<br>- Supports content submission, displays a list of devotionals with author details and badges, and enables editing or deletion for authorized users<br>- Integrates seamlessly into the overall application architecture, promoting spiritual reflection and community interaction.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/renungan/show.blade.php'>show.blade.php</a></b></td>
									<td style='padding: 8px;'>- Displays detailed view of a devotional entry, including its title, author, creation date, and content<br>- Facilitates user interactions such as editing, deleting, and commenting, with visual indicators of user badges<br>- Integrates comment management, badge display, and access controls, contributing to the overall content engagement and community interaction within the platform.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- wallet Submodule -->
					<details>
						<summary><b>wallet</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.wallet</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/wallet/index.blade.php'>index.blade.php</a></b></td>
									<td style='padding: 8px;'>- Provides a user interface for managing wallet functionalities, including viewing current balance, adding funds, withdrawing funds, and reviewing transaction history<br>- Integrates with backend routes to perform financial operations and displays real-time updates, ensuring seamless user experience in handling digital wallet activities within the broader application architecture.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- emails Submodule -->
					<details>
						<summary><b>emails</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.emails</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/emails/verification_code.blade.php'>verification_code.blade.php</a></b></td>
									<td style='padding: 8px;'>- Provides an email template for user verification within the authentication flow, facilitating email confirmation by delivering a personalized verification code<br>- It integrates seamlessly into the broader user onboarding process, ensuring secure account validation and enhancing user trust in the applications registration system<br>- This component supports the overall architecture by enabling reliable and user-friendly email verification.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- layouts Submodule -->
					<details>
						<summary><b>layouts</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.layouts</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/layouts/app.blade.php'>app.blade.php</a></b></td>
									<td style='padding: 8px;'>- Defines the primary layout structure for the applications web pages, establishing consistent branding, navigation, and user authentication interfaces<br>- Facilitates dynamic content rendering within the main layout, manages access to admin features, and integrates styles and scripts to ensure a cohesive user experience across the site<br>- Serves as the foundational template for rendering views within the overall architecture.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- components Submodule -->
					<details>
						<summary><b>components</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.components</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/components/app.blade.php'>app.blade.php</a></b></td>
									<td style='padding: 8px;'>- Defines the main layout template for the web application, establishing a consistent structure and styling across pages<br>- It manages the header navigation, user authentication links, and conditional content such as wallet balances on donation pages<br>- Serves as the foundational component that integrates visual elements, route-specific styles, and dynamic user data within the overall architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/components/loginregister.blade.php'>loginregister.blade.php</a></b></td>
									<td style='padding: 8px;'>- Defines a reusable login and registration form component within the authentication layout, streamlining user authentication workflows<br>- It facilitates consistent UI presentation and simplifies integration of login and registration functionalities across the application, ensuring a cohesive user experience while allowing customization of form content and navigation links.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/components/layout.blade.php'>layout.blade.php</a></b></td>
									<td style='padding: 8px;'>- Defines a reusable layout component that structures the overall HTML framework for the application’s pages<br>- It ensures consistent styling and layout across login and registration views by providing a common template with integrated CSS, facilitating a cohesive user interface and simplifying future updates to the page structure.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/components/auth-layout.blade.php'>auth-layout.blade.php</a></b></td>
									<td style='padding: 8px;'>- Defines a reusable authentication layout template that structures the visual presentation for login and registration pages within the application<br>- It ensures a consistent look and feel across authentication views by incorporating common styles, fonts, and metadata, thereby streamlining the development of secure user access interfaces aligned with the overall project architecture.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- donations Submodule -->
					<details>
						<summary><b>donations</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.donations</b></code>
							<table style='width: 100%; border-collapse: collapse;'>
							<thead>
								<tr style='background-color: #f8f9fa;'>
									<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
									<th style='text-align: left; padding: 8px;'>Summary</th>
								</tr>
							</thead>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/donations/edit.blade.php'>edit.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates editing of existing donation campaigns by providing a user interface for updating campaign details such as title, description, and target amount<br>- Integrates with the broader donation management system to ensure campaign information remains current and accurate, supporting seamless campaign modifications within the overall donation platform architecture.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/donations/detail.blade.php'>detail.blade.php</a></b></td>
									<td style='padding: 8px;'>- Displays detailed information and transaction history for individual donations within the campaign, enabling users to review target goals, total funds raised, and donor contributions<br>- Serves as a key component for transparency and donor engagement, integrating seamlessly into the overall donation management system by providing a comprehensive view of campaign performance and individual contributions.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/donations/create.blade.php'>create.blade.php</a></b></td>
									<td style='padding: 8px;'>- Facilitates the creation of new donation campaigns by providing a user interface for inputting campaign details such as title, description, and target amount<br>- Integrates with the overall donation management system, enabling users to initiate fundraising efforts within the platform<br>- Ensures a seamless experience for campaign setup, contributing to the broader donation workflow.</td>
								</tr>
								<tr style='border-bottom: 1px solid #eee;'>
									<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/donations/index.blade.php'>index.blade.php</a></b></td>
									<td style='padding: 8px;'>- Displays and manages donation campaigns, enabling users to view campaign details, progress, and contribute funds<br>- Administrators can create, edit, or delete campaigns, while users can make donations directly from campaign cards<br>- This view integrates campaign overview, user interactions, and administrative controls, serving as the central interface for donation management within the applications architecture.</td>
								</tr>
							</table>
						</blockquote>
					</details>
					<!-- admin Submodule -->
					<details>
						<summary><b>admin</b></summary>
						<blockquote>
							<div class='directory-path' style='padding: 8px 0; color: #666;'>
								<code><b>⦿ resources.views.admin</b></code>
							<!-- users Submodule -->
							<details>
								<summary><b>users</b></summary>
								<blockquote>
									<div class='directory-path' style='padding: 8px 0; color: #666;'>
										<code><b>⦿ resources.views.admin.users</b></code>
									<table style='width: 100%; border-collapse: collapse;'>
									<thead>
										<tr style='background-color: #f8f9fa;'>
											<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
											<th style='text-align: left; padding: 8px;'>Summary</th>
										</tr>
									</thead>
										<tr style='border-bottom: 1px solid #eee;'>
											<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/admin/users/index.blade.php'>index.blade.php</a></b></td>
											<td style='padding: 8px;'>- Provides an administrative user management interface, enabling authorized personnel to view, search, and delete users within the platform<br>- It displays user details such as name, email, role, wallet balance, and registration date, supporting efficient oversight and maintenance of user accounts in the overall application architecture.</td>
										</tr>
									</table>
								</blockquote>
							</details>
							<!-- transactions Submodule -->
							<details>
								<summary><b>transactions</b></summary>
								<blockquote>
									<div class='directory-path' style='padding: 8px 0; color: #666;'>
										<code><b>⦿ resources.views.admin.transactions</b></code>
									<table style='width: 100%; border-collapse: collapse;'>
									<thead>
										<tr style='background-color: #f8f9fa;'>
											<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
											<th style='text-align: left; padding: 8px;'>Summary</th>
										</tr>
									</thead>
										<tr style='border-bottom: 1px solid #eee;'>
											<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/views/admin/transactions/index.blade.php'>index.blade.php</a></b></td>
											<td style='padding: 8px;'>- Provides an administrative interface for managing and viewing transaction records, including search functionality and pagination<br>- It displays transaction details such as user info, transaction type, amount, description, and date, facilitating efficient oversight and auditing within the overall application architecture<br>- This view supports transparency and ease of access to financial activity data for administrators.</td>
										</tr>
									</table>
								</blockquote>
							</details>
						</blockquote>
					</details>
				</blockquote>
			</details>
			<!-- js Submodule -->
			<details>
				<summary><b>js</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ resources.js</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/js/app.js'>app.js</a></b></td>
							<td style='padding: 8px;'>- Facilitates interactive Bible exploration by managing dynamic content loading, chapter and verse navigation, and search functionalities within the web interface<br>- Integrates user selections with backend API calls to fetch and display scripture passages, enabling seamless browsing and searching of biblical texts<br>- Enhances user experience through real-time updates, smooth scrolling, and highlighting of selected verses.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/resources/js/bootstrap.js'>bootstrap.js</a></b></td>
							<td style='padding: 8px;'>- Sets up the Axios HTTP client for seamless AJAX communication across the application, ensuring consistent request headers and enabling secure, efficient server interactions within the broader web architecture<br>- This configuration facilitates reliable client-server data exchange, supporting dynamic content updates and API integrations essential for the applications responsiveness and functionality.</td>
						</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<!-- nginx Submodule -->
	<details>
		<summary><b>nginx</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ nginx</b></code>
			<!-- conf.d Submodule -->
			<details>
				<summary><b>conf.d</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ nginx.conf.d</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/nginx/conf.d/default.conf'>default.conf</a></b></td>
							<td style='padding: 8px;'>- Defines the web server configuration for routing HTTP requests, serving static assets, and directing PHP processing within the application architecture<br>- It ensures proper request handling, static content delivery, and PHP execution, facilitating seamless interaction between client requests and backend services in the overall system.</td>
						</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<!-- database Submodule -->
	<details>
		<summary><b>database</b></summary>
		<blockquote>
			<div class='directory-path' style='padding: 8px 0; color: #666;'>
				<code><b>⦿ database</b></code>
			<!-- factories Submodule -->
			<details>
				<summary><b>factories</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ database.factories</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/factories/UserFactory.php'>UserFactory.php</a></b></td>
							<td style='padding: 8px;'>- Defines user data templates for database seeding, enabling consistent creation of user records with realistic attributes<br>- Facilitates testing and development by generating diverse user instances, including verified and unverified email states, ensuring the database reflects real-world user scenarios within the applications architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/factories/DonationFactory.php'>DonationFactory.php</a></b></td>
							<td style='padding: 8px;'>- Defines a factory for generating mock donation data, facilitating testing and seeding of the database within the applications architecture<br>- It ensures realistic and varied donation records, supporting development workflows and data consistency across the project’s donation management features.</td>
						</tr>
					</table>
				</blockquote>
			</details>
			<!-- seeders Submodule -->
			<details>
				<summary><b>seeders</b></summary>
				<blockquote>
					<div class='directory-path' style='padding: 8px 0; color: #666;'>
						<code><b>⦿ database.seeders</b></code>
					<table style='width: 100%; border-collapse: collapse;'>
					<thead>
						<tr style='background-color: #f8f9fa;'>
							<th style='width: 30%; text-align: left; padding: 8px;'>File Name</th>
							<th style='text-align: left; padding: 8px;'>Summary</th>
						</tr>
					</thead>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/seeders/GutenbergKJVSeeder.php'>GutenbergKJVSeeder.php</a></b></td>
							<td style='padding: 8px;'>- Imports and processes the King James Version text from Project Gutenberg, transforming it into structured verse data<br>- It detects book, chapter, and verse boundaries, normalizes the content, and populates the database with individual verses<br>- This seeder facilitates comprehensive, searchable biblical text storage, supporting applications that require accurate and organized scripture data within the overall architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/seeders/DonationSeeder.php'>DonationSeeder.php</a></b></td>
							<td style='padding: 8px;'>- Seeds initial donation campaign data to populate the donations table with predefined projects, supporting the fundraising feature<br>- Ensures essential campaign entries are available for development, testing, or demonstration purposes, thereby facilitating the management and display of active donation initiatives within the broader application architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/seeders/BibleDatabaseSeeder.php'>BibleDatabaseSeeder.php</a></b></td>
							<td style='padding: 8px;'>- Seeds the database with sample Bible verses across multiple translations and chapters, establishing foundational biblical text data for the application<br>- Supports multilingual and multi-version access, enabling comprehensive biblical content management within the overall architecture<br>- Facilitates initial data setup for features involving scripture retrieval, comparison, or study tools.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/seeders/KJVImportSeeder.php'>KJVImportSeeder.php</a></b></td>
							<td style='padding: 8px;'>- Imports the King James Version (KJV) Bible verses into the database by sourcing data from a local JSON file or downloading from public repositories<br>- It normalizes various JSON structures into a consistent format and efficiently bulk inserts the verses into the database, enabling comprehensive access to the KJV text within the applications architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/seeders/DatabaseSeeder.php'>DatabaseSeeder.php</a></b></td>
							<td style='padding: 8px;'>- Provides the primary database seeding logic to initialize core application data, including biblical texts, importers, and donation information<br>- Ensures essential tables are populated with sample or imported data when empty, supporting consistent setup and testing of the applications data layer within the overall architecture.</td>
						</tr>
						<tr style='border-bottom: 1px solid #eee;'>
							<td style='padding: 8px;'><b><a href='https://github.com/unknownman77/ChristConnect/blob/master/database/seeders/RemoveTBSeeder.php'>RemoveTBSeeder.php</a></b></td>
							<td style='padding: 8px;'>- Removes all entries with the version tb from the bible_verses table, ensuring data consistency by eliminating outdated or unwanted translations<br>- This seeder supports database maintenance and data integrity within the broader architecture, which manages biblical text data across multiple versions and translations<br>- It facilitates clean data states for subsequent updates or migrations.</td>
						</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
</details>

---

## 🚀 Getting Started

### 📋 Prerequisites

This project requires the following dependencies:

- **Programming Language:** PHP
- **Package Manager:** Composer, Npm
- **Container Runtime:** Docker

### Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone <your-repository-url>
   cd ChristConnect
   ```

2. **Install PHP dependencies using Composer:**
   ```bash
   composer install
   ```

3. **Create your environment file:**
   Copy the example environment file. You will need to configure your database credentials in this new file.
   ```bash
   cp .env.example .env
   ```

4. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```

5. **Configure your database:**
   - Open the `.env` file in a text editor.
   - Update the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` options to match your local database configuration.

6. **Run database migrations:**
   This will create all the necessary tables in your database.
   ```bash
   php artisan migrate
   ```

7. **(Optional) Seed the database:**
   This will fill the database with initial data.
   ```bash
   php artisan db:seed
   ```

8. **Install JavaScript dependencies using NPM:**
   ```bash
   npm install
   ```

## Running the Application

You will need to have two terminal windows open simultaneously.

1. **Terminal 1: Start the Vite frontend development server:**
   This compiles and serves your frontend assets (CSS, JS).
   ```bash
   npm run dev
   ```

2. **Terminal 2: Start the PHP backend server:**
   This runs the main Laravel application.
   ```bash
   php artisan serve
   ```

3. **Access the website:**
   Open your web browser and navigate to the URL provided by `php artisan serve` (usually `http://127.0.0.1:8000`).



### Deploy (production) with Docker

Use the provided production compose file `docker-compose.prod.yml` to build images and run services (app, nginx, mysql). Do NOT commit production secrets — create a file named `.env.prod` on the server with production values (example keys below). Ensure `APP_KEY` and database credentials are set there.

Example `.env.prod` (DO NOT commit this file):

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your_generated_app_key_here
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=christconnect
DB_USERNAME=christconnect
DB_PASSWORD=verysecurepassword
MYSQL_ROOT_PASSWORD=verysecurepassword
```

Deploy steps (on the server):

```bash
# Build and start services
docker-compose -f docker-compose.prod.yml build --pull --no-cache
docker-compose -f docker-compose.prod.yml up -d

# Run migrations (one-time)
docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Seed donations or other non-sensitive seeders
docker-compose -f docker-compose.prod.yml exec app php artisan db:seed --class=DonationSeeder --force
```

Notes:
- The production compose mounts the project directory into containers to keep things simple for deployment; ensure the repo on the server is up-to-date and contains built assets. If you prefer fully immutable images (no bind mounts), let me know and I will change the compose to bake files into the image.
- If using this compose on a public server, ensure the server's firewall allows only the necessary ports (80/443) and secure the DB.
---

## 🤝 Contributing

- **💬 [Join the Discussions](https://github.com/unknownman77/ChristConnect/discussions)**: Share your insights, provide feedback, or ask questions.
- **🐛 [Report Issues](https://github.com/unknownman77/ChristConnect/issues)**: Submit bugs found or log feature requests for the `ChristConnect` project.
- **💡 [Submit Pull Requests](https://github.com/unknownman77/ChristConnect/blob/main/CONTRIBUTING.md)**: Review open PRs, and submit your own PRs.

<details closed>
<summary>Contributing Guidelines</summary>

1. **Fork the Repository**: Start by forking the project repository to your github account.
2. **Clone Locally**: Clone the forked repository to your local machine using a git client.
   ```sh
   git clone https://github.com/unknownman77/ChristConnect
   ```
3. **Create a New Branch**: Always work on a new branch, giving it a descriptive name.
   ```sh
   git checkout -b new-feature-x
   ```
4. **Make Your Changes**: Develop and test your changes locally.
5. **Commit Your Changes**: Commit with a clear message describing your updates.
   ```sh
   git commit -m 'Implemented new feature x.'
   ```
6. **Push to github**: Push the changes to your forked repository.
   ```sh
   git push origin new-feature-x
   ```
7. **Submit a Pull Request**: Create a PR against the original project repository. Clearly describe the changes and their motivations.
8. **Review**: Once your PR is reviewed and approved, it will be merged into the main branch. Congratulations on your contribution!
</details>

<details closed>
<summary>Contributor Graph</summary>
<br>
<p align="left">
   <a href="https://github.com{/unknownman77/ChristConnect/}graphs/contributors">
      <img src="https://contrib.rocks/image?repo=unknownman77/ChristConnect">
   </a>
</p>
</details>

---

## 📜 License

Christconnect is protected under the [LICENSE](https://choosealicense.com/licenses) License. For more details, refer to the [LICENSE](https://choosealicense.com/licenses/) file.

---

<div align="left"><a href="#top">⬆ Return</a></div>

---
