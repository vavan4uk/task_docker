# Time tracking source, Symfony 4.4<br />
https://github.com/vavan4uk/task3.git<br />
<br />
Technical Requirements<br />
Before installing application you must:<br />
<br />
Install PHP 7.4.13 and these PHP extensions (which are installed and enabled by default in most PHP 7 installations): Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer;<br />
Install Composer, which is used to install PHP packages.<br />
Optionally, you can also install Symfony CLI. This creates a binary called symfony that provides all the tools you need to develop and run your Symfony application locally.<br />
<br />
Before installation make sure that you have installed git/composer<br />
<br />
Installation<br />
cd ~/ <br />
git clone https://github.com/vavan4uk/task3.git task <br />
cd task <br />
symfony check:requirements <br />
composer install <br />
bin/console doctrine:database:create <br />
bin/console doctrine:schema:update --force <br />
symfony server:start <br />
<br />
<br />
<br />
<br />
For run functionality test ( after complete instalation ) <br />
cd ~/ <br />
cd task <br />
vendor/bin/codecept run --steps <br />