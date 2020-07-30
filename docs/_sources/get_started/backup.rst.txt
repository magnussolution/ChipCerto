******
Backup
******

É sempre uma boa ideia ter um backup.

Backup manual
^^^^^^^^^^^^^

O projeto ja conta com um script para fazer o backup do Banco de dados e dos arquivos do Asterisk.
Na instalaçao ja é adicionado o script no crontab do linux para que realize um backup por dia. Por padrao as 02:00.
O backup é salvo no diretorio /usr/local/src

Manualmente
^^^^^^^^^^^

Execute este comando no SHELL do seu servidor.
php /var/www/html/mbilling/cron.php Backup

Crontab
^^^^^^^

Configurando o crontab -e
 
::

 crontab -e

Procure a linha abaixo e altere para o horario desejado, ou comente a linha com ; para nao fazer backup automatico.

::

 0 2 * * * php /var/www/html/mbilling/cron.php Backup