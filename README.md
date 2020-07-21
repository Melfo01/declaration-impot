# Global informations
This repository call your bank account API to return all information required by Import and Urssaf.

**For now it works only with Qonto bank**

# Init project
Run `composer install`

Go to `config/config.php` and set your information. You can found all information in this [page](https://api-doc.qonto.eu/2.0/welcome/get-started#automating-your-own-business)
You can also create a `config/config.local.php` file to update your information without commit it.

When your application is set run `php public/index.php`

# Add an other bank API
**Feel free to contrubute**
Go to `Infrastructure` repository and create an other class who implements `BankHttpClientInterface`.
Switch your constructor parameters with `config/config.php` file and switch the parameters in `index.php`

