# Query for Craft CMS

This plugin lets users execute SQL queries and view their results in [Craft CMS](https://craftcms.com).

> **WARNING:** This plugin is for development purposes only and should not be installed in a production environment.

## Requirements

This plugin requires Craft CMS 4.0 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s control panel and search for “Query”. Then press **Install** in its modal window.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require craftcms/query

# tell Craft to install the plugin
./craft install/plugin query
```

## Usage

Execute SQL queries by navigating to **Utilities** → **Query** in the control panel.
